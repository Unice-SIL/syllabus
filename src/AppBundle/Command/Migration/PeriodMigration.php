<?php


namespace AppBundle\Command\Migration;


use AppBundle\Entity\Language;
use AppBundle\Entity\Level;
use AppBundle\Entity\Period;
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

        $periods = [];

        // S1
        $period = new Period();
        $period->setCode('S1')
            ->setLabel('Semestre 1');
        $repo->translate($period, 'label', 'en', 'Semester 1');
        $periods[] = $period;

        // S2
        $period = new Period();
        $period->setCode('S2')
            ->setLabel('Semestre 2');
        $repo->translate($period, 'label', 'en', 'Semester 2');
        $periods[] = $period;

        // S3
        $period = new Period();
        $period->setCode('S3')
            ->setLabel('Semestre 3');
        $repo->translate($period, 'label', 'en', 'Semester 3');
        $periods[] = $period;

        // S4
        $period = new Period();
        $period->setCode('S4')
            ->setLabel('Semestre 4');
        $repo->translate($period, 'label', 'en', 'Semester 4');
        $periods[] = $period;

        // S5
        $period = new Period();
        $period->setCode('S5')
            ->setLabel('Semestre 5');
        $repo->translate($period, 'label', 'en', 'Semester 5');
        $periods[] = $period;

        // S6
        $period = new Period();
        $period->setCode('S6')
            ->setLabel('Semestre 6');
        $repo->translate($period, 'label', 'en', 'Semester 6');
        $periods[] = $period;


        return $periods;
    }

}