<?php
namespace App\Console\Commands;

use App\Models\Event;
use App\Notifications\EventReminder;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendEventReminders extends Command
{
    protected $signature = 'reminders:send';
    protected $description = 'Send reminders for upcoming events';

    public function handle()
    {
        $events = Event::where('status', 'scheduled')
                      ->whereBetween('event_date', [
                          now()->addDay(),
                          now()->addDays(2)
                      ])
                      ->with('participants')
                      ->get();

        foreach ($events as $event) {
            foreach ($event->participants as $participant) {
                if ($participant->pivot->status === 'confirmed') {
                    $participant->notify(new EventReminder($event));
                }
            }
        }

        $this->info('Sent reminders for ' . $events->count() . ' events.');
    }
}