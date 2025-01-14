<?php

namespace App\Syllabus\Command\Export;

use App\Syllabus\Export\SyllabusExport;
use App\Syllabus\Helper\MailHelper;
use App\Syllabus\Repository\Doctrine\CourseInfoDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

#[AsCommand(
    name: 'app:export:weekly:csv',
)]
class ExportWeeklyReportCSVCommand extends Command
{
    protected static $defaultName = 'app:export:weekly:csv';

    /**
     * @var string
     */
    private string $mailerTarget;

    /**
     * @var CourseInfoDoctrineRepository
     */
    private CourseInfoDoctrineRepository $courseInfoDoctrineRepository;

    /**
     * @var SyllabusExport
     */
    private SyllabusExport $syllabusExport;

    /**
     * @var MailHelper
     */
    private MailHelper $mailHelper;

    public function __construct(
        string $mailerWeeklyReport,
        CourseInfoDoctrineRepository $courseInfoDoctrineRepository,
        SyllabusExport $syllabusExport,
        MailHelper $mailHelper
    ) {
        parent::__construct();
        $this->mailerTarget = $mailerWeeklyReport;
        $this->courseInfoDoctrineRepository = $courseInfoDoctrineRepository;
        $this->syllabusExport = $syllabusExport;
        $this->mailHelper = $mailHelper;
    }

    protected function configure(): void
    {
        parent::configure();
        $this
            ->setDescription('Weekly report to CSV');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     * @throws TransportExceptionInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    protected function execute(InputInterface $input, OutputInterface $output): mixed
    {
        $title = './tmpReports/Liste_Syllabus_' . date('dmYHis') . '.csv';
        $courseInfos = $this->courseInfoDoctrineRepository->findAllPublishedCurrentYear();
        $this->syllabusExport->generateCSV($title, $courseInfos);
        $this->mailHelper->sendWeeklyCSVReport($this->mailerTarget, $title);
        return self::SUCCESS;
    }
}