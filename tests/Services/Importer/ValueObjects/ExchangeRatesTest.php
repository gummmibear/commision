<?php

namespace Tests\Services\Importer\ValueObjects;

use App\Services\Importer\ValueObjects\ExchangeRates;
use PHPUnit\Framework\TestCase;

class ExchangeRatesTest extends TestCase
{
    public function testGetExchangeRates_ShouldThrowException(): void
    {
        $exchangeRates = new ExchangeRates([]);
        $this->expectException(\RuntimeException::class);
        $exchangeRates->getFor('USD');
    }

    public function testGetExchangeRatesForCountry_ShouldReturnValidValue(): void
    {
        $exchangeRates = new ExchangeRates(['USD' => 1.23]);

        $this->assertEquals(1.23, $exchangeRates->getFor('USD'));
    }
}