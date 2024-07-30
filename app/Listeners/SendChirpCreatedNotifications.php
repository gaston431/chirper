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
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ChirpCreated $event): void
    {
        $user = User::find($event->chirp->user_id);
        
        //foreach (User::whereNot('id', $event->chirp->user_id)->cursor() as $user) {
        foreach ($user->followers as $user) {
            $user->notify(new NewChirp($event->chirp));
        }
    }
}
