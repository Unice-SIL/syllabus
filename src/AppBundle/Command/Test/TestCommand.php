<?php


namespace AppBundle\Command\Test;

use AppBundle\Command\Scheduler\AbstractCron;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends AbstractCron
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:test';

    protected function configure()
    {
        parent::configure();
        $this
            ->setDescription('Command to test something');
    }

    protected function subExecute(InputInterface $input, OutputInterface $output)
    {
        sleep(1);

    }
}
