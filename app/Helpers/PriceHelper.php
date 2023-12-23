<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class PriceHelper
{
    public static function extractPriceFromResponse($url)
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
}
