<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #222; }
        h1 { font-size: 18px; }
        h2 { font-size: 13px; border-bottom: 1px solid #999; margin-top: 18px; }
        table { width: 100%; border-collapse: collapse; }
        td, th { padding: 4px 6px; border-bottom: 1px solid #ddd; text-align: left; }
    </style>
</head>
<body>
    <h1>SafeSpace: Personal Data Export</h1>
    <p>Generated {{ now()->format('M d, Y g:i A') }} for a data access request (RA 10173).</p>

    <h2>Account</h2>
    <table>
        <tr><th>Name</th><td>{{ $user->name }}</td></tr>
        <tr><th>LRN</th><td>{{ $user->lrn }}</td></tr>
        <tr><th>Grade / Section</th><td>{{ $user->student?->grade_level }} / {{ $user->student?->section }}</td></tr>
        <tr><th>Registered</th><td>{{ $user->registered_at?->format('M d, Y') }}</td></tr>
    </table>

    <h2>Reports submitted by this student</h2>
    @forelse ($incidents as $i)
        <p><strong>{{ $i->tracking_code }}</strong> · {{ $i->submitted_at->format('M d, Y') }} · {{ $i->location?->name }}<br>{{ $i->description }}</p>
    @empty
        <p>No reports submitted.</p>
    @endforelse
</body>
</html>