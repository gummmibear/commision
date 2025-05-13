<?php
declare(strict_types=1);

namespace Tests\Services\Importer\ValueObjects;

use App\Services\Importer\ValueObjects\Transaction;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    public function testTransactionIsEuro_ShouldReturnFalse(): void
    {
        $sut = new Transaction('123', 1.23, 'USD');

        $this->assertFalse($sut->isEuro());
    }


    public function testTransactionIsEuro_ShouldReturnTrue(): void
    {
        $sut = new Transaction('123', 1.23, 'EUR');

        $this->assertTrue($sut->isEuro());
    }
}
