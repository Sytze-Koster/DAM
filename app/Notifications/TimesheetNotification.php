<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TimesheetNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $project;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($project)
    {
        $this->project = $project;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting(trans('dam.timesheet.notification.greeting'))
                    ->from(config('company')['email_address'], config('company')['name'])
                    ->subject(trans('dam.timesheet.notification.subject', ['projectName' => $this->project->name]))
                    ->line(trans('dam.timesheet.notification.intro', ['projectName' => $this->project->name, 'hours' => $this->project->notify_after]))
                    ->action(trans('dam.timesheet.notification.to_timesheet'), url()->action('TimesheetController@index', $this->project->id))
                    ->line(trans('dam.timesheet.notification.turn_off'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
