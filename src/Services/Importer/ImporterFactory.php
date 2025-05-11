<?php

namespace App\Services\Importer;

class ImporterFactory
{
    public function create(string $filePath): ImporterInterface
    {
        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

        return match ($fileExtension) {
            'txt' => new TxtImporter($filePath),
            default => throw new \Exception('Importer for given file is not supported'),
        };
    }
}