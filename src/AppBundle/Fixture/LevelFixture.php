<?php


namespace AppBundle\Fixture;


use AppBundle\Entity\Level;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class LevelFixture extends Fixture  implements FixtureGroupInterface
{
    public const LEVEL_BEGINNER = 'beginner';
    public const LEVEL_INTERMEDIATE = 'intermediate';
    public const LEVEL_COFIRMED = 'confirmed';

    public static function getGroups(): array
    {
        return ['test'];
    }

    public function load(ObjectManager $manager)
    {
        $levels = [
            [
                'label' => self::LEVEL_BEGINNER
            ],
            [
                'label' => self::LEVEL_INTERMEDIATE
            ],
            [
                'label' => self::LEVEL_COFIRMED
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