<?php

namespace Tests\Feature\API\V1\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    /** @test */
    public function it_logs_in_a_user_with_correct_credentials()
    {
        $password = 'password';
        $user = User::factory()->create(['password' => Hash::make($password)]);

        $response = $this->postJson('/api/v1/auth/login', [
            'type' => 'email', // or 'username' based on your request structure
            'username' => $user->email,
            'password' => $password,
        ]);

        $response->assertOk()
            ->assertJsonStructure([
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
            ])->assertJson([
                'status' => true,
                'code' => 200,
                'message' => null,
                'errors' => [],
            ]);
    }

    /** @test */
    public function it_registers_a_new_user()
    {
        $password = Hash::make('12345678');
        $mobileNumber = '05' . $this->faker->unique()->numberBetween(10000000, 99999999);

        $userData = [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'mobile' => $mobileNumber, // Use custom method from FakerSaudiMobileProvider
            'email_verified_at' => now(),
            'password' => $password,
            'password_confirmation' => $password,
            'remember_token' => Str::random(10),
        ];

        $response = $this->postJson('/api/v1/auth/register', $userData);

        $response->assertOk() // Asserting for 200 status code
        ->assertJsonStructure([
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
        ])->assertJson([
            'status' => true,
            'code' => 200,
            'message' => null,
            'errors' => [],
        ]);
    }

    /** @test */
    public function it_logs_out_a_user()
    {
        $user = User::factory()->create();
        $token = $user->createToken(config('app.name'))->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/v1/auth/logout'); // Use GET instead of POST

        $response->assertOk()
            ->assertJsonStructure([
                'status',
                'code',
                'message',
                'data',
                'errors',
            ])->assertSimilarJson([
                'status' => true,
                'code' => 200,
                'message' => 'تم تسجيل الخروج بنجاح',
                'data' => null,
                'errors' => [],
            ]);

        // Assert that the token has been revoked
        $this->assertCount(0, $user->refresh()->tokens);
    }



}
