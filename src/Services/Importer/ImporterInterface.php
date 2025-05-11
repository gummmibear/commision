<?php

namespace App\Services\Importer;

use App\Services\Importer\ValueObjects\TransactionCollection;

interface ImporterInterface
{
    public function import(): TransactionCollection;
}