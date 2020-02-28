<?php


namespace AppBundle\Parser;


use AppBundle\Helper\Report\Report;
use AppBundle\Helper\Report\ReportingHelper;
use AppBundle\Helper\Report\ReportLine;
use Doctrine\ORM\EntityManagerInterface;
use Exception;use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

abstract class AbstractParser
{

    /**
     * @var Report
     */
    private $report;
    /**
     * @var PropertyAccessor
     */
    protected $propertyAccessor;
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * AbstractParser constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {

        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();

        $this->em = $em;
    }

    /**
     * @return Report
     */
    public function getReport(): Report
    {
        return $this->report;
    }

    /**
     * @param Report $report
     */
    private function setReport(Report $report)
    {
        $this->report = $report;
    }

    public function resetReport()
    {
        $this->setReport(ReportingHelper::createReport());
    }

    public function parse(string $source, array $options = []): array
    {

        $options = array_merge([
            'report' => ReportingHelper::createReport('Parsing')
        ], $options);

        if (!$options['report'] instanceof Report) {
            throw new Exception('The report shoud be of type ' . Report::class);
        }

        $this->setReport($options['report']);

        return $this->subParse($source, $options, $this->getReport());
    }

    abstract protected function subParse(string $source, array $options, Report $report): array;

    abstract protected function getNewEntity(): object;

    abstract protected function manageSpecialCase($entity, string $property, string $name, string $type, $data, ReportLine $reportLine): bool;

    abstract protected function getLineIds(): array;

    /**
     * example : [
     *     'title' => [
     *          'name' => 'Titre' // (name in the csv) optional, by default the name is the array key
     *          'type' => 'string' // (type in the entity) optional by default is string
     *          'nullable' => false //  optional by default is false
     *          'choices' => [] //  optional by default is []
     *          'findBy' => 'id' // optional by default is 'id'
     *          'entity' => null // (entity classname) optional by default is null
     *          'required' => false // optional by default is false
     *          'description' => '' // optional by default is null
     *      ]
     * ]
     */
    abstract protected function getBaseMatching(): array;

    public function getCompleteMatching()
    {
        $matching = $this->getBaseMatching();

        foreach ($matching as $key => $value) {
            $property = $value;
            $name = $value;
            $type = 'string';
            $nullable = false;
            $choices = [];
            $findBy = 'id';
            $entity = null;
            $required = false;
            $description = null;
            if (is_array($value)) {
                $property = $key;
                $name = isset($value['name']) ? $value['name'] :  $property;
                $type = isset($value['type']) ? $value['type'] : $type;
                $nullable = isset($value['nullable']) ? $value['nullable'] : $nullable;
                $choices = isset($value['choices']) ? $value['choices'] : $choices;
                $findBy = isset($value['findBy']) ? $value['findBy'] : $findBy;
                $entity = isset($value['entity']) ? $value['entity'] : $entity;
                $required = isset($value['required']) ? $value['required'] : $required;
                $description = isset($value['description']) ? $value['description'] : $description;

            }

            yield $property => [ 'name' => $name,
                'type' => $type,
                'nullable' => $nullable,
                'choices' => $choices,
                'entity' => $entity,
                'findBy' => $findBy,
                'required' => $required,
                'description' => $description
            ];
        }
    }

    /**
     *
     * @param string $type (could be source|entity)
     * @return array
     */
    protected function getFields($type = 'source'): array
    {
        $fields = [];
        if ('entity' === $type) {
            foreach ($this->getCompleteMatching() as $property => $match) {
                $fields[] = $property;
            }
            return $fields;
        }

        if ('source' === $type) {
            foreach ($this->getCompleteMatching() as $match) {
                $fields[] = $match['name'];
            }
            return $fields;
        }

    }

}