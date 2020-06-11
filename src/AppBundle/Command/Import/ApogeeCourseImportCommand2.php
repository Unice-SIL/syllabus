<?php


namespace AppBundle\Command\Import;


use AppBundle\Entity\Course;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\Structure;
use AppBundle\Entity\Year;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ApogeeCourseImportCommand2
 * @package AppBundle\Command\Import
 */
class ApogeeCourseImportCommand2 extends Command
{

    protected static $defaultName = 'app:import:apogee:course2';

    /**
     * @var RegistryInterface
     */
    private $doctrine;

    /**
     * @var ObjectManager
     */
    private $em;

    private $apogee;

    /**
     * @var array
     */
    private $apogeeCourseNatureToImport;

    /**
     * ApogeeCourseImportCommand2 constructor.
     * @param RegistryInterface $doctrine
     * @param array $apogeeCourseNatureToImport
     */
    public function __construct(
        RegistryInterface $doctrine,
        array $apogeeCourseNatureToImport
    )
    {
        parent::__construct();
        $this->doctrine = $doctrine;
        $this->apogee = $doctrine->getConnection('apogee');
        $this->em = $doctrine->getManager();
        $this->apogeeCourseNatureToImport = $apogeeCourseNatureToImport;
    }

    /**
     *
     */
    protected function configure()
    {
        parent::configure();
        $this
            ->setDescription('Apogee Course import');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //======================Perf==================
        $start = microtime(true);
        $interval = [];
        //======================End Perf==================

        $yearsToImport = null;
        $elps = $this->getElpsByType($this->apogeeCourseNatureToImport);
        $output->writeln(count($elps).' elps to import');

        //======================Perf==================
        $timeStart = microtime(true);
        //======================End Perf==================

        $loop = 1;
        $loopBreak = 10;
        foreach ($elps as $elp)
        {
            $output->writeln('Import course '.$elp['COD_ELP']);
            $course = $this->getCourseFromElp($elp);
            $elpParents = $this->getElpParents($course->getCode(), $this->apogeeCourseNatureToImport);
            foreach ($elpParents as $elpParent)
            {
                $courseParent = $this->getCourseFromElp($elpParent);
                $courseParent->addChild($course);
            }

            if(is_null($yearsToImport))
            {
                $yearsToImport = $this->getYearsToImport();
            }

            /** @var Year $year */
            foreach ($yearsToImport as $year)
            {
                $elpTeachingModesHours = $this->getElpTeachingModesHours($course->getCode(), $year->getId());
                $elp = array_merge($elp, $elpTeachingModesHours);
                $courseInfo = $this->getCourseInfoFromElp($year, $elp);
                if(!is_null($courseInfo))
                {
                    $course->addCourseInfo($courseInfo);
                }
            }

            $this->em->persist($course);
            if(($loop % $loopBreak) == 0)
            {
                $this->em->flush();
                $this->em->clear();
                $yearsToImport = null;

                //======================Perf==================
                $interval[$loop] = microtime(true) - $timeStart . ' s';
                $timeStart = microtime(true);
                dump($interval);
                //======================End Perf==================
            }

            $loop++;

        }
    }

    /**
     * @param array $types
     * @return array
     */
    private function getElpsByType(array $types = []): array
    {
        $formattedTypes = str_repeat('?,', count($types) - 1) . '?';

       $sql = "SELECT * FROM element_pedagogi elp
WHERE elp.cod_elp NOT IN (
SELECT ere.cod_elp_pere FROM elp_regroupe_elp ere WHERE ere.cod_elp_pere = elp.cod_elp)
AND elp.eta_elp = 'O' AND elp.tem_sus_elp = 'N' AND elp.cod_nel IN ({$formattedTypes})";
        $stmt = $this->apogee->prepare($sql);
        foreach ($types as $k => $type) $stmt->bindValue(($k+1), $type);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * @param $codElp
     * @param array $types
     * @return mixed
     */
    private function getElpParents($codElp, array $types = [])
    {
        $formattedTypes = str_repeat('?,', count($types) - 1) . '?';

        $sql = "SELECT elp.* FROM element_pedagogi elp
INNER JOIN elp_regroupe_elp ere ON (ere.cod_elp_pere = elp.cod_elp)
WHERE ere.cod_elp_fils = :cod_elp AND ere.eta_elp_fils = 'O' AND ere.eta_elp_pere = 'O'
AND ere.tem_sus_elp_fils = 'N' AND ere.tem_sus_elp_pere = 'N' AND elp.eta_elp = 'O' AND elp.tem_sus_elp = 'N'
AND elp.cod_nel IN ({$formattedTypes})";
        $stmt = $this->apogee->prepare($sql);
        $stmt->bindValue(':cod_elp', $codElp);
        foreach ($types as $k => $type) $stmt->bindValue(($k+1), $type);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * @param string $codElp
     * @param string $codAnu
     * @return array
     */
    private function getElpTeachingModesHours(string $codElp, string $codAnu): array
    {
        $sql = "SELECT * FROM elp_chg_typ_heu WHERE cod_elp = :cod_elp AND cod_anu = :cod_anu";
        $stmt = $this->apogee->prepare($sql);
        $stmt->bindValue(':cod_elp', $codElp);
        $stmt->bindValue(':cod_anu', $codAnu);
        $stmt->execute();
        $teachingModesHours = [
            'CM' => null,
            'TD' => null,
            'TP' => null
        ];
        foreach($stmt->fetchAll() as $teachingModeHours)
        {
            $mode = $teachingModeHours['COD_TYP_HEU'];
            if(array_key_exists($mode, $teachingModesHours))
            {
                $teachingModesHours[$mode] = $teachingModeHours['NBR_HEU_ELP'];
            }
        }
        return $teachingModesHours;
    }

    /**
     * @return object[]
     */
    private function getYearsToImport()
    {
        return $this->em->getRepository(Year::class)->findBy(['import' => true]);
    }

    /**
     * @param $elp
     * @return Course|object|null
     */
    private function getCourseFromElp($elp)
    {
        $course = $this->em->getRepository(Course::class)->findOneBy(['code' => $elp['COD_ELP']]);
        if(!$course instanceof Course)
        {
            $course = new Course();
        }
        $course->setCode($elp['COD_ELP'])
            ->setTitle($elp['LIB_ELP'])
            ->setType($elp['COD_NEL']);

        return $course;
    }

    /**
     * @param $year
     * @param $elp
     * @return CourseInfo|null
     */
    private function getCourseInfoFromElp($year, $elp)
    {
        $structure = $this->em->getRepository(Structure::class)->findOneBy(['code' => $elp['COD_CMP']]);
        if(!$structure instanceof Structure) return null;

        /** @var QueryBuilder $qb */
        $qb = $this->em->getRepository(CourseInfo::class)->createQueryBuilder('ci');
        /** @var CourseInfo|null $courseInfo */
        $courseInfo =  $qb->innerJoin('ci.course', 'c')
            ->where($qb->expr()->eq('ci.year', $year))
        ->getQuery()->execute();
        if(!$courseInfo instanceof CourseInfo)
        {
            $courseInfo = new CourseInfo();
        }
        $courseInfo->setYear($year)
            ->setStructure($structure)
            ->setTitle($elp['LIB_ELP'])
            ->setEcts($elp['NBR_CRD_ELP']?? null)
            ->setTeachingCmClass($elp['CM']?? null)
            ->setTeachingTdClass($elp['TD']?? null)
            ->setTeachingTpClass($elp['TP']?? null);

        return $courseInfo;
    }
}