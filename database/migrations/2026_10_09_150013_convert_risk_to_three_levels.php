<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE keyword_categories MODIFY severity_group VARCHAR(20) NOT NULL");
        DB::statement("ALTER TABLE incidents MODIFY risk_level VARCHAR(20) NULL");
        DB::statement("ALTER TABLE risk_assessments MODIFY system_risk VARCHAR(20) NOT NULL");
        DB::statement("ALTER TABLE risk_overrides MODIFY old_risk VARCHAR(20) NOT NULL");
        DB::statement("ALTER TABLE risk_overrides MODIFY new_risk VARCHAR(20) NOT NULL");

        // Keyword categories
        DB::table('keyword_categories')->where('severity_group', 'medium_high')->update(['severity_group' => 'medium']);
        DB::table('keyword_categories')->whereIn('name', ['Threats', 'Weapons', 'Self-harm', 'Sexual'])
            ->update(['severity_group' => 'high']);

        // Existing reports: urgent ones become High, the rest Medium
        $urgentIds = DB::table('risk_assessments')->where('urgent_flag', true)->pluck('incident_id');

        DB::table('incidents')->where('risk_level', 'medium_high')->update(['risk_level' => 'medium']);
        DB::table('incidents')->whereIn('id', $urgentIds)->update(['risk_level' => 'high']);

        DB::table('risk_assessments')->where('system_risk', 'medium_high')->update(['system_risk' => 'medium']);
        DB::table('risk_assessments')->whereIn('incident_id', $urgentIds)->update(['system_risk' => 'high']);

        DB::table('risk_overrides')->where('old_risk', 'medium_high')->update(['old_risk' => 'medium']);
        DB::table('risk_overrides')->where('new_risk', 'medium_high')->update(['new_risk' => 'medium']);
    }

    public function down(): void
    {
        //
    }
};