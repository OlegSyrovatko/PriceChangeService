<?php

namespace App\Http\Controllers;


use App\Models\PriceTracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Mail\EmailVerification;
use App\Helpers\PriceHelper;

class PriceTrackerController extends Controller
{
    public function showSubscriptionForm()
    {
        return view('subscribe');
    }

    public function subscribe(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'url' => 'required|url',
            'email' => 'required|email',
            // allow only one url subscription
            // 'email' => 'required|email|unique:price_trackers',
        ]);

        if ($validator->fails()) {
            return redirect('/subscribe')
                ->withErrors($validator)
                ->withInput();
        }

        //  Getting a price from an ad on OLX
         $currentPrice = PriceHelper::extractPriceFromResponse($request->input('url'));
         $token = Str::random(32);

        // Saving data in the database
        PriceTracker::create([
            'url' => $request->input('url'),
            'current_price' => $currentPrice,
            'email' => $request->input('email'),
            'token' => $token,
        ]);


        //  Sending an email to a subscriber
        $this->sendEmailNotification($token, $request->input('email'));

         return response()->json(['message' => 'Subscription successful']);
    }

    protected function sendEmailNotification($token,$email)
    {
        $verificationLink = url("/verify-email/{$token}");
        Mail::to($email)->send(new EmailVerification($verificationLink));
    }
}
