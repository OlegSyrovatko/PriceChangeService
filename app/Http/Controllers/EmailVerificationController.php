<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PriceTracker;


class EmailVerificationController extends Controller
{
    public function verifyEmail($token)
    {
        // Find a record by token
        $priceTracker = PriceTracker::where('token', $token)->first();

        // Check if the record is found and not already confirmed
        if ($priceTracker && !$priceTracker->is_verified) {
            // Change the value of is_verified to true
            $priceTracker->update(['is_verified' => true]);

            // Notification of successful verification
            return view('verification.success');
        }

        // If not found or already confirmed, display appropriate message
        return view('verification.error');
    }
}
