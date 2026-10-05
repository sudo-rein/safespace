<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewQueueController extends Controller
{
    public function index(Request $request): View
    {
        $query = Incident::with(['location', 'assessment']);

        if (in_array($request->query('risk'), ['low', 'medium_high'], true)) {
            $query->where('risk_level', $request->query('risk'));
        }

        // urgent first, then medium-high, then newest
        $incidents = $query->get()->sortBy([
            fn ($a, $b) => (int) ($b->assessment?->urgent_flag) <=> (int) ($a->assessment?->urgent_flag),
            fn ($a, $b) => ($b->risk_level === 'medium_high') <=> ($a->risk_level === 'medium_high'),
            fn ($a, $b) => $b->submitted_at <=> $a->submitted_at,
        ])->values();

        return view('counselor.review-queue', compact('incidents'));
    }
}