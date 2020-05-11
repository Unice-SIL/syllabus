<?php


namespace AppBundle\Command\Migration;


use AppBundle\Entity\Period;
use AppBundle\Entity\Structure;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Translatable\Entity\Translation;

/**
 * Class PeriodMigration
 * @package AppBundle\Command\Migration
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

        // S1
        $period = new Period();
        $period->setCode('S1')
            ->setLabel('Semestre 1')
            ->setStructures($structuresOther);
        $repo->translate($period, 'label', 'en', 'Semester 1');
        $periods[] = $period;

        // S2
        $period = new Period();
        $period->setCode('S2')
            ->setLabel('Semestre 2')
            ->setStructures($structuresOther);
        $repo->translate($period, 'label', 'en', 'Semester 2');
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