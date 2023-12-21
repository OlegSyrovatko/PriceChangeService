<?php

namespace App\Http\Controllers;


use App\Models\PriceTracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

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
            'email' => 'required|email|unique:price_trackers',
        ]);

        if ($validator->fails()) {
            return redirect('/subscribe')
                ->withErrors($validator)
                ->withInput();
        }
        // Отримання ціни з оголошення на OLX (потрібно налаштувати відповідно до структури сайту)
        $response = Http::get($request->input('url'));
        $currentPrice = $this->extractPriceFromResponse($response->body());

        // Збереження даних у базі даних
        $tracker = PriceTracker::create([
            'url' => $request->input('url'),
            'current_price' => $currentPrice,
            'email' => $request->input('email'),
        ]);

        // Відправлення листа підписникові (потрібно налаштувати відповідно до вашої логіки)
        $this->sendEmailNotification($tracker);
        return 5;
        // return response()->json(['message' => 'Subscription successful']);
    }

    protected function extractPriceFromResponse($html)
    {
        // Логіка для вилучення ціни з HTML-коду оголошення на OLX
        // Наприклад, використовуйте бібліотеку для парсингу HTML, таку як Symfony DomCrawler
        // Простий приклад: $crawler = new Crawler($html); $price = $crawler->filter('.price')->text();
        // Налаштуйте залежно від структури OLX
        return 0.0; // Замініть на реальний код
    }

    protected function sendEmailNotification(PriceTracker $tracker)
    {
        // Логіка для відправлення листа (використовуйте Laravel Mail)
        // Наприклад, Mail::to($tracker->email)->send(new PriceChangeNotification($tracker));
        // Де PriceChangeNotification - клас для листа, який ви створите вручну
        // Налаштуйте залежно від вашої логіки
    }
}
