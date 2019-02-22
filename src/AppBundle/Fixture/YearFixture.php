<?php

namespace AppBundle\Fixture;

use AppBundle\Entity\Year;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class YearFixture
 * @package AppBundle\Fixture
 */
class YearFixture extends Fixture
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
            ->setLabel('2018-2019');
        $this->addReference(self::YEAR_2018, $year);
        $manager->persist($year);
        $manager->flush();
    }

}