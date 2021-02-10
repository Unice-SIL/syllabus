<?php


namespace App\Syllabus\Import\Extractor;

use App\Syllabus\Helper\Report\Report;
use League\Csv\AbstractCsv;
use League\Csv\Reader;

class CsvExtractor implements ExtractorInterface
{

    private $csv;
    private $path;
    private $options = [
        'headerOffset' => 0,
        'delimiter' => ';',
    ];

    /**
     * CsvExtractor constructor.
     * @param string $path
     * @param $options
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
     * @return CsvExtractor
     */
    private function setCsv(AbstractCsv $csv): self
    {
        $this->csv = $csv;

        return $this;
    }


    public function extract(Report $report = null, array $options = [])
    {

        $this->setCsv(Reader::createFromPath($this->getPath()));
        $this->getCsv()->setHeaderOffset($this->options['headerOffset']);
        $this->getCsv()->setDelimiter($this->options['delimiter']);

        return $this->getCsv();
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path): void
    {
        $this->path = $path;
    }

}