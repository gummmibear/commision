<?php

namespace App\Services\Importer\ValueObjects;

class Transaction
{
    public function __construct(
        public readonly string $bin,
        public readonly float $amount,
        public readonly string $currency,
    ){}

    public function isEuro(): bool
    {
        return $this->currency === 'EUR';
    }
}