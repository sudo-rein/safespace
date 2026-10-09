<?php

namespace Tests\Feature;

use App\Services\RiskClassifier;
use Database\Seeders\KeywordSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RiskClassifierTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(KeywordSeeder::class);
    }

    public function test_insults_only_are_low(): void
    {
        $r = (new RiskClassifier)->classify('Kept calling me ugly and stupid');
        $this->assertSame('low', $r['risk']);
    }

    public function test_filipino_insults_are_low(): void
    {
        $r = (new RiskClassifier)->classify('Pangit ka daw, tanga pa');
        $this->assertSame('low', $r['risk']);
    }

    public function test_physical_word_is_medium_high(): void
    {
        $r = (new RiskClassifier)->classify('Sinuntok ako sa canteen');
        $this->assertSame('medium_high', $r['risk']);
    }

    public function test_weapon_word_is_medium_high(): void
    {
        $r = (new RiskClassifier)->classify('May dala siyang kutsilyo');
        $this->assertSame('medium_high', $r['risk']);
    }

    public function test_self_harm_sets_urgent_flag(): void
    {
        $r = (new RiskClassifier)->classify('Pinagtatawanan nila ako, ayoko na mabuhay');
        $this->assertSame('medium_high', $r['risk']);
        $this->assertTrue($r['urgent']);
    }

    public function test_insult_plus_self_harm_is_not_downgraded(): void
    {
        $r = (new RiskClassifier)->classify('They call me ugly and I want to die');
        $this->assertSame('medium_high', $r['risk']);
    }

    public function test_whole_word_matching_avoids_false_hits(): void
    {
        $r = (new RiskClassifier)->classify('The white wall');
        $this->assertSame('low', $r['risk']);
    }

    public function test_someone_hurt_checkbox_forces_medium_high(): void
    {
        $r = (new RiskClassifier)->classify('Nagkagulo kami kanina', true);
        $this->assertSame('medium_high', $r['risk']);
    }
}