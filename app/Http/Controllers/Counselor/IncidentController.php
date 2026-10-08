<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\IncidentAttachment;
use App\Services\AuditLogger;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\RiskOverride;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    public function show(Incident $incident): View
    {
        $incident->load(['location', 'parties', 'attachments', 'assessment', 'reporter', 'overrides.counselor', 'caseFile']);
        
        AuditLogger::log('viewed_incident', $incident);
        // The reporter's name is shown on this page, so record the reveal.
        AuditLogger::log('revealed_reporter', $incident);

        $matched = collect($incident->assessment?->matched_words ?? []);

        return view('counselor.incident-detail', [
            'incident' => $incident,
            'matched' => $matched,
            'highlighted' => $this->highlight($incident->description, $matched->pluck('word')->all()),
        ]);
    }

  public function attachment(Incident $incident, IncidentAttachment $attachment)
{
    abort_unless($attachment->incident_id === $incident->id, 404);

    AuditLogger::log('viewed_attachment', $attachment);

    $path = Storage::disk('local')->path($attachment->file_path);

    abort_unless(file_exists($path), 404);

    return response()->file($path, [
        'Content-Disposition' => 'inline; filename="' . addslashes($attachment->original_name) . '"',
    ]);
}
    
    
public function overrideRisk(Request $request, Incident $incident): RedirectResponse
{
    $data = $request->validate([
        'new_risk' => ['required', 'in:low,medium_high'],
        'reason' => ['required', 'string', 'min:5', 'max:1000'],
    ]);

    if ($data['new_risk'] === $incident->risk_level) {
        return back()->withErrors(['new_risk' => 'The report is already at that risk level.']);
    }

    RiskOverride::create([
        'incident_id' => $incident->id,
        'counselor_id' => $request->user()->id,
        'old_risk' => $incident->risk_level,
        'new_risk' => $data['new_risk'],
        'reason' => $data['reason'],
    ]);

    $incident->update([
        'risk_level' => $data['new_risk'],
        'risk_source' => 'counselor',
    ]);

    AuditLogger::log('changed_risk_level', $incident);

    return back()->with('status', 'Risk level updated.');
}

    

    /** Escape the text first, then wrap matched words in <mark>. */
    private function highlight(string $text, array $words): string
    {
        $safe = e($text);

        usort($words, fn ($a, $b) => mb_strlen($b) <=> mb_strlen($a));

        foreach ($words as $word) {
            $pattern = '/(?<![\p{L}\p{N}])(' . preg_quote(e($word), '/') . ')(?![\p{L}\p{N}])/iu';
            $safe = preg_replace($pattern, '<mark class="bg-yellow-200 px-1 rounded">$1</mark>', $safe);
        }

        return $safe;
    }
}