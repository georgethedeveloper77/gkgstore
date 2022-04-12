<?php

namespace Botble\ACL\Listeners;

use Botble\ACL\Models\User;
use Exception;
use Illuminate\Auth\Events\Login;

class LoginListener
{

    /**
     * Handle the event.
     *
     * @param Login $event
     * @return void
     *
     * @throws Exception
     */
    public function handle(Login $event)
    {
        if ($event->user instanceof User) {
            cache()->forget(md5('cache-dashboard-menu-' . $event->user->id));
        }
    }
}
