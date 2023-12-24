<?php

namespace Tests\TestEmail;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\PriceTracker;
use Illuminate\Support\Facades\View;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_verifies_user_email_successfully()
    {
        // Create a test record in the database
        $priceTracker = PriceTracker::create([
            'url' => 'https://www.example.com',
            'current_price' => '10.00',
            'email' => 'test@example.com',
            'token' => 'test_token',
            'is_verified' => false, // Ensure that it starts as false
        ]);

        // Call the verifyEmail controller method with the token
        $response = $this->get("/verify-email/{$priceTracker->token}");

        // Assert that the response is a successful view of the verification success page
        $response->assertViewIs('verification.success');

        // Assert that the record in the database is marked as verified
        $this->assertDatabaseHas('price_trackers', [
            'id' => $priceTracker->id,
            'is_verified' => true,
        ]);
    }
}
