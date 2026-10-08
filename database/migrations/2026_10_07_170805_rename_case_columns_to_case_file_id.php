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
    foreach (['case_notes', 'interventions', 'follow_ups'] as $table) {
        if (Schema::hasColumn($table, 'case_id') && ! Schema::hasColumn($table, 'case_file_id')) {
            Schema::table($table, function (Blueprint $t) use ($table) {
                $t->dropForeign([ 'case_id' ]);
                $t->renameColumn('case_id', 'case_file_id');
            });

            Schema::table($table, function (Blueprint $t) {
                $t->foreign('case_file_id')->references('id')->on('case_files')->cascadeOnDelete();
            });
        }
    }   
}

public function down(): void
{
    //
}
};
