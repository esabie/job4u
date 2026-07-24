<?php

namespace App\Notifications;

use App\Models\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobAlertMatchNotification extends Notification
{
    use Queueable;

    public function __construct(public Job $job)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New job matching your alert: '.$this->job->title)
            ->greeting('Hi '.$notifiable->name.',')
            ->line('A new job matching one of your job alerts was just posted on Job4U.')
            ->line($this->job->title.' at '.$this->job->company_name)
            ->line($this->job->location.' • '.$this->job->employment_type.' • '.$this->job->work_arrangement)
            ->action('View Job', route('jobs.show', $this->job))
            ->line('You are receiving this because you set up a job alert. Manage your alerts anytime from your dashboard.');
    }
}
