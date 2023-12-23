<?php

namespace Tests\Feature;

use App\Models\PriceTracker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Mail\EmailVerification;

class PriceTrackerControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_subscription_form()
    {
        $response = $this->get('/subscribe');

        $response->assertStatus(Response::HTTP_OK)
            ->assertViewIs('subscribe');
    }

    /** @test */
    public function it_subscribes_user_and_sends_email_notification()
    {
        // Mock external dependencies (Http, Mail) to avoid actual requests and emails

        Http::fake([
            '*' => Http::response('mocked response', 200),
        ]);

        Mail::fake();

        $url = 'https://www.olx.ua/d/uk/obyavlenie/audi-rs-q8-2021-4-0-IDTMjy2.html';
        $email = 'sirov@ukr.net';

        $response = $this->post('/subscribe', [
            'url' => $url,
            'email' => $email,
        ]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'Subscription successful']);

        // Assert that the subscription is stored in the database
        $this->assertDatabaseHas('price_trackers', [
            'url' => $url,
            'email' => $email,
        ]);

        // Assert that the email notification is sent
        Mail::assertSent(EmailVerification::class, function ($mail) use ($email) {
            return $mail->hasTo($email);
        });
    }
}
