<?php

namespace App\Http\Controllers\API\V1\Profile;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\User\UpdatePasswordRequest;
use App\Http\Requests\API\User\UpdateProfileRequest;
use App\Http\Resources\API\User\ProfileResource;
use Illuminate\Http\JsonResponse;

class ProfileController extends BaseController
{

    /**
     * @return JsonResponse
     */
    public function getProfile()
    {
        return $this->respondData(new ProfileResource(auth('api')->user()));
    }

    /**
     * @param UpdateProfileRequest $request
     * @return JsonResponse
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = auth('api')->user();

        $user->update($request->validated());

        return $this->respondData([
            'user' => new ProfileResource($request->user()),
            'token' => $user->createToken(config('app.name'))->plainTextToken
        ], 'تم تحديث الملف الشخصي بنجاح', 201);
    }

    /**
     * @param UpdatePasswordRequest $request
     * @return JsonResponse
     *
     * Update Password
     * Reset Temp Password
     */
    public function updatePassword(UpdatePasswordRequest $request): JsonResponse
    {
        $user = auth('api')->user();

        $user->update(['password' => $request['password'], 'temp_password' => null, 'temp_password_used_at' => null]);

        return $this->respondMessage('Password updated successfully');
    }

}
