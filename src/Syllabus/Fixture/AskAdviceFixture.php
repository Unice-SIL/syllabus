<?php

namespace App\Syllabus\Fixture;

use App\Syllabus\Entity\AskAdvice;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AskAdviceFixture extends AbstractFixture  implements DependentFixtureInterface
{
    const ASK_ADVICE_1 = 'ask_advice_1';

    /**
     * @return array
     */
    protected function getDataEntities(): array
    {
        return [
            self::ASK_ADVICE_1 => [
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod 
        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco 
        laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse 
        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia 
        deserunt mollit anim id est laborum.',
                'comment' => 'comment',
                '@user' => UserFixture::USER_1,
                '@courseInfo' => CourseInfoFixture::COURSE_INFO_1
            ]
        ];
    }

    /**
     * @return string
     */
    protected function getEntityClassName(): string
    {
        return AskAdvice::class;
    }

    /**
     * @return string[]
     */
    public function getDependencies()
    {
        return [
            UserFixture::class,
            CourseInfoFixture::class,
        ];
    }
}