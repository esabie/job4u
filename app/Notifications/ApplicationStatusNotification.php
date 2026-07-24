<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationStatusNotification extends Notification
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

        return (new MailMessage)
            ->subject('Update on your application: '.$job->title)
            ->greeting('Hi '.$notifiable->name.',')
            ->line('The status of your application for '.$job->title.' at '.$job->company_name.' has been updated.')
            ->line('New status: '.ucfirst($this->application->status))
            ->action('View Application', route('candidate.applications.show', $this->application))
            ->line('You can turn these emails off anytime in your settings.');
    }
}
