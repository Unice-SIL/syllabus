<?php


namespace App\Syllabus\Fixture;


use App\Syllabus\Entity\Period;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class PeriodFixture extends Fixture  implements FixtureGroupInterface
{
    public const PERIOD_1 = 'Mensuelle';
    public const PERIOD_2 = 'Trimestrielle';
    public const PERIOD_3 = 'Semestrielle';
    public const PERIOD_4 = 'Annuelle';

    public function load(ObjectManager $manager)
    {
        $period = new Period();
        $period->setLabel(self::PERIOD_1);
        $this->addReference(self::PERIOD_1, $period);
        $manager->persist($period);


        $periods = [
            ['label' => self::PERIOD_2],
            ['label' => self::PERIOD_3],
            ['label' => self::PERIOD_4]
        ];

        foreach ($periods as $p) {
            $period = new Period();
            $period->setLabel($p['label']);
            $manager->persist($period);
        }
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['test'];
    }
}