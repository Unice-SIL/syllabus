<?php

namespace App\Syllabus\Command\Duplicate;

use App\Syllabus\Command\Scheduler\AbstractJob;
use App\Syllabus\Entity\Course;
use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\Year;
use App\Syllabus\Manager\CourseInfoManager;
use App\Syllabus\Repository\Doctrine\CourseInfoDoctrineRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use League\Csv\Reader;
use League\Csv\Statement;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DuplicateCourseInfoOnOtherCourseInfo extends AbstractJob
{
    protected static $defaultName = 'app:duplicate:course_info:new_code';

    /**
     * @var string
     */
    protected $filename;

    /**
     * @var CourseInfoDoctrineRepository
     */
    protected $courseInfoDoctrineRepository;

    /**
     * @var CourseInfoManager
     */
    protected $courseInfoManager;

    /**
     * @param EntityManagerInterface $em
     * @param CourseInfoDoctrineRepository $courseInfoDoctrineRepository
     * @param CourseInfoManager $courseInfoManager
     */
    public function __construct(
        EntityManagerInterface $em,
        CourseInfoDoctrineRepository $courseInfoDoctrineRepository,
        CourseInfoManager $courseInfoManager
    ) {
        $this->courseInfoDoctrineRepository = $courseInfoDoctrineRepository;
        $this->courseInfoManager = $courseInfoManager;
        parent::__construct($em);
    }

    protected function configure()
    {
        $this->addOption(
            'filepath',
            'f',
            InputOption::VALUE_REQUIRED,
            'Path to the csv file',
            $this->filename
        );
        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     * @throws Exception
     */
    protected function subExecute(InputInterface $input, OutputInterface $output)
    {
        $output->getFormatter()->setStyle('success', new OutputFormatterStyle('green'));
        $output->getFormatter()->setStyle('warning', new OutputFormatterStyle('yellow'));
        $output->getFormatter()->setStyle('error', new OutputFormatterStyle('red'));

        $filepath = $input->getOption('filepath');

        $csv = Reader::createFromPath($filepath);
        $csv->setHeaderOffset(0)->setDelimiter(';');
        $stmt = Statement::create();
        $records = $stmt->process($csv);

        foreach ($records as $record) {
            $this->em->clear();

            $oldCode = $record['old_code'];
            $oldYear = $record['old_year'];
            $newCode = $record['new_code'];
            $newYear = $record['new_year'];

            $oldCourseInfo = $this->courseInfoDoctrineRepository->findByCodeAndYear($oldCode, $oldYear);
            if (!$oldCourseInfo instanceof CourseInfo) {
                $output->writeln($this->formattedOutput('error', 'Le syllabus ' . $oldCode . ' ' . $oldYear . ' n\'existe pas'));
                continue;
            }

            $newCourse = $this->em->getRepository(Course::class)->findOneByCode($newCode);
            if (!$newCourse instanceof Course) {
                $output->writeln($this->formattedOutput('error', 'L\'UE/ECUE ' . $newCode . ' n\'a pas encore été importé/créé'));
                continue;
            }

            $year = $this->em->getRepository(Year::class)->findOneById($newYear);
            if (!$year instanceof Year) {
                $output->writeln($this->formattedOutput('error', 'L\'année ' . $newYear . ' n\'existe pas'));
                continue;
            }

            $newCourseInfo = $this->courseInfoDoctrineRepository->findByCodeAndYear($newCode, $newYear);
            if ($newCourseInfo instanceof CourseInfo && $newCourseInfo->getModificationDate() instanceof DateTime && $newCourseInfo->getModificationDate() !== $newCourseInfo->getCreationDate()) {
                $output->writeln($this->formattedOutput('warning', 'Le syllabus ' . $newCode . ' ' . $newYear . ' existe déjà et a déjà été modifié'));
                if (empty($newCourseInfo->getPublicationDate())) {
                    $newCourseInfo->setPublicationDate(!empty($oldCourseInfo->getPublicationDate()) ? new DateTime() : null);
                }
                $this->em->flush();
                continue;
            }

            if (!$newCourseInfo instanceof CourseInfo) {
                $newCourseInfo = (new CourseInfo())
                    ->setCourse($newCourse)
                    ->setYear($year)
                    ->setStructure($oldCourseInfo->getStructure())
                    ->setTitle($newCourse->getTitle())
                    ->setPublicationDate(!empty($oldCourseInfo->getPublicationDate()) ? new DateTime() : null);

                $this->em->persist($newCourseInfo);
                $this->em->flush();
            }

            try {
                $report = $this->courseInfoManager->duplicate(
                    "{$oldCode}__UNION__{$oldYear}",
                    "{$newCode}__UNION__{$newYear}",
                    CourseInfoManager::DUPLICATION_CONTEXTE_AUTOMATIC
                );

                $newCourseInfo = $this->courseInfoDoctrineRepository->findByCodeAndYear($newCode, $newYear);
                $newCourseInfo->setModificationDate(null)
                    ->setPublicationDate(!empty($oldCourseInfo->getPublicationDate()) ? new DateTime() : null);

                if (!$report->hasMessages() && !$report->hasLines()) {
                    $this->em->flush();
                    $output->writeln($this->formattedOutput('success', 'Duplication du syllabus ' . $oldCode . ' ' . $oldYear . ' vers ' . $newCode . ' ' . $newYear . ' terminée'));
                    continue;
                }

                foreach ($report->getLines() as $line) {
                    $message = '';
                    foreach ($line->getComments() as $comment) {
                        $message .= $comment . '; ';
                    }
                    $output->writeln($this->formattedOutput('error', $message));
                }
            } catch (Exception $e) {
                $output->writeln($this->formattedOutput('error', $e->getMessage()));
            }
        }
    }

    private function formattedOutput(string $type, string $output): string
    {
        return "<" . $type . ">" . str_pad('[' . strtoupper($type) . ']', 10) . $output . "</" . $type . ">" ;
    }
}