<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\User;
use App\Services\AuditLogger;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StudentDataController extends Controller
{
    public function index(Request $request): View
    {
        $students = User::where('role', 'student')
            ->when($request->query('q'), fn ($q, $term) => $q->where(
                fn ($w) => $w->where('lrn', 'like', "%$term%")->orWhere('name', 'like', "%$term%")
            ))
            ->orderBy('name')->limit(50)->get();

        return view('counselor.students', compact('students'));
    }

    public function export(User $user)
    {
        abort_unless($user->role === 'student', 404);

        $user->load('student');
        $incidents = Incident::with('location')
            ->where('reporter_user_id', $user->id)->latest('submitted_at')->get();

        AuditLogger::log('exported_student_data', $user);

        return Pdf::loadView('counselor.student-data-pdf', compact('user', 'incidents'))
            ->setPaper('a4')
            ->download('SafeSpace-Data-' . $user->lrn . '.pdf');
    }

    public function resetPassword(User $user): RedirectResponse
    {
        abort_unless($user->role === 'student', 404);

        $temp = Str::password(10, symbols: false);
        $user->update(['password' => $temp]);
        AuditLogger::log('reset_student_password', $user);

        return back()->with('status', "Temporary password for {$user->name}: {$temp} (tell the student to change it).");
    }

    public function toggleActive(User $user): RedirectResponse
    {
        abort_unless($user->role === 'student', 404);

        $user->update(['is_active' => ! $user->is_active]);
        AuditLogger::log($user->is_active ? 'activated_student' : 'deactivated_student', $user);

        return back()->with('status', 'Account updated.');
    }

    public function destroy(User $user): RedirectResponse
    {
        abort_unless($user->role === 'student', 404);

        AuditLogger::log('removed_student_account', $user);

        $student = $user->student;
        $user->delete();
        $student?->delete();

        return back()->with('status', 'Account removed. The real student can now register with that LRN.');
    }
}