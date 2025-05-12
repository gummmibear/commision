<?php

use App\Services\EuCuntry;
use PHPUnit\Framework\TestCase;

class EuCuntryTest extends TestCase
{
    private $sut;
    public function setUp(): void
    {
        $this->sut = new EuCuntry();
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('euDataProvider')]
    public function testEuCuntry(string $countryCode): void
    {
        $this->assertTrue($this->sut->isEu($countryCode));
    }

    public static function euDataProvider(): \Generator
    {
        yield 'Austria'        => ['AT'];
        yield 'Belgium'        => ['BE'];
        yield 'Bulgaria'       => ['BG'];
        yield 'Cyprus'         => ['CY'];
        yield 'Czech Republic' => ['CZ'];
        yield 'Germany'        => ['DE'];
        yield 'Denmark'        => ['DK'];
        yield 'Estonia'        => ['EE'];
        yield 'Spain'          => ['ES'];
        yield 'Finland'        => ['FI'];
        yield 'France'         => ['FR'];
        yield 'Greece'         => ['GR'];
        yield 'Croatia'        => ['HR'];
        yield 'Hungary'        => ['HU'];
        yield 'Ireland'        => ['IE'];
        yield 'Italy'          => ['IT'];
        yield 'Lithuania'      => ['LT'];
        yield 'Luxembourg'     => ['LU'];
        yield 'Latvia'         => ['LV'];
        yield 'Malta'          => ['MT'];
        yield 'Netherlands'    => ['NL'];
        yield 'Poland'         => ['PO']; // Note: should be 'PL' ??
        yield 'Portugal'       => ['PT'];
        yield 'Romania'        => ['RO'];
        yield 'Sweden'         => ['SE'];
        yield 'Slovenia'       => ['SI'];
        yield 'Slovakia'       => ['SK'];
    }


    #[\PHPUnit\Framework\Attributes\DataProvider('noEuDataProvider')]
    public function testNoEu(string $countryCode): void
    {
        $this->assertFalse($this->sut->isEu($countryCode));
    }

    public static function noEuDataProvider(): \Generator
    {
        yield 'United States'   => ['US'];
        yield 'United Kingdom'  => ['GB'];
        yield 'Switzerland'     => ['CH'];
        yield 'Norway'          => ['NO'];
        yield 'Canada'          => ['CA'];
    }
}