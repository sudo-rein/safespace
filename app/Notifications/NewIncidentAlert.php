<?php

namespace App\Notifications;

use App\Models\Incident;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewIncidentAlert extends Notification
{
    public function __construct(public Incident $incident) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $level = ucfirst($this->incident->risk_level);

        return (new MailMessage)
            ->subject("SafeSpace: new {$level} risk report")
            ->line("A new {$level} risk report was submitted.")
            ->line('Reference: ' . $this->incident->tracking_code)
            ->action('Review report', route('counselor.incidents.show', $this->incident));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'incident_id' => $this->incident->id,
            'tracking_code' => $this->incident->tracking_code,
            'message' => 'New ' . ucfirst($this->incident->risk_level) . ' risk report ' . $this->incident->tracking_code,
            'level' => $this->incident->risk_level,
        ];
    }
}