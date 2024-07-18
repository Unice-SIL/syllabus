<?php


namespace App\Syllabus\Command\Import;

use App\Syllabus\Command\Scheduler\AbstractJob;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:import:test',
)]
class TestImportCommand extends AbstractJob
{
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     */
    protected function subExecute(InputInterface $input, OutputInterface $output): mixed
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

        return null;

    }

}