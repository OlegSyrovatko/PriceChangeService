<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class PriceHelper
{
    public static function extractPriceFromResponse($url)
    {
        try {
            $response = Http::get($url);
            $html = $response->getBody()->getContents();
        } catch (\Exception $e) {
            // Handle the error, for example, output it to the logs
            Log::error('Error fetching URL: ' . $e->getMessage());
        }

        // Now you can do something with the HTML, like output it
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
}
