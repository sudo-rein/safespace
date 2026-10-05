<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\IncidentAttachment;
use App\Services\AuditLogger;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class IncidentController extends Controller
{
    public function show(Incident $incident): View
    {
        $incident->load(['location', 'parties', 'attachments', 'assessment', 'reporter']);

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

    public function attachment(Incident $incident, IncidentAttachment $attachment): StreamedResponse
    {
        abort_unless($attachment->incident_id === $incident->id, 404);

        AuditLogger::log('viewed_attachment', $attachment);

        return Storage::disk('local')->response(
            $attachment->file_path,
            $attachment->original_name
        );
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