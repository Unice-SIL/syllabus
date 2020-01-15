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
    public const YEAR_2013 = 'year2013';
    public const YEAR_2014 = 'year2014';
    public const YEAR_2015 = 'year2015';
    public const YEAR_2016 = 'year2016';
    public const YEAR_2017 = 'year2017';
    public const YEAR_2018 = 'year2018';
    public const YEAR_2019 = 'year2019';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        $years = [
          [
              'id' => '2013',
              'label' => '2013-2014',
              'import' => true,
              'current' => false,
              'ref' => self::YEAR_2013
          ],
            [
                'id' => '2014',
                'label' => '2014-2015',
                'import' => true,
                'current' => false,
                'ref' => self::YEAR_2014
            ],
            [
                'id' => '2015',
                'label' => '2015-2016',
                'import' => true,
                'current' => false,
                'ref' => self::YEAR_2015
            ],
            [
                'id' => '2016',
                'label' => '2016-2017',
                'import' => true,
                'current' => false,
                'ref' => self::YEAR_2016
            ],
            [
                'id' => '2017',
                'label' => '2017-2018',
                'import' => true,
                'current' => false,
                'ref' => self::YEAR_2017
            ],
            [
                'id' => '2018',
                'label' => '2018-2019',
                'import' => true,
                'current' => false,
                'ref' => self::YEAR_2018
            ],
            [
                'id' => '2019',
                'label' => '2019-2020',
                'import' => true,
                'current' => true,
                'ref' => self::YEAR_2019
            ]
        ];

        foreach ($years as $y) {

            $year = new Year();
            $year->setId($y['id'])
                ->setLabel($y['label'])
                ->setImport($y['import'])
                ->setCurrent($y['current']);
            $this->addReference($y['ref'], $year);
            $manager->persist($year);
        }
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['prod', 'test'];
    }
}