<?php


namespace AppBundle\Parser;

use AppBundle\Helper\Report\Report;
use AppBundle\Helper\Report\ReportLine;
use AppBundle\Helper\Report\ReportMessage;
use League\Csv\AbstractCsv;
use League\Csv\Reader;

abstract class AbstractCsvParser extends AbstractParser
{

    private $csv;

    /**
     * @return AbstractCsv
     */
    public function getCsv(): AbstractCsv
    {
        return $this->csv;
    }

    /**
     * @param AbstractCsv $csv
     * @return AbstractCsvParser
     */
    private function setCsv(AbstractCsv $csv): self
    {
        $this->csv = $csv;
        return $this;
    }
    

    public function subParse($source, $options = [], Report $report): array
    {

        $options = array_merge([
            'headerOffset' => 0,
            'delimiter' => ';',
            'allow_extra_field' => false,
            'allow_less_field' => false
        ], $options);

        $this->setCsv(Reader::createFromPath($source));
        $this->getCsv()->setHeaderOffset($options['headerOffset']);
        $this->getCsv()->setDelimiter($options['delimiter']);

        $fields = $this->getFields();

        if(
            false === $options['allow_extra_field']
            and count($unknowFields = array_diff($this->getCsv()->getHeader(), $fields)) > 0
        )
        {
            $report->createMessage(
                "Les champs suivants ne font pas partis de la liste des champs autorisés : "
                . implode(',', $unknowFields) .". Sont autorisés les champs " . implode(',', $fields),
                ReportMessage::TYPE_DANGER
            );
        }

        if(
            false === $options['allow_less_field']
            and count($missingFields = array_diff($fields, $this->getCsv()->getHeader())) > 0
        )
        {
            $report->createMessage(
                "Les champs suivants sont manquants : " . implode(',', $missingFields)
                . ". Sont obligatoires les champs " . implode(',', $fields),
                ReportMessage::TYPE_DANGER
            );
        }

        $lineIds = $this->getLineIds();
        if (count($missingFields = array_diff($lineIds, $this->getCsv()->getHeader())) > 0)
        {
            $report->createMessage(
                "Les champs suivants sont nécessaires pour pouvoir identifier les lignes : "
                . implode(',', $lineIds)
                . ". Il manque le(s) champ(s) " . implode(',', $missingFields),
                ReportMessage::TYPE_DANGER
            );
        }

        if (!$report->getMessages()->isEmpty()) {
            return [];
        }

        $entities = [];
        foreach ($this->getCsv() as $offset => $record) {

            $lineId = '';
            foreach ($lineIds as $id) {
                $lineId .= $record[$id];
            }
            $reportLine = new ReportLine($lineId);
            $entity = $this->getNewEntity();

            foreach ($this->getCompleteMatching() as $property => $match) {
                $name = $match['name'];
                $type = $match['type'];
                if(!array_key_exists($name, $record))
                {
                    continue;
                }

                $data = $record[$name];

                //============================ Move to AbstractParser =================================
                if (false === $match['nullable'] and in_array($data, [null, ''])) {
                    $reportLine->addComment("Le champ {$name} ne doit pas être vide");
                    continue;
                }

                if ($type === 'boolean') {
                    $booleanMatching = [
                        'true' => ['OUI', 'TRUE', '1'],
                        'false' => ['NON', 'FALSE', '0'],
                    ];

                    if (in_array(strtoupper($data), $booleanMatching['true'])) {
                        $data = true;
                    } elseif (in_array(strtoupper($data), $booleanMatching['false'])) {
                        $data = false;
                    } else {
                        $reportLine->addComment("La valeur du champ {$name} devrait être "
                            . implode(',', $booleanMatching['true'])
                            . " ou " . implode(',', $booleanMatching['false']) . ". La valeur saisie est {$data}.");
                    }
                }

                if (null === $match['choices'] && !in_array($data, $match['choices'])) {
                    $reportLine->addComment("Le champ {$name} doit contenir une des valeurs suivante: ".implode(', ', $match['choices']));
                }

                if($type === 'int') {
                    if(!is_numeric($data)) {
                        $reportLine->addComment("La valeur du champ {$name} devrait être un nombre. La valeur saisie est {$data}");
                        continue;
                    }
                    $data = (int) $data;
                }

                if($type === 'object') {
                    if(!isset($match['entity'])) {
                        throw new \Exception('A field with type object must defined a index "entity" in the matching');
                    }

                    $oldData = $data;
                    $data = $this->em->getRepository($match['entity'])->findOneBy([$match['findBy'] => $data]);

                    if (!$data instanceof $match['entity']) {

                        $reportLine->addComment('La relation sur le champ ' . $property . ' de valeur ' . $oldData . ' n\'existe pas.');
                        continue;
                    }

                }
                //============================ End Move to AbstractParser =================================

                $keepGoing = $this->manageSpecialCase($entity, $property, $name, $type, $data, $reportLine);

                if (false === $keepGoing) {
                    continue;
                }

                try {
                    $this->propertyAccessor->setValue($entity, $property, $data);
                }catch (\Exception $e) {
                    $reportLine->addComment('Un problème inconnu est survenu.');
                }


            }

            if (!$report->addLineIfHasComments($reportLine)) {
                $entities[$lineId] = $entity;
                continue;
            }

        }

        $report->finishReport(iterator_count($this->getCsv()));

        return $entities;
    }

}