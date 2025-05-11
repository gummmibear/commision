<?php

namespace App\Command;

use App\Services\Importer\ImporterFactory;
use App\Services\Importer\Query\GetBinQuery;
use App\Services\Importer\Query\GetExchangeRatesQuery;

class ImportFileCommand
{
    public function __construct(private ImporterFactory $importerFactory, private GetBinQuery $getBinQuery, private GetExchangeRatesQuery $getExchangeRatesQuery)
    {
    }

    public function handle(string $filePath): int
    {
        $this->println('Importing file');
        $this->println('File: ' . $filePath);

        $transactions = $this->importerFactory
            ->create($filePath)
            ->import();

        $exchangeRates = ($this->getExchangeRatesQuery)();

        foreach ($transactions->list() as $transaction) {
            //$bin = ($this->getBinQuery)($transaction->bin);
            //iseu
            //var_dump($bin);
            $isEu = true;

        }

        var_dump($transactions, $exchangeRates);

        return 0;
    }

    public function println(string $message)
    {
        echo sprintf("%s\n", $message);
    }
}