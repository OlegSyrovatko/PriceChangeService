<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PriceTracker;
use App\Helpers\PriceHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailNotification;
use App\Mail\EmailNotificationDeleted;

class MyCustomCommand extends Command
{

    // protected $signature = 'myCustomCommand';
    protected $signature = 'myCustomCommand:update';
    protected $description = 'MyCustomCommand';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $data = DB::table('price_trackers')
            ->select('url', 'current_price', 'email')
            ->where('is_verified', 1)
            ->get();

        // Checking and sending letters for each record
        foreach ($data as $record) {
            $url = $record->url;

            // Obtaining the price using the specified method
            $currentPrice = PriceHelper::extractPriceFromResponse($url);

            // Price comparison
            if ($currentPrice != $record->current_price) {

                // Sending a letter that the ad has been deleted if no price was found
                if($currentPrice == "0.00"){
                    $this->sendEmailNotificationDeleted($url, $record->email);
                }
                // Sending a letter regarding the price change
                else{
                    $this->sendEmailNotification($url, $record->email, $currentPrice);
                }

                // Update the price in the table
                PriceTracker::where('url', $url)
                    ->update(['current_price' => $currentPrice]);
            }
        }

        return 0;
    }

    private function sendEmailNotification($url, $email, $price)
    {
        Mail::to($email)->send(new EmailNotification($url, $price));
    }

    private function sendEmailNotificationDeleted($url, $email)
    {
        Mail::to($email)->send(new EmailNotificationDeleted($url));
    }
}
