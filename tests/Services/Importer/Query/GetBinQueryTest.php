<?php
declare(strict_types=1);

namespace Tests\Services\Importer\Query;

use App\Services\Importer\ValueObjects\Bin;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use App\Services\Importer\Query\GetBinQuery;

class GetBinQueryTest extends TestCase
{
    private string $url;
    private GetBinQuery $sut;
    public function setUp(): void
    {
        $this->url = 'https://bin.api.com/%s';
        $binData = [
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
        $mockHandler = new MockHandler();
        $mockHandler->append(
            new Response(200, [], json_encode($binData))
        );

        $client = new Client(['handler' => HandlerStack::create($mockHandler)]);
        $this->sut = new GetBinQuery($client, $this->url);
    }

    public function testGetBin_ShouldReturnBin()
    {
        //given
        $bin = '1234';

        //when
        $result = ($this->sut)($bin);

        //then
        $this->assertInstanceOf(Bin::class, $result);
        $this->assertEquals('LT', $result->country());
    }
}