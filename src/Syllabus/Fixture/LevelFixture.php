<?php


namespace App\Syllabus\Fixture;


use App\Syllabus\Entity\Level;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class LevelFixture extends Fixture  implements FixtureGroupInterface
{
    public const LEVEL_L1 = 'Licence 1';
    public const LEVEL_L2 = 'Licence 2';
    public const LEVEL_L3 = 'Licence 3';

    public static function getGroups(): array
    {
        return ['test'];
    }

    public function load(ObjectManager $manager)
    {
        $levels = [
            [
                'label' => self::LEVEL_L1
            ],
            [
                'label' => self::LEVEL_L2
            ],
            [
                'label' => self::LEVEL_L3
            ],
        ];

        foreach ($levels as $l) {

            $level = new Level();

            $level->setLabel($l['label']);
            $manager->persist($level);
        }
        $manager->flush();
    }
}