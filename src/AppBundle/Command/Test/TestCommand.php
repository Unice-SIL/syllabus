<?php


namespace AppBundle\Command\Test;

use AppBundle\Entity\CourseInfo;
use AppBundle\Manager\CourseInfoManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:test';
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var CourseInfoManager
     */
    private $courseInfoManager;

    public function __construct(EntityManagerInterface $em, CourseInfoManager $courseInfoManager)
    {
        parent::__construct();
        $this->em = $em;
        $this->courseInfoManager = $courseInfoManager;
    }


    protected function configure()
    {
        $this
            ->setDescription('Command to test a function');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $courseInfoData = $this->em->find(CourseInfo::class, '6760fbcf-8b08-4b71-8cf2-7219700954ff');
        $this->courseInfoManager->createOrUpdate($courseInfoData, ['flush' => true, 'validation_groups' => ['new', 'presentation']]);

    }
}
