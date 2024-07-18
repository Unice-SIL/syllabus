<?php


namespace App\Syllabus\Command\Scheduler;


use App\Syllabus\Entity\Job;
use Doctrine\ORM\EntityManagerInterface;
use GO\Scheduler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:scheduler',
)]
class SchedulerCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * SchedulerCommand constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }


    protected function configure(): void
    {
        $this
            ->setDescription('Check the planned command in db and run them');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $scheduler = new Scheduler();

        $jobs = $this->em->getRepository(Job::class)->findAll();
        foreach ($jobs as $job) {

            if (!in_array($job->getCommand(), \App\Syllabus\Constant\Job::COMMANDS)) {
                $job->setObsolete(true);
                continue;
            }

            $job->setObsolete(false);

            $command = 'php bin/console ' . $job->getCommand() . ' --job-id=' . $job->getId();

            if ($job->getLastStatus() === \App\Syllabus\Constant\Job::STATUS_IN_PROGRESS) {
                continue;
            }

            if ($job->isImmediately()) {
                $job->setImmediately(false);
                $scheduler
                    ->raw($command)
                    ->at('* * * * *')
                ;

                continue;
            }

            $scheduler
                ->raw($command)
                ->at($job->getFrequencyJobFormat())
            ;

        }

        $scheduler->run();

        $this->em->flush();

    }


}