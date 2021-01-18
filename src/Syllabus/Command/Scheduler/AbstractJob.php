<?php


namespace App\Syllabus\Command\Scheduler;

use App\Syllabus\Entity\Job;
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
     * @var string
     */
    private $jobId;

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
        $this->addOption('job-id',null, InputOption::VALUE_OPTIONAL, 'The job id referenced in the database');
    }


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $this->jobId = $input->getOption('job-id');


        $job = $this->getJob();

        if ($job instanceof Job) {

            $job->setLastUseStart(new \DateTime());
            $job->setLastUseEnd(null);

            $job->setLastStatus(\AppBundle\Constant\Job::STATUS_IN_PROGRESS);

            $this->em->flush();
        }

        try {
            $result = $this->subExecute($input, $output);
        } catch (\Exception $e) {

            $job = $this->getJob();
            if ($job instanceof  Job) {

                $job->setLastStatus(\AppBundle\Constant\Job::STATUS_FAILED);
                $job->setReport(serialize($e->getMessage()));
                $this->em->flush();

            }

            throw $e;
        }

        $job = $this->getJob();
        if ($job instanceof Job) {

            $job->setLastStatus(\AppBundle\Constant\Job::STATUS_SUCCESS);
            $job->setProgress(0);
            $job->setMemoryUsed(0);
            $job->setReport(serialize($result));
            $this->em->flush();

        }
    }

    /**
     * @return object|null
     */
    protected function getJob()
    {
        if($this->jobId)
        {
            return $job = $this->em->getRepository(Job::class)->find($this->jobId);
        }
        return null;
    }

    /**
     * @param int $progress
     * @param bool $flush
     */
    protected function progress(int $progress, bool $flush = false)
    {
        $job = $this->getJob();
        if($job instanceof Job)
        {
            $job->setProgress($progress);
            if($flush)
            {
                $this->em->flush();
            }
        }
    }

    /**
     * @param int $memoryUsed
     * @param bool $flush
     */
    protected function memoryUsed(int $memoryUsed, bool $flush = false)
    {
        $job = $this->getJob();
        if($job instanceof Job)
        {
            $job->setMemoryUsed($memoryUsed);
            if($flush)
            {
                $this->em->flush();
            }
        }
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     */
    abstract protected function subExecute(InputInterface $input, OutputInterface $output);
}