<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewApplicationNotification extends Notification
{
    use Queueable;

    public function __construct(public Application $application)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $job = $this->application->job;
        $candidate = $this->application->candidate;

        return (new MailMessage)
            ->subject('New application for '.$job->title)
            ->greeting('Hi '.$notifiable->name.',')
            ->line($candidate->name.' has applied for '.$job->title.' at '.$job->company_name.'.')
            ->action('View Application', route('employer.applications.show', $this->application))
            ->line('You can turn these emails off anytime in your settings.');
    }
}
