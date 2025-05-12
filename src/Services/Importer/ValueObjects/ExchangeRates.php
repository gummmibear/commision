<?php

namespace App\Services\Importer\ValueObjects;

class ExchangeRates
{
    public function __construct(public array $data) {}
    public function getFor(string $currency): float
    {
        return $this->data[$currency] ??
            throw new \Exception(sprintf('Exchange rates not found for %s', $currency));
    }
}