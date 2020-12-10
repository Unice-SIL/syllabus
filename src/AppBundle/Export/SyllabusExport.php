<?php


namespace AppBundle\Export;


use AppBundle\Service\AbstractExportService;
use Symfony\Component\Translation\TranslatorInterface;

class SyllabusExport extends AbstractExportService
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * SyllabusExport constructor.
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return array(
            $this->translator->trans('admin.export.course_name'),
            $this->translator->trans('admin.export.code'),
            $this->translator->trans('admin.export.publisher'),
            $this->translator->trans('admin.export.publication_date'),
            $this->translator->trans('admin.export.structure'),
            $this->translator->trans('admin.export.level')
        );
    }

    /**
     * @param $entity
     * @return array
     */
    public function getEntityFields($entity): array
    {
        $levelsString = '';
        if ($entity->getLevels())
        {
            $levelsLabel = [];
            foreach ($entity->getLevels() as $level)
            {
                $levelsLabel[] = $level->getLabel();
            }
            $levelsString = implode(';', $levelsLabel);
        }

        return array(
            $entity->getTitle(),
            $entity->getCourse() ? $entity->getCourse()->getCode(): '',
            $entity->getPublisher() ? $entity->getPublisher()->getFirstname().' '.$entity->getPublisher()->getLastname(): '',
            $entity->getPublicationDate() ? $entity->getPublicationDate()->format('d-m-Y') : '',
            $entity->getStructure() ? $entity->getStructure()->getLabel(): '',
            $levelsString
        );
    }
}