<?php


namespace App\Syllabus\Command\Duplicate;

use App\Syllabus\Command\Scheduler\AbstractJob;
use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\Year;
use App\Syllabus\Helper\Report\ReportingHelper;
use App\Syllabus\Helper\Report\ReportLine;
use App\Syllabus\Manager\CourseInfoManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

#[AsCommand(
    name: 'app:duplicate:course-info:next-year',
)]
class DuplicateCourseInfoOnNextYearCommand extends AbstractJob
{
    /**
     * @var CourseInfoManager
     */
    private CourseInfoManager $courseInfoManager;

    /**
     * DuplicateCourseInfoOnNextYearCommand constructor.
     * @param EntityManagerInterface $em
     * @param CourseInfoManager $courseInfoManager
     */
    public function __construct(
        EntityManagerInterface $em,
        CourseInfoManager $courseInfoManager
    )
    {
        parent::__construct($em);
        $this->courseInfoManager = $courseInfoManager;
    }

    protected function configure(): void
    {
        parent::configure();
        $this
            ->setDescription('Duplicate course info on next year');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     */
    protected function subExecute(InputInterface $input, OutputInterface $output): mixed
    {
        //======================Perf==================
        $start = microtime(true);
        $interval = [];
        $loopBreak = 5;
        //======================End Perf==================

        $report = ReportingHelper::createReport();

        $currentYear = $this->em->getRepository(Year::class)->findOneBy(['current' => true]);

        $currentYearId = null;
        if($currentYear instanceof Year)
        {
            $currentYearId = $currentYear->getId();
        }

        $helper = $this->getHelper('question');
        $question = new Question('Enter the year to duplicate'.(!is_null($currentYearId)? " ({$currentYearId})": '').': ', $currentYearId);
        $yearId = $helper->ask($input, $output, $question);

        $year = $this->getYear($yearId);

        if(!$year instanceof Year)
        {
            $output->writeln("<error>Year {$yearId} not found</error>");
            return null;
        }

        $nextYearId = ((int)$yearId)+1;
        $nextYear = $this->getYear($nextYearId);

        if(!$nextYear instanceof Year)
        {
            $question = new ConfirmationQuestion('The next year ('.$nextYearId.') does not exist, do you want create it (n/y) ? ', false);
            if(!$helper->ask($input, $output, $question))
            {
                return null;
            }
            $nextYear = new Year();
            $nextYear->setId($nextYearId)
                ->setLabel($nextYearId.' - '.($nextYearId+1));
            $this->em->persist($nextYear);
            $this->em->flush();
        }

        /** @var CourseInfo[] $coursesInfo */
        $qb = $this->em->getRepository(CourseInfo::class)->createQueryBuilder('ci');
        $coursesInfo = $qb
            ->select('ci.id')
            ->where($qb->expr()->eq('ci.year', ':year'))
            ->andWhere($qb->expr()->orX(
                $qb->expr()->isNotNull('ci.publicationDate'),
                $qb->expr()->isNotNull('ci.summary'),
                $qb->expr()->neq('ci.modificationDate', 'ci.creationDate')
            ))
            ->setParameter('year', $year)
            ->getQuery()
            ->getArrayResult();
        $output->writeln("<info>". count($coursesInfo) ." courses info to duplicate</info>");
        /*
        $coursesInfo = $this->em->getRepository(CourseInfo::class)->findBy([
            'year' => $year,
            'duplicateNextYear' => true
        ]);
        */

        $loop = 1;
        foreach ($coursesInfo as $courseInfo)
        {
            //======================Perf==================
            if ($loop % $loopBreak === 1) {
                $timeStart = microtime(true);
                $memStart = memory_get_usage();
            }
            //======================End Perf==================

            $courseInfo = $this->em->getRepository(CourseInfo::class)->find($courseInfo['id']);

            $nextCourseInfo = $this->em->getRepository(CourseInfo::class)->findOneBy([
                'course' => $courseInfo->getCourse(),
                'year' => $nextYear
            ]);

            if(!$nextCourseInfo instanceof CourseInfo)
            {
                $output->writeln("<info>Create course info " . $courseInfo->getCourse()->getCode() . " for year " . $nextYear . "</info>");
                $nextCourseInfo = new CourseInfo();
                $nextCourseInfo->setCourse($courseInfo->getCourse())
                    ->setYear($nextYear)
                    ->setStructure($courseInfo->getStructure())
                    ->setTitle($courseInfo->getTitle())
                    ->setPublicationDate(!empty($courseInfo->getPublicationDate())? new \DateTime() : null);


                $this->em->persist($nextCourseInfo);
                $this->em->flush();

                $code = $courseInfo->getCourse()->getCode();

                try {
                    $this->courseInfoManager->duplicate(
                        "{$code}__UNION__{$yearId}",
                        "{$code}__UNION__{$nextYearId}",
                        CourseInfoManager::DUPLICATION_CONTEXTE_MANUALLY,
                        $report
                    );

                } catch (\Exception $e) {

                    $this->em->remove($nextCourseInfo);
                    $line = new ReportLine($code . '_' . $nextYearId);
                    $line->addComment($e);
                    $report->addLine($line);

                }

            }
            else
            {
                $output->writeln("<error>Syllabus already exist for course {$nextYearId} and code {$courseInfo->getCourse()->getCode()}</error>");
            }

            if ($loop % $loopBreak === 0) {
                $progress = round(($loop / count($coursesInfo)) * 100);
                $this->progress($progress);
                $this->memoryUsed(memory_get_usage(), true);
                $this->em->flush();
                $this->em->clear();

                $nextYear = $this->getYear($nextYearId);

                //======================Perf==================

                $interval[$loop]['time'] = microtime(true) - $timeStart . ' s';
                $interval[$loop]['memory'] = round((memory_get_usage() - $memStart)/1048576, 2) . ' MB';
                $interval[$loop]['progress'] = $progress . '%';
                dump($interval[$loop]);
                //======================End Perf==================
            }

            $loop++;
        }

        $this->em->flush();
        //======================Perf==================
        dump( $interval, microtime(true) - $start . ' s');
        //======================End Perf==================

        dump($report);

    }

    /**
     * @param $yearId
     * @return object|null
     */
    private function getYear($yearId): ?object
    {
        return $this->em->getRepository(Year::class)->find($yearId);
    }
}
