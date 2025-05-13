<?php
declare(strict_types=1);

namespace App\Services\Importer;

use App\Services\Importer\ValueObjects\Transaction;
use App\Services\Importer\ValueObjects\TransactionCollection;

class TxtImporter implements ImporterInterface
{
    public function __construct(private string $filePath)
    {
    }

    public function import(): TransactionCollection
    {
        $handle = fopen($this->filePath, 'r');
        if (!$handle) {
            throw new \RuntimeException("Cannot open file: $this->filePath");
        }

        $transactionList = [];

        while (($line = fgets($handle)) !== false) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }

            $transaction = json_decode($line, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \RuntimeException("Invalid JSON on line: $line");
            }

            //$transactionList[] = $transaction; //yield
            $transactionList[] = new Transaction(strval($transaction['bin']), floatval($transaction['amount']), strval($transaction['currency']));
        }

        fclose($handle);

        return new TransactionCollection(...$transactionList);
    }
}