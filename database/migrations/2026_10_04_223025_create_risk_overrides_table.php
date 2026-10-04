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
        Schema::create('risk_overrides', function (Blueprint $table) {
    $table->id();
    $table->foreignId('incident_id')->constrained()->cascadeOnDelete();
    $table->foreignId('counselor_id')->constrained('users')->cascadeOnDelete();
    $table->enum('old_risk', ['low', 'medium_high']);
    $table->enum('new_risk', ['low', 'medium_high']);
    $table->text('reason');
    $table->timestamps();
});
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risk_overrides');
    }
};
