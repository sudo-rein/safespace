<?php

namespace Tests\Feature;

use App\Models\Incident;
use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccessControlTest extends TestCase
{
    use RefreshDatabase;

    private function student(string $lrn): User
    {
        return User::create([
            'name' => 'Student ' . $lrn, 'lrn' => $lrn,
            'password' => 'Password#123', 'role' => 'student',
        ]);
    }

    private function counselor(): User
    {
        return User::create([
            'name' => 'Counselor', 'email' => 'c@test.ph',
            'password' => 'Password#123', 'role' => 'counselor',
        ]);
    }

    private function incidentFor(User $reporter): Incident
    {
        $loc = Location::firstOrCreate(['name' => 'Canteen']);

        return Incident::create([
            'tracking_code' => 'SS-TEST-' . rand(1000, 9999),
            'reporter_user_id' => $reporter->id,
            'report_mode' => 'confidential',
            'incident_date' => now()->toDateString(),
            'location_id' => $loc->id,
            'description' => 'Test report text here',
            'status' => 'submitted',
            'risk_level' => 'low',
            'submitted_at' => now(),
        ]);
    }

    public function test_student_cannot_open_counselor_pages(): void
    {
        $this->actingAs($this->student('111111111111'))
            ->get('/counselor')->assertForbidden();
    }

    public function test_counselor_cannot_open_student_pages(): void
    {
        $this->actingAs($this->counselor())
            ->get('/student')->assertForbidden();
    }

    public function test_student_cannot_read_another_students_report(): void
    {
        $owner = $this->student('111111111111');
        $other = $this->student('222222222222');
        $incident = $this->incidentFor($owner);

        $this->actingAs($other)
            ->get("/student/reports/{$incident->id}")->assertForbidden();
    }

    public function test_student_can_read_own_report(): void
    {
        $owner = $this->student('111111111111');
        $incident = $this->incidentFor($owner);

        $this->actingAs($owner)
            ->get("/student/reports/{$incident->id}")->assertOk();
    }

    public function test_counselor_sees_reporter_and_reveal_is_logged(): void
    {
        $owner = $this->student('111111111111');
        $incident = $this->incidentFor($owner);

        $this->actingAs($this->counselor())
            ->get("/counselor/incidents/{$incident->id}")
            ->assertOk()
            ->assertSee('Student 111111111111');

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'revealed_reporter',
            'subject_id' => $incident->id,
        ]);
    }

    public function test_duplicate_lrn_registration_is_rejected(): void
    {
        $this->student('333333333333');

        $this->post('/register', [
            'lrn' => '333333333333', 'first_name' => 'A', 'last_name' => 'B',
            'grade_level' => '8', 'section' => 'Rizal',
            'password' => 'Password#123', 'password_confirmation' => 'Password#123',
            'privacy_consent' => '1',
        ])->assertSessionHasErrors('lrn');
    }
}