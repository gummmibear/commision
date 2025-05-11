<?php

namespace App\Services\Importer\ValueObjects;

class ExchangeRates
{
    public function __construct(public array $data) {}
}