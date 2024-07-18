<?php


namespace App\Syllabus\Command\DB;

use App\Syllabus\Entity\CourseInfoField;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:custom:db',
)]
class CustomDBCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }


    protected function configure(): void
    {
        $this
            ->setDescription('Change somme data in the database. It is especially usefull when using the makefile commands');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
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

        return self::SUCCESS;
    }
}
