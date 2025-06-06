<?php
declare(strict_types=1);

namespace App\Services\Importer\ValueObjects;

class Bin
{
    public function __construct(public array $data) {}

    public function country(): string
    {
        return $this->data['country']['alpha2'] ?? '';
    }
}