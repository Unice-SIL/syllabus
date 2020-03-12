<?php


namespace AppBundle\Command\Test;

use AppBundle\Command\Scheduler\AbstractJob;
use AppBundle\Helper\Report\ReportingHelper;
use AppBundle\Helper\Report\ReportMessage;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Test2Command extends AbstractJob
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:test-2';

    protected function configure()
    {
        parent::configure();
        $this
            ->setDescription('Command to test something');
    }

    protected function subExecute(InputInterface $input, OutputInterface $output)
    {

        sleep(3);
        $report = ReportingHelper::createReport();
        $report->addMessage(new ReportMessage('hello'));
        return $report;
        //throw new \Exception('Exception test');
    }
}
