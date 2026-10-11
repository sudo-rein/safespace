<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\KeywordSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatbotTest extends TestCase
{
    use RefreshDatabase;

    private function student(): User
    {
        return User::create([
            'name' => 'Student', 'lrn' => '444444444444',
            'password' => 'Password#123', 'role' => 'student',
        ]);
    }

    public function test_self_harm_message_returns_crisis_response(): void
    {
        $this->seed(KeywordSeeder::class);

        $this->actingAs($this->student())
            ->postJson('/student/chatbot', ['message' => 'ayoko na mabuhay'])
            ->assertOk()
            ->assertJson(['crisis' => true]);
    }

    public function test_how_to_report_question_gets_an_answer(): void
    {
        $this->seed(KeywordSeeder::class);

        $this->actingAs($this->student())
            ->postJson('/student/chatbot', ['message' => 'how to report'])
            ->assertOk()
            ->assertJson(['crisis' => false]);
    }

    public function test_counselor_cannot_use_student_chatbot(): void
    {
        $counselor = User::create([
            'name' => 'Counselor', 'email' => 'c2@test.ph',
            'password' => 'Password#123', 'role' => 'counselor',
        ]);

        $this->actingAs($counselor)
            ->postJson('/student/chatbot', ['message' => 'hello'])
            ->assertForbidden();
    }
}