<?php

namespace App\Notifications;

use App\Models\Incident;
use Illuminate\Notifications\Notification;

class NewChatMessage extends Notification
{
    public function __construct(public Incident $incident) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'incident_id' => $this->incident->id,
            'tracking_code' => $this->incident->tracking_code,
            'message' => 'New message on ' . $this->incident->tracking_code,
            'level' => 'message',
        ];
    }
}