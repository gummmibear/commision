<?php

namespace Tests\Services\Importer\ValueObjects;

use App\Services\Importer\ValueObjects\ExchangeRates;
use PHPUnit\Framework\TestCase;

class ExchangeRatesTest extends TestCase
{
    public function testGetExchangeRates_ShouldThrowException(): void
    {
        $sut = new ExchangeRates([]);
        $this->expectException(\RuntimeException::class);
        $sut->getFor('USD');
    }

    public function testGetExchangeRatesForCountry_ShouldReturnValidValue(): void
    {
        $sut = new ExchangeRates(['USD' => 1.23]);

        $this->assertEquals(1.23, $sut->getFor('USD'));
    }
}
