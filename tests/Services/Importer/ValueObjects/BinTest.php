<?php
namespace Tests\Services\Importer\ValueObjects;

use App\Services\Importer\ValueObjects\Bin;
use PHPUnit\Framework\TestCase;

class BinTest extends TestCase
{
    public function testBinShouldReturnCountryCode(): void
    {
        $data = ['country' => ['alpha2' => 'LT']];

        $bin = new Bin($data);

        $this->assertEquals('LT', $bin->country());
    }

    public function testBinShouldThrowExceptionIfCountryNotSet(): void
    {
        $bin = new Bin([]);

        $this->expectException(\RuntimeException::class);

        $bin->country();
    }
}