<?php

namespace App\Services\Importer\Query;

use App\Services\Importer\ValueObjects\Bin;
use GuzzleHttp\Client;
use http\Exception\RuntimeException;

class GetBinQuery
{
    public function __construct(private Client $httpClient, private string $url) {}

    public function __invoke(string $binNumber)
    {
        try {
            $response = $this->httpClient->request('GET', sprintf($this->url, $binNumber));
        } catch (\Throwable $exception) {
            throw new \RuntimeException($exception->getMessage());
        }
        $bin = json_decode($response->getBody(), true);

        return new Bin($bin);
    }


    private function getBinStaticData(): array
    {
        $bin = [
            "number" => [],
            "scheme" => "visa",
            "type" => "debit",
            "brand" => "Visa Classic",
            "country" => [
                "numeric" => "440",
                "alpha2" => "LT",
                "name" => "Lithuania",
                "emoji" => "🇱🇹",
                "currency" => "EUR",
                "latitude" => 56,
                "longitude" => 24
            ],
            "bank" => [
                "name" => "Uab Finansines Paslaugos Contis"
            ]
        ];

        return $bin;

    }
}