<?php

namespace App\Listeners\User;

use App\Events\User\Created;
use App\Notifications\Registrations\Congratulations;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendWelcomeNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Created  $event
     * @return void
     */
    public function handle(Created $event)
    {
        $event->user->notify(new Congratulations());
    }
}
