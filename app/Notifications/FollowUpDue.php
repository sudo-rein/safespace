<?php

namespace App\Notifications;

use App\Models\FollowUp;
use Illuminate\Notifications\Notification;


use Illuminate\Support\Carbon;


class FollowUpDue extends Notification
{
    public function __construct(public FollowUp $followUp) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $incident = $this->followUp->caseFile->incident;

        return [
            'incident_id' => $incident->id,
            'tracking_code' => $incident->tracking_code,
            'message' => 'Follow-up due ' . Carbon::parse($this->followUp->due_date)->format('M d') . ' for ' . $incident->tracking_code,
            'level' => 'reminder',
        ];
    }
}