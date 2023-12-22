<?php

namespace App\Http\Controllers;


use App\Models\PriceTracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\Echo_;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Client;

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
        // Отримання ціни з оголошення на OLX
       $currentPrice = $this->extractPriceFromResponse($request->input('url'));

        // Збереження даних у базі даних
        PriceTracker::create([
            'url' => $request->input('url'),
            'current_price' => $currentPrice,
            'email' => $request->input('email'),
        ]);

        // Відправлення листа підписникові (потрібно налаштувати відповідно до вашої логіки)
        // $this->sendEmailNotification($tracker);
        // return $currentPrice;
        return response()->json(['message' => 'Subscription successful']);
    }

    protected function extractPriceFromResponse($url)
    {
        $response = Http::get($url);
        $html = $response->getBody()->getContents();

        // Тепер ви можете зробити щось з HTML, наприклад, вивести його
        $escapedHtml = htmlspecialchars($html);

        $html = response($escapedHtml)->header('Content-Type', 'text/html');
        $position = strpos($html, "regularPrice");
        if ($position !== false) {
            $position += 41;
            $commaPosition = strpos($html, ",", $position);
            $price = substr($html, $position, $commaPosition - $position);
            $price = (float) $price;
        } else {
            $price = 0.0;
        }


        return $price;

    }

    protected function sendEmailNotification(PriceTracker $tracker)
    {
        // Логіка для відправлення листа (використовуйте Laravel Mail)
        // Наприклад, Mail::to($tracker->email)->send(new PriceChangeNotification($tracker));
        // Де PriceChangeNotification - клас для листа, який ви створите вручну
        // Налаштуйте залежно від вашої логіки
    }
}
