<?php

namespace AppBundle\Fixture;

use AppBundle\Entity\Cron;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class CronFixture
 * @package AppBundle\Fixture
 */
class CronFixture extends Fixture
{

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        $crons = [
            [
              'label' => 'Test 2',
              'command' => \AppBundle\Constant\Cron::COMMAND_TEST_2,
              'frequencyCronFormat' => '* * * * *',
            ],
            [
                'label' => 'Test',
                'command' => \AppBundle\Constant\Cron::COMMAND_TEST,
                'frequencyCronFormat' => '* * * * *',
            ],

        ];

        foreach ($crons as $c) {

            $cron = new Cron();
            $cron->setLabel($c['label'])
                ->setCommand($c['command'])
                ->setFrequencyCronFormat($c['frequencyCronFormat']);
            $manager->persist($cron);
        }
        $manager->flush();
    }

}