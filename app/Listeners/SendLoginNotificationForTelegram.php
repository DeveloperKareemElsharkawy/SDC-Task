<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use App\Mail\UserLoggedInEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Exceptions\TelegramResponseException;

class SendLoginNotificationForTelegram
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

        // Send Telegram message
        $message = "المستخدم {$user->name} قام بتسجيل الدخول.";

        try {
            Telegram::sendMessage([
                'chat_id' => '-1002129238286', // Chat Id
                'text' => $message,
            ]);
        } catch (TelegramResponseException $e) {
            Log::error('Failed to send Telegram message: ' . $e->getMessage());
        }
    }
}
