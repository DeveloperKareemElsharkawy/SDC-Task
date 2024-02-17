<?php

namespace Tests\Feature\API\V1\Profile;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function it_returns_user_profile()
    {
        // Create a test user
        $user = User::factory()->create();

        $token = $user->createToken(config('app.name'))->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/v1/profile'); // Use GET instead of POST


        // Assert that the response contains the user profile data
        $response->assertJsonStructure([
            'status',
            'code',
            'message',
            'data' => [
                'id',
                'name',
                'email',
                'mobile',
                'created_at',
                'updated_at',
            ],
            'errors',
        ]);
    }


    /** @test */
    public function it_updates_user_profile()
    {
        // Create a test user
        $user = User::factory()->create();

        // Generate a token for the user
        $token = $user->createToken(config('app.name'))->plainTextToken;
        $mobileNumber = '05' . $this->faker->unique()->numberBetween(10000000, 99999999);

        // Mock update data
        $updateData = [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'mobile' => $mobileNumber,
        ];

        // Make a Post request to the updateProfile endpoint with the user's token in the headers
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/v1/profile', $updateData);

        // Assert that the response is successful (status code 201)
        $response->assertStatus(201);

        // Assert that the response contains the updated user profile data
        $response->assertJsonStructure([
            'status',
            'code',
            'message',
            'data' => [
                'user' => [
                    'id',
                    'name',
                    'email',
                    'mobile',
                    'created_at',
                    'updated_at',
                ],
                'token',
            ],
            'errors',
        ]);
    }

    /** @test */
    public function it_updates_user_password()
    {
        // Create a test user
        $user = User::factory()->create();

        $token = $user->createToken(config('app.name'))->plainTextToken;


        // Mock update password data
        $updatePasswordData = [
            'old_password' => 'password', // Provide the old password
            'password' => 'new_password',
            'password_confirmation' => 'new_password', // Confirm the new password
        ];


        // Make a Post request to the updatePassword endpoint
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/v1/profile/update-password', $updatePasswordData);

        // Assert that the response is successful (status code 200)
        $response->assertOk();

        // Assert that the response message indicates successful password update
        $response->assertExactJson([
            'status' => true,
            'code' => 200,
            'message' => 'Password updated successfully',
            'data' => null,
            'errors' => [],
        ]);
    }
}
