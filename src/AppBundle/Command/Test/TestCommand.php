<?php


namespace AppBundle\Command\Test;

use AppBundle\Entity\Course;
use AppBundle\Entity\CourseInfo;
use AppBundle\Manager\CourseInfoManager;
use AppBundle\Manager\CourseManager;
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
    private $courseManager;

    public function __construct(EntityManagerInterface $em, CourseManager $courseManager)
    {
        parent::__construct();
        $this->em = $em;
        $this->courseManager = $courseManager;
    }


    protected function configure()
    {
        $this
            ->setDescription('Command to test a function');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $course = $this->em->find(Course::class, '23ebd733-4a8e-4af0-a57a-a22026af194f');
        $course->setTitle('hi');
        $course->removeChild($this->em->find(Course::class, '23ebd733-4a8e-4af0-a57a-a22026af194f'));

        $this->courseManager->createOrUpdate($course, ['flush' => true]);

    }
}
