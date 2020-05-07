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

        // L0
        $level = new Level();
        $level->setCode('L0')
            ->setLabel('Licence 0');
        $levels[] = $level;

        // L1
        $level = new Level();
        $level->setCode('L1')
            ->setLabel('Licence 1');
        $levels[] = $level;

        // L2
        $level = new Level();
        $level->setCode('L2')
            ->setLabel('Licence 2');
        $levels[] = $level;

        // L3
        $level = new Level();
        $level->setCode('L3')
            ->setLabel('Licence 3');
        $levels[] = $level;

        // L3P
        $level = new Level();
        $level->setCode('L3P')
            ->setLabel('Licence 3 Pro');
        $levels[] = $level;

        // M1
        $level = new Level();
        $level->setCode('M1')
            ->setLabel('Master 1');
        $levels[] = $level;

        // M2
        $level = new Level();
        $level->setCode('M2')
            ->setLabel('Master 2');
        $levels[] = $level;

        // D
        $level = new Level();
        $level->setCode('D')
            ->setLabel('Doctorat');
        $levels[] = $level;

        // 1A
        $level = new Level();
        $level->setCode('1A')
            ->setLabel('1ère année');
        $levels[] = $level;

        // 2A
        $level = new Level();
        $level->setCode('2A')
            ->setLabel('2ème année');
        $levels[] = $level;

        // 3A
        $level = new Level();
        $level->setCode('3A')
            ->setLabel('3ème année');
        $levels[] = $level;

        // 4A
        $level = new Level();
        $level->setCode('4A')
            ->setLabel('4ème année');
        $levels[] = $level;

        // 5A
        $level = new Level();
        $level->setCode('5A')
            ->setLabel('5ème année');
        $levels[] = $level;

        // 6A
        $level = new Level();
        $level->setCode('6A')
            ->setLabel('6ème année');
        $levels[] = $level;

        // 7A
        $level = new Level();
        $level->setCode('7A')
            ->setLabel('7ème année');
        $levels[] = $level;

        // 8A
        $level = new Level();
        $level->setCode('8A')
            ->setLabel('8ème année');
        $levels[] = $level;

        // C1A
        $level = new Level();
        $level->setCode('C1A')
            ->setLabel('Capacité - 1ère année');
        $levels[] = $level;

        // C2A
        $level = new Level();
        $level->setCode('C2A')
            ->setLabel('Capacité - 2ème année');
        $levels[] = $level;

        // PEIP1
        $level = new Level();
        $level->setCode('PEIP1')
            ->setLabel('PeiP1');
        $levels[] = $level;

        // PEIP2
        $level = new Level();
        $level->setCode('PEIP2')
            ->setLabel('PeiP2');
        $levels[] = $level;

        return $levels;
    }

}