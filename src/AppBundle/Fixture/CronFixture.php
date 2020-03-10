<?php

namespace AppBundle\Fixture;

use AppBundle\Entity\Job;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class JobFixture
 * @package AppBundle\Fixture
 */
class JobFixture extends Fixture
{

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        $jobs = [
            [
              'label' => 'Test 2',
              'command' => \AppBundle\Constant\Job::COMMAND_TEST_2,
              'frequencyJobFormat' => '* * * * *',
            ],
            [
                'label' => 'Test',
                'command' => \AppBundle\Constant\Job::COMMAND_TEST,
                'frequencyJobFormat' => '* * * * *',
            ],

        ];

        foreach ($jobs as $c) {

            $jobs = new Job();
            $jobs->setLabel($c['label'])
                ->setCommand($c['command'])
                ->setFrequencyJobFormat($c['frequencyJobFormat']);
            $manager->persist($jobs);
        }
        $manager->flush();
    }

}