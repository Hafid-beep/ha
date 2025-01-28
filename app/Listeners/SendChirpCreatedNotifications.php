<?php

namespace App\Listeners;

use App\Events\ChirpCreated;
use App\Models\User;
use App\Notifications\NewChirp;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendChirpCreatedNotifications implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        // Tidak ada logika di konstruktor
    }

    /**
     * Handle the event.
     */
    public function handle(ChirpCreated $event): void
    {
        // Mengirim notifikasi ke semua user kecuali yang membuat chirp
        foreach (User::where('id', '!=', $event->chirp->user_id)->cursor() as $user) {
            $user->notify(new NewChirp($event->chirp));
        }
    }
}
