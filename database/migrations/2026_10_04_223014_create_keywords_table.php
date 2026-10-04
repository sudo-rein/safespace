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
        Schema::create('keywords', function (Blueprint $table) {
    $table->id();
    $table->foreignId('category_id')->constrained('keyword_categories')->cascadeOnDelete();
    $table->string('word');
    $table->enum('language', ['fil', 'en', 'taglish'])->default('fil');
    $table->boolean('is_active')->default(true);
    $table->timestamps();

    $table->unique(['category_id', 'word']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keywords');
    }
};
