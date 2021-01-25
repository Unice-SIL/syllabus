<?php


namespace App\Syllabus\Command\DB;

use Doctrine\ORM\EntityManagerInterface;
use Proxies\__CG__\App\Syllabus\Entity\CourseInfoField;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CustomDBCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:custom-db';
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }


    protected function configure()
    {
        $this
            ->setDescription('Change somme data in the database. It is especially usefull when using the makefile commands');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Attempted to customize database');

        $courseInfoFileds = $this->em->getRepository(CourseInfoField::class)->findAll();
        $io->progressStart(count($courseInfoFileds));
        foreach ($courseInfoFileds as $field) {
            $field->setManuallyDuplication(true);
            $field->setAutomaticDuplication(true);
            $field->setImport(true);
            $io->progressAdvance();
        }

        $io->progressFinish();

        $this->em->flush();
        $io->success('Customization succeed');

    }
}
