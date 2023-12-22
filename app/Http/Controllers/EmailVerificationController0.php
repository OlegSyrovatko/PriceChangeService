<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PriceTracker;

class EmailVerificationController extends Controller
{
    public function verifyEmail($token)
    {
        // Знайти запис за токеном
        $priceTracker = PriceTracker::where('verification_token', $token)->first();

        // Перевірити, чи знайдено запис та чи не підтверджено вже
        if ($priceTracker && !$priceTracker->is_verified) {
            // Змінити значення is_verified на true
            $priceTracker->update(['is_verified' => true]);

            // Додаткова логіка (якщо потрібно)

            // Повідомлення про успішне підтвердження
            return view('verification.success');
        }

        // Якщо не знайдено або вже підтверджено, відобразити відповідне повідомлення
        return view('verification.error');
    }
}

