<?php


namespace AppBundle\Fixture;


use AppBundle\Entity\Campus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class CampusFixture extends Fixture  implements FixtureGroupInterface
{

    public const CAMPUS_1 = 'Valrose';
    public const CAMPUS_2 = 'Carlone';
    public const CAMPUS_3 = 'St Angely';

    public function load(ObjectManager $manager)
    {
        $campuses = [
            [
                'label' => self::CAMPUS_1
            ],
            [
                'label' => self::CAMPUS_2
            ],
            [
                'label' => self::CAMPUS_3
            ],
        ];

        foreach ($campuses as $c) {

            $campus = new Campus();
            $campus->setLabel($c['label']);
            $manager->persist($campus);
        }
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['test'];
    }
}