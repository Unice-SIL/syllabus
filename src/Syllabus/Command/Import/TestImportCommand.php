<?php


namespace App\Syllabus\Command\Import;



use App\Syllabus\Command\Scheduler\AbstractJob;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestImportCommand extends AbstractJob
{
    protected static $defaultName = 'app:import:test';

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function subExecute(InputInterface $input, OutputInterface $output)
    {
        $totalExecutionTimeInSecond = 900;
        $interval = $totalExecutionTimeInSecond / 100;
        $progress = 0;

        for ($i=0; $i<100; $i++)
        {
            sleep($interval);
            $this->progress(++$progress, true);
            dump($progress);
        }

        return;

    }

}