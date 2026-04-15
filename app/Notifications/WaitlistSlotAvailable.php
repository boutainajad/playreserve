<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WaitlistSlotAvailable extends Notification implements ShouldQueue
{
    use Queueable;

    public $waitlist;

    public function __construct(\App\Models\Waitlist $waitlist)
    {
        $this->waitlist = $waitlist;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $terrainName = $this->waitlist->terrain->name ?? 'le terrain';
        $date = $this->waitlist->reservation_date->format('d/m/Y');
        $time = \Carbon\Carbon::parse($this->waitlist->start_time)->format('H:i');

        $url = url("/reservations/create/{$this->waitlist->terrain_id}?date=" . $this->waitlist->reservation_date->format('Y-m-d'));

        return (new MailMessage)
            ->subject('Un créneau s\'est libéré !')
            ->greeting("Bonjour {$notifiable->name},")
            ->line("Bonne nouvelle ! Un créneau que vous attendiez sur **{$terrainName}** le **{$date} à {$time}** vient de se libérer.")
            ->line('Vous avez **30 minutes** pour réserver ce créneau avant que cette place ne soit proposée à la personne suivante sur la liste d\'attente.')
            ->action('Réserver maintenant', $url)
            ->line('Merci d\'utiliser PlayReserve !');
    }
}
