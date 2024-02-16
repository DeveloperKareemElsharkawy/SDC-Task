<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use App\Mail\UserLoggedInEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Exceptions\TelegramResponseException;

class SendLoginEmail
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
    public function handle(UserLoggedIn $event): void
    {
        $user = $event->user;

        // Send welcome email to the user
        Mail::to($user->email)->send(new UserLoggedInEmail($user));

    }
}
