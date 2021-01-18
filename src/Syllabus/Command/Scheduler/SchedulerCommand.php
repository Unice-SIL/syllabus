<?php


namespace App\Syllabus\Command\Scheduler;


use App\Syllabus\Entity\Job;
use Doctrine\ORM\EntityManagerInterface;
use GO\Scheduler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SchedulerCommand extends Command
{
    protected static $defaultName = 'app:scheduler';
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * SchedulerCommand constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }


    protected function configure()
    {
        $this
            ->setDescription('Check the planned command in db and run them');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $scheduler = new Scheduler();

        $jobs = $this->em->getRepository(Job::class)->findAll();
        foreach ($jobs as $job) {

            if (!in_array($job->getCommand(), \AppBundle\Constant\Job::COMMANDS)) {
                $job->setObsolete(true);
                continue;
            }

            $job->setObsolete(false);

            $command = 'php bin/console ' . $job->getCommand() . ' --job-id=' . $job->getId();

            if ($job->getLastStatus() === \AppBundle\Constant\Job::STATUS_IN_PROGRESS) {
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