<?php
declare(strict_types=1);

namespace Tests\Services\Importer\Query;

use App\Services\Importer\Query\Exception\ApiException;
use App\Services\Importer\Query\GetExchangeRatesQuery;
use App\Services\Importer\ValueObjects\ExchangeRates;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\InvalidArgumentException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
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


    }

    public function testGetExchangeRates_ShouldThrowApiExceptionOnGuzzleException(): void
    {
        //given
        $mockHandler = new MockHandler();
        $mockHandler->append(
             new RequestException('Error Communicating with Server', new Request('GET', 'test'))
        );
        $client = new Client(['handler' => HandlerStack::create($mockHandler)]);

        $sut = new GetExchangeRatesQuery($client, $this->url, $this->apiKey);

        //expect
        $this->expectException(ApiException::class);

        //when
        ($sut)();
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

        $mockHandler = new MockHandler();
        $mockHandler->append(
            new Response(200, [], json_encode($rates))
        );

        $client = new Client(['handler' => HandlerStack::create($mockHandler)]);

        $sut = new GetExchangeRatesQuery($client, $this->url, $this->apiKey);

        //when
        $result = ($sut)();

        //then
        $this->assertInstanceOf(ExchangeRates::class, $result);
        $this->assertEquals(1.24, $result->getFor('USD'));
        $this->assertEquals(2.78, $result->getFor('GBP'));
    }
}