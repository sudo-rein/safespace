<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\RiskAssessment;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View


    
    
    {
        $urgentIds = RiskAssessment::where('urgent_flag', true)->select('incident_id');

        $urgent = Incident::whereIn('id', $urgentIds)
            ->whereIn('status', ['submitted', 'under_review'])
            ->latest('submitted_at')
            ->get();

        $stats = [
            'new' => Incident::where('status', 'submitted')->count(),
            'medium_high' => Incident::where('risk_level', 'medium_high')->count(),
            'low' => Incident::where('risk_level', 'low')->count(),
            'open_cases' => Incident::whereIn('status', ['case_opened', 'intervention', 'monitoring'])->count(),
        ];

        $recent = Incident::with(['location', 'assessment'])
            ->latest('submitted_at')
            ->take(8)
            ->get();

            $monthly = Incident::selectRaw("DATE_FORMAT(submitted_at, '%Y-%m') as month, COUNT(*) as total")
    ->where('submitted_at', '>=', now()->subMonths(5)->startOfMonth())
    ->groupBy('month')->orderBy('month')->pluck('total', 'month');

$byLocation = Incident::join('locations', 'locations.id', '=', 'incidents.location_id')
    ->selectRaw('locations.name as name, COUNT(*) as total')
    ->groupBy('locations.name')->orderByDesc('total')->limit(5)
    ->pluck('total', 'name');

$charts = [
    'monthly' => ['labels' => $monthly->keys()->values(), 'data' => $monthly->values()],
    'locations' => ['labels' => $byLocation->keys()->values(), 'data' => $byLocation->values()],
    'risk' => [$stats['low'], $stats['medium_high']],
];

        return view('counselor.dashboard', compact('urgent', 'stats', 'recent', 'charts'));
    }
    

    public function readNotification(string $id): \Illuminate\Http\RedirectResponse
{
    $notification = auth()->user()->notifications()->findOrFail($id);
    $notification->markAsRead();

    return redirect()->route('counselor.incidents.show', $notification->data['incident_id']);
}


}