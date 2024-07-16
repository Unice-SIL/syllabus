<?php


namespace App\Syllabus\Import\Transformer;


use App\Syllabus\Helper\Report\Report;
use App\Syllabus\Helper\Report\ReportLine;
use App\Syllabus\Import\Matching\HourApogeeMatching;
use App\Syllabus\Import\Matching\MatchingInterface;

class ArrayTransformer extends AbstractTransformer implements TransformerInterface
{

    private array $options = [
        'allow_extra_field' => false,
        'allow_less_field' => false
    ];

    public function transform($dataToTransform, MatchingInterface $parser, $options = [], Report $report = null): array
    {
        $this->options = array_merge($this->options, $options);

        $entities = [];

        foreach ($dataToTransform as $offset => $record) {

            $reportLine = $this->getReportLine($parser->getLineIds(), $offset, $record);

            $this->checkHeaderErrors(array_keys($record), $parser, $reportLine);

            if ($report->addLineIfHasComments($reportLine)) {
                continue;
            }


            $entity = $parser->getNewEntity();


            foreach ($parser->getCompleteMatching() as $property => $match) {

                $name = $match['name'];
                $type = $match['type'];

                if(!array_key_exists($name, $record))
                {
                    continue;
                }

                $data = $record[$name];

                $isDataNull = $this->isNull($data);

                if (true === $match['required'] and $isDataNull) {
                    $reportLine->addComment("Le champ {$name} ne doit pas être vide");
                }
                if (true === $match['required'] or (false === $match['required'] and !$isDataNull)) {

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
                        /*
                        if(!is_numeric($data)) {
                            $reportLine->addComment("La valeur du champ {$name} devrait être un nombre. La valeur saisie est {$data}");
                            continue;
                        }
                        */
                        $data = (int) $data;
                    }

                    if($type === 'float') {
                        /*
                        if(!is_numeric($data)) {
                            $reportLine->addComment("La valeur du champ {$name} devrait être un nombre. La valeur saisie est {$data}");
                            continue;
                        }
                        */
                        $data = (float) preg_replace(['/,/', '/\s/'], ['.', ''], $data);
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

                }

                $keepGoing = $parser->manageSpecialCase($entity, $property, $name, $type, $data, $reportLine, $report);

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
                $entities[$reportLine->getId()] = $entity;
                continue;
            }
        }

        $report->finishReport(count($dataToTransform));

        return $entities;
    }

    private function checkHeaderErrors($header, MatchingInterface $parser, ReportLine $reportLine): void
    {
        $fields = $parser->getFields();

        if (
            false === $this->options['allow_extra_field']
            and count($unknownFields = array_diff($header, $fields)) > 0
        ) {

            $reportLine->addComment(
                "Les champs suivants ne font pas partis de la liste des champs autorisés : "
                . implode(',', $unknownFields) . ". Sont autorisés les champs " . implode(',', $fields)
            );
        }

        if (
            false === $this->options['allow_less_field']
            and count($missingFields = array_diff($fields, $header)) > 0
        ) {
            $reportLine->addComment(
                "Les champs suivants sont manquants : " . implode(',', $missingFields)
                . ". Sont obligatoires les champs " . implode(',', $fields)
            );
        }
    }

    private function isNull($value): bool
    {
        return in_array($value, [null, '']);
    }
}