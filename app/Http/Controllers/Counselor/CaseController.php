<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\CaseFile;
use App\Models\Incident;
use App\Services\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CaseController extends Controller
{
    public function open(Request $request, Incident $incident): RedirectResponse
    {
        if ($incident->caseFile) {
            return redirect()->route('counselor.cases.show', $incident->caseFile);
        }

        $case = DB::transaction(function () use ($request, $incident) {
            $case = CaseFile::create([
                'incident_id' => $incident->id,
                'counselor_id' => $request->user()->id,
                'opened_at' => now(),
            ]);

            $incident->update(['status' => 'case_opened']);

            return $case;
        });

        AuditLogger::log('opened_case', $case);

        return redirect()->route('counselor.cases.show', $case);
    }

    public function show(CaseFile $case): View
    {
        $case->load(['incident.location', 'notes.counselor', 'interventions', 'followUps']);

        AuditLogger::log('viewed_case', $case);

        return view('counselor.case-workspace', ['case' => $case]);
    }

    public function addNote(Request $request, CaseFile $case): RedirectResponse
    {
        $this->ensureOpen($case);

        $data = $request->validate([
            'note' => ['required', 'string', 'min:3', 'max:5000'],
        ]);

        $case->notes()->create([
            'counselor_id' => $request->user()->id,
            'note' => $data['note'],
        ]);

        AuditLogger::log('added_case_note', $case);

        return back()->with('status', 'Note added.');
    }

    public function addIntervention(Request $request, CaseFile $case): RedirectResponse
    {
        $this->ensureOpen($case);

        $data = $request->validate([
            'type' => ['required', 'in:counseling,parent_conference,mediation,referral,other'],
            'intervention_date' => ['required', 'date', 'before_or_equal:today'],
            'remarks' => ['nullable', 'string', 'max:2000'],
        ]);

        $case->interventions()->create($data);

        // First intervention moves the report to the Intervention stage
        if ($case->incident->status === 'case_opened') {
            $case->incident->update(['status' => 'intervention']);
        }

        AuditLogger::log('added_intervention', $case);

        return back()->with('status', 'Intervention logged.');
    }

    public function addFollowUp(Request $request, CaseFile $case): RedirectResponse
    {
        $this->ensureOpen($case);

        $data = $request->validate([
            'due_date' => ['required', 'date', 'after_or_equal:today'],
            'remarks' => ['nullable', 'string', 'max:1000'],
        ]);

        $case->followUps()->create($data);

        AuditLogger::log('added_follow_up', $case);

        return back()->with('status', 'Follow-up scheduled.');
    }

    public function completeFollowUp(Request $request, CaseFile $case, int $followUp): RedirectResponse
    {
        $item = $case->followUps()->findOrFail($followUp);

        $item->update(['done_at' => now()]);

        AuditLogger::log('completed_follow_up', $case);

        return back()->with('status', 'Follow-up marked done.');
    }

    public function updateStatus(Request $request, CaseFile $case): RedirectResponse
    {
        $this->ensureOpen($case);

        $data = $request->validate([
            'status' => ['required', 'in:case_opened,intervention,monitoring,resolved'],
        ]);

        $case->incident->update(['status' => $data['status']]);

        AuditLogger::log('changed_case_status', $case);

        return back()->with('status', 'Status updated.');
    }

    public function close(Request $request, CaseFile $case): RedirectResponse
    {
        $this->ensureOpen($case);

        $data = $request->validate([
            'outcome' => ['required', 'string', 'min:5', 'max:3000'],
        ]);

        DB::transaction(function () use ($case, $data) {
            $case->update([
                'closed_at' => now(),
                'outcome' => $data['outcome'],
            ]);

            $case->incident->update(['status' => 'closed']);
        });

        AuditLogger::log('closed_case', $case);

        return back()->with('status', 'Case closed.');
    }

    private function ensureOpen(CaseFile $case): void
    {
        abort_if($case->closed_at !== null, 403, 'This case is closed.');
    }
}