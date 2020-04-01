<?php


namespace Tests\AppBundle\Parser\Extractor;

use AppBundle\Import\Extractor\CsvExtractor;
use PHPUnit\Framework\TestCase;

class CsvExtractorTest extends TestCase
{
    public function testExtract()
    {
        $extractor = new CsvExtractor('azer');

        $this->assertIsArray($extractor->extract());
    }
}