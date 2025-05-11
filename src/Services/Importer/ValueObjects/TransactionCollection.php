<?php

namespace App\Services\Importer\ValueObjects;

class TransactionCollection
{
    /** @var Transaction[] */
    private array $transactions;

    public function __construct(Transaction ...$transactions)
    {
        $this->transactions = $transactions;
    }


    public function list(): array
    {
        return $this->transactions;
    }
}