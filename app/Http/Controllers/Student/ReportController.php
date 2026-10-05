<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\Location;
use App\Services\TrackingCodeGenerator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use App\Models\RiskAssessment;
use App\Services\RiskClassifier;

class ReportController extends Controller
{
    public function create(): View
    {
        return view('student.report-form', [
            'locations' => Location::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'report_mode' => ['required', 'in:confidential,named'],
            'incident_date' => ['required', 'date', 'before_or_equal:today'],
            'location_id' => ['required', 'exists:locations,id'],
            'description' => ['required', 'string', 'min:10', 'max:5000'],
            'repeated' => ['nullable', 'boolean'],
            'someone_hurt' => ['nullable', 'boolean'],
            'parties' => ['nullable', 'array', 'max:10'],
            'parties.*.name' => ['nullable', 'string', 'max:150'],
            'parties.*.role' => ['nullable', 'in:victim,aggressor,witness'],
            'evidence' => ['nullable', 'array', 'max:3'],
            'evidence.*' => ['file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ]);

        $incident = DB::transaction(function () use ($request, $data) {
            $incident = Incident::create([
                'tracking_code' => TrackingCodeGenerator::generate(),
                'reporter_user_id' => $request->user()->id,
                'report_mode' => $data['report_mode'],
                'incident_date' => $data['incident_date'],
                'location_id' => $data['location_id'],
                'description' => $data['description'],
                'repeated' => $request->boolean('repeated'),
                'someone_hurt' => $request->boolean('someone_hurt'),
                'status' => 'submitted',
                'submitted_at' => now(),
            ]);

            foreach ($data['parties'] ?? [] as $party) {
                if (! empty($party['name']) && ! empty($party['role'])) {
                    $incident->parties()->create([
                        'name_text' => $party['name'],
                        'role' => $party['role'],
                    ]);
                }
            }

            foreach ($request->file('evidence', []) as $file) {
                $path = $file->store('evidence/' . $incident->id, 'local');
                $incident->attachments()->create([
                    'file_path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                ]);
            }


           $result = app(RiskClassifier::class)->classify(
    $data['description'],
    $request->boolean('someone_hurt')
);

RiskAssessment::create([
    'incident_id' => $incident->id,
    'system_risk' => $result['risk'],
    'matched_words' => $result['matched_words'],
    'urgent_flag' => $result['urgent'],
    'reason' => $result['reason'],
]);

$incident->update([
    'risk_level' => $result['risk'],
    'risk_source' => 'system',
]);



            return $incident;
        });

        return redirect()->route('student.report.confirmation', $incident);
    }

    public function confirmation(Incident $incident): View
    {
        abort_unless($incident->reporter_user_id === auth()->id(), 403);

        return view('student.report-confirmation', ['incident' => $incident]);
    }

    public function index(): View
    {
        $incidents = Incident::where('reporter_user_id', auth()->id())
            ->latest('submitted_at')
            ->get();

        return view('student.my-reports', ['incidents' => $incidents]);
    }

    public function show(Incident $incident): View
    {
        Gate::authorize('view', $incident);

        $incident->load('location');

        return view('student.report-show', ['incident' => $incident]);
    }
}