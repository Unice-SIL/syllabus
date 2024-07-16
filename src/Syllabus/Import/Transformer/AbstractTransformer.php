<?php


namespace App\Syllabus\Import\Transformer;


use App\Syllabus\Helper\Report\ReportLine;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

abstract class AbstractTransformer
{
    protected PropertyAccessor $propertyAccessor;
    protected EntityManagerInterface $em;

    /**
     * AbstractTransformer constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
        $this->em = $em;
    }

    protected function getReportLine($lineIds, $offset, $record): ReportLine
    {
        $reportLine = new ReportLine($offset);
        $header = array_keys($record);

        if (count($missingFields = array_diff($lineIds, $header)) > 0) {
            $reportLine->addComment(
                "Les champs suivants sont nécessaires pour pouvoir identifier cette ligne : "
                . implode(',', $lineIds)
                . ". Il manque le(s) champ(s) " . implode(',', $missingFields)
            );

            return $reportLine;
        }

        $lineId = '';
        foreach ($lineIds as $id) {

            $lineId .= $record[$id];
        }

        $reportLine->setId($lineId);

        return $reportLine;
    }

}