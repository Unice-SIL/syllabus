<?php


namespace App\Syllabus\Import\Extractor;

use App\Syllabus\Helper\Report\Report;
use League\Csv\AbstractCsv;
use League\Csv\InvalidArgument;
use League\Csv\Reader;
use League\Csv\UnavailableStream;

class CsvExtractor implements ExtractorInterface
{

    private AbstractCsv $csv;
    private mixed $path;
    private array $options = [
        'headerOffset' => 0,
        'delimiter' => ';',
    ];

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->options = array_merge($this->options, $options);
    }


    /**
     * @return AbstractCsv
     */
    public function getCsv(): AbstractCsv
    {
        return $this->csv;
    }

    /**
     * @param AbstractCsv $csv
     * @return void
     */
    private function setCsv(AbstractCsv $csv): void
    {
        $this->csv = $csv;
    }


    /**
     * @param Report|null $report
     * @param array $options
     * @return AbstractCsv
     * @throws InvalidArgument
     * @throws UnavailableStream
     */
    public function extract(Report $report = null, array $options = []): AbstractCsv
    {

        $this->setCsv(Reader::createFromPath($this->getPath()));
        $this->getCsv()->setHeaderOffset($this->options['headerOffset']);
        $this->getCsv()->setDelimiter($this->options['delimiter']);

        return $this->getCsv();
    }

    /**
     * @return mixed
     */
    public function getPath(): mixed
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath(mixed $path): void
    {
        $this->path = $path;
    }

}