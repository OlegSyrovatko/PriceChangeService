<?php

namespace Tests\Helpers;

use App\Helpers\PriceHelper;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PriceHelperTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_parses_advertisement_page_and_returns_price()
    {
        // Mock a sample advertisement page HTML

        $sampleHtml = 'displayValue\":\"123.45 $\",\"regularPrice\":{\"value\":123.45,\"currencyCode\":\"US';

        // Mock the Http facade to return the sample HTML
        Http::fake([
            '*' => Http::response($sampleHtml),
        ]);

        // Call the PriceHelper to parse the HTML and get the price
        $url = 'http://example.com/advertisement';
        $price = PriceHelper::extractPriceFromResponse($url);

        // Output the HTML for debugging
        dump($sampleHtml);

        // Output the parsed price for debugging
        dump($price);

        // Assert that the returned price is as expected
        $this->assertEquals(123.45, $price);
    }

}
