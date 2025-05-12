<?php

namespace Tests\Services\Importer\Query;

use App\Services\Importer\ValueObjects\Bin;
use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use App\Services\Importer\Query\GetBinQuery;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class GetBinQueryTest extends TestCase
{
    private string $url;
    private ClientInterface $clientMock;
    private GetBinQuery $sut;
    public function setUp(): void
    {
        $this->url = 'https://bin.api.com/%s';
        $this->clientMock = $this->createMock(ClientInterface::class);
        $this->sut = new GetBinQuery($this->clientMock, $this->url);
    }

    public function testGetBin_ShouldReturnBin()
    {
        //given
        $bin = '1234';

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

        $responseMock = $this->createMock(ResponseInterface::class);
        $streamMock = $this->createMock(StreamInterface::class);

        //expect
        $streamMock->method('__toString')->willReturn(json_encode($binData));
        $responseMock->method('getBody')->willReturn($streamMock);
        $this->clientMock->method('request')
            ->with('GET', sprintf($this->url, $bin))
            ->willReturn($responseMock);

        //when
        $result = ($this->sut)($bin);

        //then
        $this->assertInstanceOf(Bin::class, $result);
        $this->assertEquals('LT', $result->country());
    }
}