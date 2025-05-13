<?php
declare(strict_types=1);

namespace Tests\Services\Importer;

use App\Services\Importer\Exception\ImportFactoryException;
use App\Services\Importer\ImporterFactory;
use App\Services\Importer\TxtImporter;
use PHPUnit\Framework\TestCase;

class ImporterFactoryTest extends TestCase
{
    private ImporterFactory $sut;
    public function setUp(): void
    {
        $this->sut = new ImporterFactory();
    }

    public function testCreate_ShouldThrowException_IfImporterIsNotFound(): void
    {
        $this->expectException(ImportFactoryException::class);

        $this->sut->create('/tmp/file.xml');
    }

    public function testCreate_ShouldReturnTxtImporterForTxtFileFormat(): void
    {
        $result = $this->sut->create('/tmp/text.txt');

        $this->assertInstanceOf(TxtImporter::class, $result);
    }
}