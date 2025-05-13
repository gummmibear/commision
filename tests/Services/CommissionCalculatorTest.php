<?php
declare(strict_types=1);

namespace Tests\Services;

use App\Services\CommissionCalculator;
use App\Services\EuCuntry;
use App\Services\Importer\Query\GetBinQuery;
use App\Services\Importer\ValueObjects\Bin;
use App\Services\Importer\ValueObjects\ExchangeRates;
use App\Services\Importer\ValueObjects\Transaction;
use App\Services\Importer\ValueObjects\TransactionCollection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CommissionCalculatorTest extends TestCase
{
    private GetBinQuery|MockObject $getBinQueryMock;
    private EuCuntry|MockObject $euCuntryMock;
    private CommissionCalculator $sut;
    public function setUp(): void
    {
        $this->getBinQueryMock = $this->createMock(GetBinQuery::class);
        $this->euCuntryMock = $this->createMock(EuCuntry::class);

        $this->sut = new CommissionCalculator($this->getBinQueryMock, $this->euCuntryMock);
    }

    public function testCalculate(): void
    {
        //given
        $tt = [
            new Transaction('123', 123, 'USD'),
            new Transaction('456', 123, 'GBP'),
            new Transaction('789', 123, 'EUR'),
        ];

        $data = [
            'USD' => 0.2,
            'GBP' => 0.3,
            'EUR' => 1
        ];

        $transactions = new TransactionCollection(...$tt);
        $exchangeRates =  new ExchangeRates($data);
        $bin = new Bin(['country' => ['alpha2' => 'US']]);
        $bin2 = new Bin(['country' => ['alpha2' => 'GB']]);
        $bin3 = new Bin(['country' => ['alpha2' => 'LT']]);

        //expects
        $this->euCuntryMock->method('isEU')->willReturnOnConsecutiveCalls(false, false, true);
        $this->getBinQueryMock->method('__invoke')->willReturnOnConsecutiveCalls($bin, $bin2, $bin3);

        //when
        $result = $this->sut->calculate($transactions, $exchangeRates);

        //then
        $expectedResult = [
            '123' => 12.3,
            '456' => 8.2,
            '789' => 1.23,
        ];

        $this->assertCount(3, $result);
        $this->assertEquals($expectedResult, $result);
    }
}