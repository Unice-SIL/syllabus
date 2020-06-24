<?php


namespace AppBundle\Command\Scheduler;

use AppBundle\Entity\Job;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AbstractJob
 * @package AppBundle\Command\Scheduler
 */
abstract class AbstractJob extends Command
{

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * AbstractJob constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em) {
        parent::__construct();
        $this->em = $em;
    }

    /**
     *
     */
    protected function configure()
    {
        $this->addOption('job-id',null, InputOption::VALUE_OPTIONAL);
    }


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $job = null;

        if ($input->getOption('job-id')) {
            $job = $this->em->find(Job::class, $input->getOption('job-id'));
            if ($job instanceof Job) {

                $job->setLastUseStart(new \DateTime());
                $job->setLastUseEnd(null);

                $job->setLastStatus(\AppBundle\Constant\Job::STATUS_IN_PROGRESS);

                $this->em->flush();
            }
        }

        try {
            $result = $this->subExecute($input, $output);
        } catch (\Exception $e) {

            if ($job instanceof  Job) {

                $job->setLastStatus(\AppBundle\Constant\Job::STATUS_FAILED);
                $job->setReport(serialize($e->getMessage()));
                $this->em->flush();

            }

            throw $e;
        }

        if ($job instanceof Job) {

            $job->setLastStatus(\AppBundle\Constant\Job::STATUS_SUCCESS);
            $job->setReport(serialize($result));
            $this->em->flush();

        }
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     */
    abstract protected function subExecute(InputInterface $input, OutputInterface $output);
}