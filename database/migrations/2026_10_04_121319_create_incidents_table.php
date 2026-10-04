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
        Schema::create('incidents', function (Blueprint $table) {
    $table->id();
    $table->string('tracking_code')->unique();
    $table->foreignId('reporter_user_id')->constrained('users')->cascadeOnDelete();
    $table->enum('report_mode', ['named', 'confidential'])->default('confidential');
    $table->date('incident_date');
    $table->foreignId('location_id')->nullable()->constrained()->nullOnDelete();
    $table->text('description');
    $table->boolean('repeated')->default(false);
    $table->boolean('someone_hurt')->default(false);
    $table->enum('status', [
        'submitted', 'under_review', 'case_opened',
        'intervention', 'monitoring', 'resolved', 'closed', 'dismissed',
    ])->default('submitted');
    $table->enum('risk_level', ['low', 'medium_high'])->nullable();
    $table->enum('risk_source', ['system', 'counselor'])->nullable();
    $table->timestamp('submitted_at')->useCurrent();
    $table->softDeletes();
    $table->timestamps();
});
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
