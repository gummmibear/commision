<?php

namespace Tests\Services\Importer\ValueObjects;

use App\Services\Importer\ValueObjects\Transaction;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    public function testTransactionIsEuro_ShouldReturnFalse(): void
    {
        $transaction = new Transaction('123', 1.23, 'USD');

        $this->assertFalse($transaction->isEuro());
    }


    public function testTransactionIsEuro_ShouldReturnTrue(): void
    {
        $transaction = new Transaction('123', 1.23, 'EUR');

        $this->assertTrue($transaction->isEuro());
    }
}