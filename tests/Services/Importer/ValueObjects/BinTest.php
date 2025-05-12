<?php
namespace Tests\Services\Importer\ValueObjects;

use App\Services\Importer\ValueObjects\Bin;
use PHPUnit\Framework\TestCase;

class BinTest extends TestCase
{
    public function testBinShouldThrowExceptionIfCountryNotSet(): void
    {
        $sut = new Bin([]);

        $this->assertEquals('', $sut->country());
    }

    public function testBinShouldReturnCountryCode(): void
    {
        $data = ['country' => ['alpha2' => 'LT']];

        $sut = new Bin($data);

        $this->assertEquals('LT', $sut->country());
    }
}
