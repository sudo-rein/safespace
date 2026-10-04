<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('risk_assessments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('incident_id')->constrained()->cascadeOnDelete();
    $table->enum('system_risk', ['low', 'medium_high']);
    $table->json('matched_words')->nullable();
    $table->boolean('urgent_flag')->default(false);
    $table->string('reason')->nullable();
    $table->timestamps();
}); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risk_assessments');
    }
};
