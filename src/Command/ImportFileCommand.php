<?php
declare(strict_types=1);

namespace App\Command;

use App\Services\CommissionCalculator;
use App\Services\Importer\ImporterFactory;
use App\Services\Importer\Query\GetExchangeRatesQuery;

class ImportFileCommand
{
    public function __construct(
        private ImporterFactory $importerFactory,
        private GetExchangeRatesQuery $getExchangeRatesQuery,
        private CommissionCalculator  $commissionCalculator,
    ){}

    public function handle(string $filePath): int
    {
        $this->println('Importing file: ' . $filePath);

        $transactions = $this->importerFactory
            ->create($filePath)
            ->import();

        $exchangeRates = ($this->getExchangeRatesQuery)();
        $commissionBin = $this->commissionCalculator->calculate($transactions, $exchangeRates);

        foreach ($commissionBin as $bin => $commission) {
            $this->println(sprintf('Bin: %s => %s', $bin, $commission));
        }

        return 0;
    }

    public function println(string $message)
    {
        echo sprintf("%s\n", $message);
    }
}