<?php

namespace App\Syllabus\Fixture;

use App\Syllabus\Entity\Year;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class YearFixture
 * @package App\Syllabus\Fixture
 */
class YearFixture extends Fixture  implements FixtureGroupInterface
{
    /**
     *
     */
    public const YEAR_2013 = '2013';
    public const YEAR_2014 = '2014';
    public const YEAR_2015 = '2015';
    public const YEAR_2016 = '2016';
    public const YEAR_2017 = '2017';
    public const YEAR_2018 = '2018';
    public const YEAR_2019 = '2019';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        $years = [
          [
              'id' => self::YEAR_2013,
              'label' => '2013-2014',
              'import' => false,
              'current' => false,
              'ref' => self::YEAR_2013
          ],
            [
                'id' => self::YEAR_2014,
                'label' => '2014-2015',
                'import' => false,
                'current' => false,
                'ref' => self::YEAR_2014
            ],
            [
                'id' => self::YEAR_2015,
                'label' => '2015-2016',
                'import' => false,
                'current' => false,
                'ref' => self::YEAR_2015
            ],
            [
                'id' => self::YEAR_2016,
                'label' => '2016-2017',
                'import' => false,
                'current' => false,
                'ref' => self::YEAR_2016
            ],
            [
                'id' => self::YEAR_2017,
                'label' => '2017-2018',
                'import' => false,
                'current' => false,
                'ref' => self::YEAR_2017
            ],
            [
                'id' => self::YEAR_2018,
                'label' => '2018-2019',
                'import' => false,
                'current' => false,
                'ref' => self::YEAR_2018
            ],
            [
                'id' => self::YEAR_2019,
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