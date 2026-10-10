<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #222; }
        h1 { font-size: 18px; margin-bottom: 2px; }
        h2 { font-size: 13px; margin: 18px 0 6px; border-bottom: 1px solid #999; padding-bottom: 2px; }
        .muted { color: #666; }
        table { width: 100%; border-collapse: collapse; }
        td, th { padding: 4px 6px; border-bottom: 1px solid #ddd; text-align: left; }
        .footer { margin-top: 30px; font-size: 10px; color: #888; }
    </style>
</head>
<body>
    <h1>SafeSpace Periodic Report</h1>
    <p class="muted">East Central Integrated School · {{ $from->format('M d, Y') }} to {{ $to->format('M d, Y') }}</p>

    <h2>Summary</h2>
    <table>
        <tr><th>Total reports</th><td>{{ $stats['total'] }}</td></tr>
        <tr><th>Low risk</th><td>{{ $stats['low'] }}</td></tr>
        <tr><th>Medium risk</th><td>{{ $stats['medium'] }}</td></tr>
        <tr><th>high risk</th><td>{{ $stats['high'] }}</td></tr>
        <tr><th>Urgent (self-harm indicators)</th><td>{{ $stats['urgent'] }}</td></tr>
        <tr><th>Cases opened</th><td>{{ $stats['cases_opened'] }}</td></tr>
        <tr><th>Cases closed</th><td>{{ $stats['cases_closed'] }}</td></tr>
        <tr><th>Cases open now</th><td>{{ $stats['cases_open_now'] }}</td></tr>
    </table>

    <h2>Reports by location</h2>
    <table>
        @forelse ($byLocation as $name => $total)
            <tr><td>{{ $name }}</td><td>{{ $total }}</td></tr>
        @empty
            <tr><td class="muted">No reports in this period.</td></tr>
        @endforelse
    </table>

    <h2>Reports by month</h2>
    <table>
        @forelse ($byMonth as $month => $total)
            <tr><td>{{ $month }}</td><td>{{ $total }}</td></tr>
        @empty
            <tr><td class="muted">No reports in this period.</td></tr>
        @endforelse
    </table>

    <p class="footer">Confidential. Generated {{ now()->format('M d, Y g:i A') }}. Data Privacy Act (RA 10173).</p>
</body>
</html>