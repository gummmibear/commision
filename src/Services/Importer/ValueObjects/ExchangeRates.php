<?php
declare(strict_types=1);

namespace App\Services\Importer\ValueObjects;

class ExchangeRates
{
    public function __construct(public array $data) {}
    public function getFor(string $currency): float
    {
        return $this->data[$currency] ??
            throw new \RuntimeException(sprintf('Exchange rates not found for %s', $currency));
    }
}