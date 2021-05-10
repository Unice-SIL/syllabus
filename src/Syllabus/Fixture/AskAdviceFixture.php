<?php


namespace App\Syllabus\Fixture;


use App\Syllabus\Entity\AskAdvice;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AskAdviceFixture extends Fixture  implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $askDevice1 = new AskAdvice();
        $askDevice1->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod 
        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco 
        laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse 
        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia 
        deserunt mollit anim id est laborum.')
            ->setUser($this->getReference('user_'.UserFixture::USER_STEPHANE))
            ->setCourseInfo($this->getReference(CourseInfoFixture::COURSE_INFO_1));
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return class-string[]
     */
    public function getDependencies()
    {
        return [
            UserFixture::class,
            CourseInfoFixture::class,
        ];
    }
}