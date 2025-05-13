<?php
declare(strict_types=1);

namespace App\Services\Importer;

use App\Services\Importer\Exception\ImportFactoryException;

class ImporterFactory
{
    public function create(string $filePath): ImporterInterface
    {
        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

        return match ($fileExtension) {
            'txt' => new TxtImporter($filePath),
            default => throw new ImportFactoryException('Importer for given file is not supported'),
        };
    }
}