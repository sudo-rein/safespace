<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #222; }
        h1 { font-size: 18px; margin-bottom: 2px; }
        h2 { font-size: 13px; margin: 18px 0 6px; border-bottom: 1px solid #999; padding-bottom: 2px; }
        .muted { color: #666; }
        .badge { padding: 2px 8px; border-radius: 8px; font-weight: bold; }
        .low { background: #fef9c3; color: #854d0e; }
        .high { background: #ffedd5; color: #9a3412; }
        table { width: 100%; border-collapse: collapse; }
        td, th { padding: 4px 6px; border-bottom: 1px solid #ddd; text-align: left; vertical-align: top; }
        .footer { margin-top: 30px; font-size: 10px; color: #888; }
    </style>
</head>
<body>
    <h1>SafeSpace Case Summary</h1>
    <p class="muted">East Central Integrated School · Reference {{ $case->incident->tracking_code }}</p>

    <h2>Overview</h2>
    <table>
        <tr><th>Risk level</th>
            <td>
                <span class="badge {{ $case->incident->risk_level === 'medium_high' ? 'high' : 'low' }}">
                    {{ $case->incident->risk_level === 'medium_high' ? 'Medium to High' : 'Low' }}
                </span>
            </td></tr>
        <tr><th>Incident date</th><td>{{ $case->incident->incident_date->format('M d, Y') }}</td></tr>
        <tr><th>Place</th><td>{{ $case->incident->location?->name }}</td></tr>
        <tr><th>Repeated</th><td>{{ $case->incident->repeated ? 'Yes' : 'No' }}</td></tr>
        <tr><th>Reporter</th><td>Confidential Reporter</td></tr>
        <tr><th>Case opened</th><td>{{ $case->opened_at->format('M d, Y') }}</td></tr>
        <tr><th>Status</th><td>{{ ucfirst(str_replace('_', ' ', $case->incident->status)) }}</td></tr>
        <tr><th>Handled by</th><td>{{ $case->counselor?->name }}</td></tr>
    </table>

    <h2>Report</h2>
    <p>{{ $case->incident->description }}</p>

    @if (! empty($case->incident->assessment?->matched_words))
        <p class="muted">Keywords matched:
            @foreach ($case->incident->assessment->matched_words as $m)
                {{ $m['word'] }}@if (! $loop->last), @endif
            @endforeach
        </p>
    @endif

    <h2>People involved</h2>
    @forelse ($case->incident->parties as $p)
        <p>{{ $p->name_text }} ({{ ucfirst($p->role) }})</p>
    @empty
        <p class="muted">None listed.</p>
    @endforelse

    <h2>Interventions</h2>
    @forelse ($case->interventions as $i)
        <p><strong>{{ ucfirst(str_replace('_', ' ', $i->type)) }}</strong>
           ({{ $i->intervention_date->format('M d, Y') }}) {{ $i->remarks }}</p>
    @empty
        <p class="muted">None logged.</p>
    @endforelse

    <h2>Follow-ups</h2>
    @forelse ($case->followUps as $f)
        <p>{{ $f->due_date->format('M d, Y') }} · {{ $f->done_at ? 'Done' : 'Pending' }} {{ $f->remarks }}</p>
    @empty
        <p class="muted">None scheduled.</p>
    @endforelse

    <h2>Outcome</h2>
    @if ($case->closed_at)
        <p>Closed {{ $case->closed_at->format('M d, Y') }}</p>
        <p>{{ $case->outcome }}</p>
    @else
        <p class="muted">Case still open.</p>
    @endif

    <p class="footer">
        Confidential document. Generated {{ now()->format('M d, Y g:i A') }}.
        Handle according to the Data Privacy Act (RA 10173).
    </p>
</body>
</html>