<?php

namespace Database\Seeders;

use App\Models\Incident;
use App\Models\Location;
use App\Models\RiskAssessment;
use App\Models\Student;
use App\Models\User;
use App\Services\RiskClassifier;
use App\Services\TrackingCodeGenerator;
use Illuminate\Database\Seeder;

class DemoStudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            ['100000000001', 'Maria', 'Santos', '8', 'Rizal'],
            ['100000000002', 'Juan', 'Dela Cruz', '9', 'Bonifacio'],
            ['100000000003', 'Ana', 'Reyes', '7', 'Mabini'],
        ];

        $users = [];

        foreach ($students as [$lrn, $first, $last, $grade, $section]) {
            $student = Student::firstOrCreate(
                ['lrn' => $lrn],
                ['first_name' => $first, 'last_name' => $last, 'grade_level' => $grade,
                 'section' => $section, 'school_year' => '2026-2027']
            );

            $users[] = User::firstOrCreate(
                ['lrn' => $lrn],
                ['name' => "$first $last", 'password' => 'Demo#Pass2026', 'role' => 'student',
                 'student_id' => $student->id, 'registered_at' => now()]
            );
        }

        $reports = [
            [0, 'Canteen', 'Tinawag niya akong pangit at tanga kahapon', false, 'confidential', 6],
            [1, 'Hallway', 'Sinuntok ako ng kaklase ko sa hallway', false, 'confidential', 4],
            [2, 'Restroom', 'Pangit daw ako at ayoko na mabuhay', false, 'named', 1],
            [0, 'Online / Social Media', 'Sabi niya ikakalat ko picture mo', false, 'confidential', 2],
        ];

        $classifier = new RiskClassifier;

        foreach ($reports as [$i, $place, $text, $hurt, $mode, $daysAgo]) {
            $location = Location::firstOrCreate(['name' => $place]);

            if (Incident::where('description', $text)->exists()) {
                continue; // safe to re-run
            }

            $result = $classifier->classify($text, $hurt);

            $incident = Incident::create([
                'tracking_code' => TrackingCodeGenerator::generate(),
                'reporter_user_id' => $users[$i]->id,
                'report_mode' => $mode,
                'incident_date' => now()->subDays($daysAgo)->toDateString(),
                'location_id' => $location->id,
                'description' => $text,
                'repeated' => false,
                'someone_hurt' => $hurt,
                'status' => 'submitted',
                'risk_level' => $result['risk'],
                'risk_source' => 'system',
                'submitted_at' => now()->subDays($daysAgo),
            ]);

            RiskAssessment::create([
                'incident_id' => $incident->id,
                'system_risk' => $result['risk'],
                'matched_words' => $result['matched_words'],
                'urgent_flag' => $result['urgent'],
                'reason' => $result['reason'],
            ]);
        }
    }
}


// REMOVE IT ON REAL DEMO 
//HOWARD
