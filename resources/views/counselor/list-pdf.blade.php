<!DOCTYPE html>
<html><head><meta charset="utf-8">
<style>
 body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #222; }
 h1 { font-size: 17px; color: #6b1a28; }
 table { width: 100%; border-collapse: collapse; }
 th, td { padding: 4px 6px; border-bottom: 1px solid #ddd; text-align: left; }
</style></head>
<body>
 <h1>SafeSpace Report List</h1>
 <p>East Central Integrated School · generated {{ now()->format('M d, Y g:i A') }} · reporter identities hidden</p>
 <table>
  <tr><th>Reference</th><th>Submitted</th><th>Place</th><th>Risk</th><th>Urgent</th><th>Status</th></tr>
  @foreach ($incidents as $i)
   <tr><td>{{ $i->tracking_code }}</td><td>{{ $i->submitted_at->format('M d, Y') }}</td>
       <td>{{ $i->location?->name }}</td><td>{{ ucfirst((string) $i->risk_level) }}</td>
       <td>{{ $i->assessment?->urgent_flag ? 'Yes' : 'No' }}</td>
       <td>{{ ucfirst(str_replace('_', ' ', $i->status)) }}</td></tr>
  @endforeach
 </table>
</body></html>