<?php

namespace Tests\Services\Importer;

use App\Services\Importer\TxtImporter;
use PHPUnit\Framework\TestCase;
use App\Services\Importer\ValueObjects\TransactionCollection;

class TxtImporterTest extends TestCase
{
    public function testImport_ShouldThrowException_IfFileNotExists(): void
    {
        $sut = new TxtImporter('/tmp/file.txt');

        $this->expectException(\RuntimeException::class);

        $sut->import();
    }


    public function testImport_ShouldReturnTransactionCollection(): void
    {
        $sut = new TxtImporter(__DIR__ . '/../../data/file.txt');
        $result = $sut->import();

        $this->assertInstanceOf(TransactionCollection::class, $result);
        $this->assertEquals(5, count($result->list()));
    }
}