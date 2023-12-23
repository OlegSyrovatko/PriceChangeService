<?php

namespace Tests\Console\Commands;

use App\Models\PriceTracker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Mail\EmailNotification;
use Illuminate\Support\Str;

class MyCustomCommandTest extends TestCase
{

    use RefreshDatabase;

    /** @test */

    public function it_handles_price_changes_and_sends_email_notification()
    {
        // Mock external dependencies (Mail, PriceHelper) to avoid actual emails and HTTP requests
        Mail::fake();
        // You may need to mock PriceHelper depending on its functionality

        // Create a test record in the database

        PriceTracker::create([
            'url' => 'https://www.olx.ua/d/uk/obyavlenie/audi-rs-q8-2021-4-0-IDTMjy2.html',
            'current_price' => '10.00',
            'email' => 'sirov@ukr.net',
            'token' => Str::random(32),
            'is_verified' => 1,
        ]);

        // Run the custom command
        $this->artisan('myCustomCommand');

        // Assert that the email notification is sent
        Mail::assertSent(EmailNotification::class, function ($mail) {
            return $mail->hasTo('sirov@ukr.net');
        });

        // You may add more assertions based on your command's logic and expected outcomes
    }

}
