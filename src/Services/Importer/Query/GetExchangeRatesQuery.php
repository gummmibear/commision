<?php
declare(strict_types=1);

namespace App\Services\Importer\Query;

use App\Services\Importer\Query\Exception\ApiException;
use App\Services\Importer\ValueObjects\ExchangeRates;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

class GetExchangeRatesQuery
{
    public function __construct(
        private ClientInterface $httpClient,
        private readonly string $url,
        private readonly string $apiKey
    ){}

    public function __invoke(): ExchangeRates
    {
        try {
            $response = $this->httpClient->request(
                'GET',
                $this->url,
                [
                    'headers' => [
                        'apikey' => $this->apiKey,
                    ]
                ]
            );
        } catch (GuzzleException $exception) {
            throw new ApiException('Error occurred while fetching exchange rates from API', 0, $exception);
        }

        $rates = json_decode($response->getBody()->getContents(), true);

        return new ExchangeRates($rates['rates'] ?? []);
    }
}