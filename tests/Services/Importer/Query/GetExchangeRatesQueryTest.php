<?php

namespace Tests\Services\Importer\Query;

use App\Services\Importer\Query\Exception\ApiException;
use App\Services\Importer\Query\GetExchangeRatesQuery;
use App\Services\Importer\ValueObjects\ExchangeRates;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class GetExchangeRatesQueryTest extends TestCase
{
    private string $url;
    private string $apiKey;
    private ClientInterface $clientMock;
    private GetExchangeRatesQuery $sut;

    public function setUp(): void
    {
        $this->url = 'https://exchange.api';
        $this->apiKey = '123apiKey';
        $this->clientMock = $this->createMock(ClientInterface::class);

        $this->sut = new GetExchangeRatesQuery($this->clientMock, $this->url, $this->apiKey);
    }

    public function testGetExchangeRates_ShouldThrowApiExceptionOnGuzzleException(): void
    {
        $this->clientMock->method('request')
            ->with('GET', $this->url, ['headers' => ['apikey' => $this->apiKey]])
            ->willThrowException(new InvalidArgumentException());

        $this->expectException(ApiException::class);

        ($this->sut)();
    }

    public function testGetExchangeRates_ShouldReturnExchangeRatesWithData(): void
    {
        //given
        $rates = [
            'rates' => [
                'USD' => 1.24,
                'GBP' => 2.78,
            ]
        ];

        $responseMock = $this->createMock(ResponseInterface::class);
        $streamMock = $this->createMock(StreamInterface::class);

        //expect
        $streamMock->method('__toString')->willReturn(json_encode($rates));
        $responseMock->method('getBody')->willReturn($streamMock);
        $this->clientMock->method('request')
            ->with('GET', $this->url, ['headers' => ['apikey' => $this->apiKey]])
            ->willReturn($responseMock);

        //when
        $result = ($this->sut)();

        //then
        $this->assertInstanceOf(ExchangeRates::class, $result);
        $this->assertEquals(1.24, $result->getFor('USD'));
        $this->assertEquals(2.78, $result->getFor('GBP'));
    }
}