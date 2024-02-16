<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Auth\SendResetCodeRequest;
use App\Models\User;
use App\Notifications\SendTempPassword;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ForgetPasswordController extends BaseController
{

    /**
     * @param SendResetCodeRequest $request
     * @return JsonResponse
     */
    public function sendTempPassword(SendResetCodeRequest $request)
    {
        try {
            $user = User::query()->where($request['type'], $request['username'])->first();

            $tempPassword = $this->generateTempPassword(10);

            $user->update(['temp_password' => $tempPassword, 'temp_password_used_at' => null]);

            $user->notify(new SendTempPassword($tempPassword));

            return $this->respondMessage('تم إرسال كلمة مرور مؤقته الى البريد الإلكتروني');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->respondError('افحص اعدادات ارسال الاميل' . $e->getMessage());
        }
    }


    function generateTempPassword($length = 8)
    {
        // Characters to be used in the temporary password
        $characters = '0123456789';

        // Shuffle the characters and get the first $length characters
        return substr(str_shuffle($characters), 0, $length);
    }


}
