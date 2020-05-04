<?php


namespace AppBundle\Command\Migration;


use AppBundle\Entity\Language;
use AppBundle\Entity\Level;

/**
 * Class LevelMigration
 * @package AppBundle\Command\Migration
 */
class LevelMigration extends AbstractReferentialMigration
{

    protected static $defaultName = 'app:level-migration';

    /**
     * @return string
     */
    protected function getStartMessage(): string
    {
        return 'Start of levels creation';
    }

    /**
     * @return string
     */
    protected function getEndMessage(): string
    {
        return 'End of levels creation';
    }

    /**
     * @return string
     */
    protected function getEntityClassName(): string
    {
        return Level::class;
    }

    /**
     * @return array
     */
    protected function getEntities(): array
    {
        $levels = [];

        // DU
        $du = new Level();
        $du->setCode('DU')
            ->setLabel('Diplôme Universitaire');
        $levels[] = $du;

        // L1
        $l1 = new Level();
        $l1->setCode('L1')
            ->setLabel('Licence 1');
        $levels[] = $l1;

        // L2
        $l2 = new Level();
        $l2->setCode('L2')
            ->setLabel('Licence 2');
        $levels[] = $l2;

        // L3
        $l3 = new Level();
        $l3->setCode('L3')
            ->setLabel('Licence 3');
        $levels[] = $l3;

        // MASTER
        $master = new Level();
        $master->setCode('MASTER')
            ->setLabel('Master');
        $levels[] = $master;

        return $levels;
    }

}