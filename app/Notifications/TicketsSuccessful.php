<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketsSuccessful extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(protected $project)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
            ->subject($this->project['subject'])
            ->greeting($this->project['greeting'])
            ->line($this->project['body'])
            ->line('- - - - - - - - - - - - - - ')
            ->line('Status alterado para: ')
            ->line($this->project['status'])
            ->action($this->project['actionText'], $this->project['actionURL'])
            ->line($this->project['warning'])
            ->line('- - - - - - - - - - - - - - ')
            ->line($this->project['thanks']);
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
            'code' => $this->project['code'],
            'status' => $this->project['status'],
            'date' => $this->project['created_at']
        ];
    }
}
