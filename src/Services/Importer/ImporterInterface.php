<?php
declare(strict_types=1);

namespace App\Services\Importer;

use App\Services\Importer\ValueObjects\TransactionCollection;

interface ImporterInterface
{
    public function import(): TransactionCollection;
}