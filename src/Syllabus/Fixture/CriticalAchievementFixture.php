<?php


namespace App\Syllabus\Fixture;


use App\Syllabus\Entity\CriticalAchievement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class CriticalAchievementFixture extends Fixture implements FixtureGroupInterface
{
    /**
     *
     */
    const CRITICAL_ACHIEVEMENT_1 = 'critical_achievement_1';

    public function load(ObjectManager $manager)
    {
        $criticalAchievement = new CriticalAchievement();
        $criticalAchievement->setId(Uuid::uuid4())
            ->setLabel("Critical Achievement 1")
            ->setObsolete(false);
        $this->addReference(self::CRITICAL_ACHIEVEMENT_1, $criticalAchievement);
        $manager->persist($criticalAchievement);

        $manager->flush();
    }

    /**
     * This method must return an array of groups
     * on which the implementing class belongs to
     *
     * @return string[]
     */
    public static function getGroups(): array
    {
        return ['prod', 'test'];
    }
}