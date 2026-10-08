<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\CaseFile;
use App\Models\Incident;
use App\Models\RiskAssessment;
use App\Services\AuditLogger;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
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

        $from = \Illuminate\Support\Carbon::parse($data['from'])->startOfDay();
        $to = \Illuminate\Support\Carbon::parse($data['to'])->endOfDay();

        $base = fn () => Incident::whereBetween('submitted_at', [$from, $to]);

        $stats = [
            'total' => $base()->count(),
            'low' => $base()->where('risk_level', 'low')->count(),
            'medium_high' => $base()->where('risk_level', 'medium_high')->count(),
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
}