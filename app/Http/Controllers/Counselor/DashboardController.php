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

        return view('counselor.dashboard', compact('urgent', 'stats', 'recent'));
    }
}