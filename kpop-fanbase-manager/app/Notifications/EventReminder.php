<?php
namespace App\Notifications;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventReminder extends Notification implements ShouldQueue
{
    use Queueable;

    protected $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Reminder: ' . $this->event->name)
                    ->line('You have an upcoming KPOP event!')
                    ->line('Event: ' . $this->event->name)
                    ->line('Date: ' . $this->event->event_date->format('F j, Y \a\t g:i A'))
                    ->line('Location: ' . $this->event->location)
                    ->action('View Event', url('/events/' . $this->event->id))
                    ->line('Thank you for being part of our community!');
    }
}