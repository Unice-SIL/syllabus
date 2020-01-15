<?php

namespace AppBundle\Fixture;

use AppBundle\Entity\Year;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class YearFixture
 * @package AppBundle\Fixture
 */
class YearFixture extends Fixture  implements FixtureGroupInterface
{
    /**
     *
     */
    public const YEAR_2018 = 'year2018';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $year = new Year();
        $year->setId('2018')
            ->setLabel('2018-2019')
            ->setImport(true)
            ->setCurrent(true);
        $this->addReference(self::YEAR_2018, $year);
        $manager->persist($year);
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['prod', 'test'];
    }
}