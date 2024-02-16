<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use App\Events\UserRegistered;
use App\Mail\UserLoggedInEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Exceptions\TelegramResponseException;

class SendRegisterNotificationForTelegram
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
    public function handle(UserRegistered $event): void
    {
        $user = $event->user;

        // Send Telegram message
        $message = "تم تسجيل مستخدم جديد بالاسم {$user->name}.";

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
