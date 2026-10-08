<?php

namespace App\Console\Commands;

use App\Models\FollowUp;
use App\Notifications\FollowUpDue;
use Illuminate\Console\Command;






class SendFollowUpReminders extends Command
{
    protected $signature = 'safespace:follow-up-reminders';
    protected $description = 'Notify counselors of follow-ups that are due or overdue';

    public function handle(): int
    {
        $due = FollowUp::with('caseFile.counselor', 'caseFile.incident')
            ->whereNull('done_at')
            ->whereNull('reminded_at')
            ->whereDate('due_date', '<=', today())
            ->get();

        foreach ($due as $followUp) {
    /** @var FollowUp $followUp */
    $counselor = $followUp->caseFile->counselor;

    if ($counselor && $followUp->caseFile->closed_at === null) {
        $counselor->notify(new FollowUpDue($followUp));
        $followUp->update(['reminded_at' => now()]);
    }
}
        $this->info("Sent {$due->count()} reminder(s).");

        return self::SUCCESS;
    }
}