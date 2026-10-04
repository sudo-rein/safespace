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
        Schema::create('incident_parties', function (Blueprint $table) {
    $table->id();
    $table->foreignId('incident_id')->constrained()->cascadeOnDelete();
    $table->foreignId('student_id')->nullable()->constrained()->nullOnDelete();
    $table->string('name_text')->nullable();
    $table->enum('role', ['victim', 'aggressor', 'witness']);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incident_parties');
    }
};
