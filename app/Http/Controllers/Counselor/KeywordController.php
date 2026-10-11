<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Keyword;
use App\Models\KeywordCategory;
use App\Services\AuditLogger;
use App\Services\RiskClassifier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KeywordController extends Controller
{
    public function index(Request $request): View
    {
        $categories = KeywordCategory::with(['keywords' => fn ($q) => $q->orderBy('word')])->get();

        $result = null;
        $sample = $request->query('sample');
        if ($sample) {
            $result = (new RiskClassifier)->classify($sample);
        }

        return view('counselor.keywords', compact('categories', 'result', 'sample'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:keyword_categories,id'],
            'word' => ['required', 'string', 'min:2', 'max:100'],
        ]);

        $word = mb_strtolower(trim($data['word']));

        if (Keyword::where('category_id', $data['category_id'])->where('word', $word)->exists()) {
            return back()->withErrors(['word' => 'That word is already in this category.']);
        }

        $k = Keyword::create([
            'category_id' => $data['category_id'],
            'word' => $word,
            'language' => 'taglish',
            'is_active' => true,
        ]);

        AuditLogger::log('added_keyword', $k);

        return back()->with('status', 'Word added.');
    }

    public function toggle(Keyword $keyword): RedirectResponse
    {
        $keyword->update(['is_active' => ! $keyword->is_active]);
        AuditLogger::log('toggled_keyword', $keyword);

        return back();
    }

    public function destroy(Keyword $keyword): RedirectResponse
    {
        AuditLogger::log('deleted_keyword', $keyword);
        $keyword->delete();

        return back()->with('status', 'Word deleted.');
    }
}