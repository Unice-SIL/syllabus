<?php


namespace AppBundle\Command\Scheduler;


use AppBundle\Entity\Cron;
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

        $crons = $this->em->getRepository(Cron::class)->findAll();
        foreach ($crons as $cron) {

            if (!in_array($cron->getCommand(), \AppBundle\Constant\Cron::COMMANDS)) {
                $cron->setObsolete(true);
                continue;
            }

            $cron->setObsolete(false);

            $command = 'php bin/console ' . $cron->getCommand() . ' --cron-id=' . $cron->getId();

            if ($cron->getLastStatus() === \AppBundle\Constant\Cron::STATUS_IN_PROGRESS) {
                continue;
            }

            if ($cron->isImmediately()) {
                $cron->setImmediately(false);
                $scheduler
                    ->raw($command)
                    ->at('* * * * *')
                ;

                continue;
            }

            $scheduler
                ->raw($command)
                ->at($cron->getFrequencyCronFormat())
            ;

        }

        $scheduler->run();

        $this->em->flush();

    }


}