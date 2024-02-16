<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Events\UserLoggedIn;
use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Http\Requests\API\Auth\RegisterRequest;
use App\Http\Resources\API\User\ProfileResource;
use App\Mail\UserLoggedInEmail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Events\UserRegistered;

class  AuthController extends BaseController
{

    /**
     * Validate the user login request.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $user = User::query()->where($request['type'], $request['username'])->first();

        if ($user) {
            if (Hash::check($request['password'], $user['password'])) {
                // User logged in with their actual password
                $user->temp_password = null; // Reset temporary password
                $user->save();
            } elseif (!is_null($user['temp_password']) && Hash::check($request['password'], $user['temp_password'])) {
                // User logged in with their temporary password
                if ($user->temp_password_used_at === null) {
                    // Mark temporary password as used for the first time
                    $user->temp_password_used_at = now();
                    $user->save();
                } else {
                    // Temporary password already used, deny login
                    throw ValidationException::withMessages(['password' => 'لقد تم بالفعل استخدام كلمة المرور المؤقتة.']);
                }
            } else {
                // Invalid password
                throw ValidationException::withMessages(['password' => 'كلمة المرور غير صحيحة']);
            }

            event(new UserLoggedIn($user));

            return $this->respondData([
                'user' => new ProfileResource($user),
                'token' => $user->createToken(config('app.name'))->plainTextToken
            ]);
        }

        throw ValidationException::withMessages(['password' => 'كلمة المرور غير صحيحة']);
    }


    /**
     * Validate the user login request.
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $user = User::query()->create($request->validated());

        event(new UserRegistered($user));

        return $this->respondData([
            'user' => new ProfileResource($user),
            'token' => $user->createToken(config('app.name'))->plainTextToken
        ]);
    }

    /**
     * Revoke Token *
     * @param Request $request
     * @return JsonResponse
     */
    public function logOut(Request $request)
    {
        auth()->user()->tokens()->delete();

        return $this->respondMessage('تم تسجيل الخروج بنجاح');
    }

}
