<?php


namespace AppBundle\Command\Scheduler;

use AppBundle\Entity\Cron;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractCron extends Command
{
    protected $em;

    public function __construct(EntityManagerInterface $em) {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure()
    {
        $this->addOption('cron-id',null, InputOption::VALUE_OPTIONAL);
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cron = null;

        if ($input->getOption('cron-id')) {
            $cron = $this->em->find(Cron::class, $input->getOption('cron-id'));
            if ($cron instanceof Cron) {

                $cron->setLastUseStart(new \DateTime());
                $cron->setLastUseEnd(null);

                $cron->setLastStatus(\AppBundle\Constant\Cron::STATUS_IN_PROGRESS);

                $this->em->flush();
            }
        }

        try {
            $result = $this->subExecute($input, $output);
        } catch (\Exception $e) {

            if ($cron instanceof  Cron) {

                $cron->setLastStatus(\AppBundle\Constant\Cron::STATUS_FAILED);
                $cron->setReport(serialize($e->getMessage()));
                $this->em->flush();

            }

            throw $e;
        }

        if ($cron instanceof Cron) {

            $cron->setLastStatus(\AppBundle\Constant\Cron::STATUS_SUCCESS);
            $cron->setReport(serialize($result));
            $this->em->flush();

        }
    }

    abstract protected function subExecute(InputInterface $input, OutputInterface $output);
}