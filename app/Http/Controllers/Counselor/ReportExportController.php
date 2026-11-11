<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\CaseFile;
use App\Models\Incident;
use App\Models\RiskAssessment;
use App\Services\AuditLogger;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class ReportExportController extends Controller
{
    public function index(): View
    {
        return view('counselor.reports');
    }

    public function periodic(Request $request)
    {
        $data = $request->validate([
            'from' => ['required', 'date'],
            'to' => ['required', 'date', 'after_or_equal:from'],
        ]);

        $from = Carbon::parse($data['from'])->startOfDay();
        $to = Carbon::parse($data['to'])->endOfDay();

        $base = fn () => Incident::whereBetween('submitted_at', [$from, $to]);

        $stats = [
            'total' => $base()->count(),
            'low' => $base()->where('risk_level', 'low')->count(),
            'medium' => $base()->where('risk_level', 'medium')->count(),
            'high' => $base()->where('risk_level', 'high')->count(),
            'urgent' => RiskAssessment::where('urgent_flag', true)
                ->whereIn('incident_id', $base()->select('id'))->count(),
            'cases_opened' => CaseFile::whereBetween('opened_at', [$from, $to])->count(),
            'cases_closed' => CaseFile::whereBetween('closed_at', [$from, $to])->count(),
            'cases_open_now' => CaseFile::whereNull('closed_at')->count(),
        ];

        $byLocation = Incident::join('locations', 'locations.id', '=', 'incidents.location_id')
            ->whereBetween('incidents.submitted_at', [$from, $to])
            ->selectRaw('locations.name as name, COUNT(*) as total')
            ->groupBy('locations.name')->orderByDesc('total')
            ->pluck('total', 'name');

        $byMonth = Incident::whereBetween('submitted_at', [$from, $to])
            ->selectRaw("DATE_FORMAT(submitted_at, '%Y-%m') as month, COUNT(*) as total")
            ->groupBy('month')->orderBy('month')
            ->pluck('total', 'month');

        AuditLogger::log('exported_periodic_report');

        return Pdf::loadView('counselor.periodic-pdf', compact('stats', 'byLocation', 'byMonth', 'from', 'to'))
            ->setPaper('a4')
            ->download('SafeSpace-Report-' . $from->format('Ymd') . '-' . $to->format('Ymd') . '.pdf');
    }

    public function list(Request $request)
    {
        $data = $request->validate([
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from'],
            'risk' => ['nullable', 'in:low,medium,high'],
            'format' => ['required', 'in:pdf,csv'],
        ]);

        $incidents = Incident::with(['location', 'assessment'])
            ->when($data['from'] ?? null, fn ($q, $d) => $q->whereDate('submitted_at', '>=', $d))
            ->when($data['to'] ?? null, fn ($q, $d) => $q->whereDate('submitted_at', '<=', $d))
            ->when($data['risk'] ?? null, fn ($q, $r) => $q->where('risk_level', $r))
            ->latest('submitted_at')->get();

        AuditLogger::log('exported_report_list');

        if ($data['format'] === 'pdf') {
            return Pdf::loadView('counselor.list-pdf', compact('incidents'))
                ->setPaper('a4', 'landscape')->download('SafeSpace-Report-List.pdf');
        }

        return response()->streamDownload(function () use ($incidents) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['Reference', 'Submitted', 'Incident date', 'Time', 'Place', 'Risk', 'Urgent', 'Status']);
            foreach ($incidents as $i) {
                fputcsv($out, [
                    $i->tracking_code, $i->submitted_at->format('Y-m-d H:i'), Carbon::parse($i->incident_date)->format('Y-m-d'),
                    $i->incident_time, $i->location?->name, ucfirst((string) $i->risk_level),
                    $i->assessment?->urgent_flag ? 'Yes' : 'No', ucfirst(str_replace('_', ' ', $i->status)),
                ]);
            }
            fclose($out);
        }, 'SafeSpace-Report-List.csv', ['Content-Type' => 'text/csv']);
    }
}