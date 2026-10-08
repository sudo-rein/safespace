<?php

namespace App\Notifications;

use App\Models\Incident;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UrgentIncidentAlert extends Notification
{
    public function __construct(public Incident $incident) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('URGENT: SafeSpace self-harm indicators')
            ->line('A report contains self-harm indicators. Please review it immediately.')
            ->line('Reference: ' . $this->incident->tracking_code)
            ->action('Open urgent report', route('counselor.incidents.show', $this->incident));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'incident_id' => $this->incident->id,
            'tracking_code' => $this->incident->tracking_code,
            'message' => 'URGENT: self-harm indicators in ' . $this->incident->tracking_code,
            'level' => 'urgent',
        ];
    }
}