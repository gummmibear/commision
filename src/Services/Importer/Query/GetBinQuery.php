<?php
declare(strict_types=1);

namespace App\Services\Importer\Query;

use App\Services\Importer\Query\Exception\ApiException;
use App\Services\Importer\ValueObjects\Bin;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

class GetBinQuery
{
    public function __construct(private ClientInterface $httpClient, private string $url) {}

    public function __invoke(string $binNumber)
    {
        try {
            $response = $this->httpClient->request('GET', sprintf($this->url, $binNumber));
        } catch (GuzzleException $exception) {
            throw new ApiException('Error occurred while fetching bin data from API', 0, $exception);
        }

        $bin = json_decode($response->getBody()->getContents(), true);

        return new Bin($bin);
    }
}