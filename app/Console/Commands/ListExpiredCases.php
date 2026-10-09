<?php

namespace App\Console\Commands;

use App\Models\CaseFile;
use Illuminate\Console\Command;

class ListExpiredCases extends Command
{
    protected $signature = 'safespace:expired-cases';
    protected $description = 'List closed cases past the retention period';
    

    public function handle(): int
    {
        $cutoff = now()->subYears(config('safespace.retention_years'));

        $cases = CaseFile::with('incident')
            ->whereNotNull('closed_at')
            ->where('closed_at', '<', $cutoff)
            ->get();

        foreach ($cases as $case) {
            $this->line($case->incident->tracking_code . ' closed ' . $case->closed_at->format('Y-m-d'));
        }

        $this->info($cases->count() . ' case(s) past retention.');

        return self::SUCCESS;
    }
}