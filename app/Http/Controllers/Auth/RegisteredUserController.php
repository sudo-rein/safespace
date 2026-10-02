<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'lrn' => ['required', 'digits:12', 'unique:students,lrn', 'unique:users,lrn'],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'grade_level' => ['required', 'string', 'in:7,8,9,10,11,12'],
            'section' => ['required', 'string', 'max:50'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'privacy_consent' => ['accepted'],
        ], [
            'lrn.digits' => 'LRN must be exactly 12 digits.',
            'lrn.unique' => 'This LRN is already registered. If this is your LRN, please contact the guidance counselor.',
            'privacy_consent.accepted' => 'You must agree to the privacy notice to register.',
        ]);

        $user = DB::transaction(function () use ($request) {
            $student = Student::create([
                'lrn' => $request->lrn,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'grade_level' => $request->grade_level,
                'section' => $request->section,
                'school_year' => $this->currentSchoolYear(),
            ]);

            return User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'lrn' => $request->lrn,
                'password' => Hash::make($request->password),
                'role' => 'student',
                'student_id' => $student->id,
                'registered_at' => now(),
            ]);
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    private function currentSchoolYear(): string
    {
        // PH school year starts around June
        $year = now()->month >= 6 ? now()->year : now()->year - 1;

        return $year . '-' . ($year + 1);
    }
}