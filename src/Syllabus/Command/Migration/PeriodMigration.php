<?php


namespace App\Syllabus\Command\Migration;


use App\Syllabus\Entity\Period;
use App\Syllabus\Entity\Structure;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Translatable\Entity\Translation;

/**
 * Class PeriodMigration
 * @package App\Syllabus\Command\Migration
 */
class PeriodMigration extends AbstractReferentialMigration
{

    protected static $defaultName = 'app:period-migration';

    /**
     * @return string
     */
    protected function getStartMessage(): string
    {
        return 'Start of periods creation';
    }

    /**
     * @return string
     */
    protected function getEndMessage(): string
    {
        return 'End of periods creation';
    }

    /**
     * @return string
     */
    protected function getEntityClassName(): string
    {
        return Period::class;
    }

    /**
     * @return array
     */
    protected function getEntities(): array
    {
        $repo = $this->em->getRepository(Translation::class);

        $structures = $this->em->getRepository(Structure::class)->findAll();

        $structuresEpu = new ArrayCollection(array_filter($structures, function(Structure $structure){
            return ($structure->getCode() === 'EPU' || $structure->getCode() === 'EP') ? true : false;
        }));
        $structuresOther = new ArrayCollection(array_diff($structures, $structuresEpu->toArray()));

        $periods = [];

        // SP
        $period = new Period();
        $period->setCode('SI')
            ->setLabel('Semestre impair')
            ->setStructures($structuresOther);
        $repo->translate($period, 'label', 'en', 'Odd Semester');
        $periods[] = $period;

        // S2
        $period = new Period();
        $period->setCode('S2')
            ->setLabel('Semestre paire')
            ->setStructures($structuresOther);
        $repo->translate($period, 'label', 'en', 'Even semester');
        $periods[] = $period;

        // AUTOMNE
        $period = new Period();
        $period->setCode('AUTOMNE')
            ->setLabel('Automne')
            ->setStructures($structuresEpu);
        $repo->translate($period, 'label', 'en', 'Autumn');
        $periods[] = $period;

        // PRINTEMPS
        $period = new Period();
        $period->setCode('PRINTEMPS')
            ->setLabel('Printemps')
            ->setStructures($structuresEpu);
        $repo->translate($period, 'label', 'en', 'Spring');
        $periods[] = $period;

        return $periods;
    }

}