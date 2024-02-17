<?php

namespace Tests\Feature\API\V1\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgetPasswordControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function it_sends_temp_password_to_user_email()
    {
        // Disable notification events from firing
        Notification::fake();

        // Create a test user
        $user = User::factory()->create();

        // Mock the request data
        $requestData = [
            'email' => $user->email, // Use the user's email as the username
        ];

        // Make a POST request to the sendTempPassword endpoint
        $response = $this->postJson('/api/v1/auth/send-temp-password', $requestData);

        // Assert that the response is successful (status code 200)
        $response->assertOk();

        // Assert that the user's temp_password field is updated
        $this->assertNotNull($user->refresh()->temp_password);

        // Assert that the notification was sent to the user
        Notification::assertSentTo(
            $user,
            \App\Notifications\SendTempPassword::class
        );

        // Assert that the response matches the expected structure
        $response->assertSimilarJson([
            'status' => true,
            'code' => 200,
            'message' => 'تم إرسال كلمة مرور مؤقته الى البريد الإلكتروني',
            'data' => null,
            'errors' => [],
        ]);
    }
}
