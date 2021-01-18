<?php


namespace App\Syllabus\Command\Migration;


use App\Syllabus\Constant\TeachingMode;
use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\Teaching;
use App\Syllabus\Manager\TeachingManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class OtherTeachingMigrationCommand extends Command
{
    protected static $defaultName = 'app:other-teaching-migration';
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var ValidatorInterface
     */
    private $validator;
    /**
     * @var TeachingManager
     */
    private $teachingManager;

    /**
     * OtherTeachingMigrationCommand constructor.
     * @param EntityManagerInterface $em
     * @param ValidatorInterface $validator
     * @param TeachingManager $teachingManager
     */
    public function __construct(EntityManagerInterface $em, ValidatorInterface $validator, TeachingManager $teachingManager)
    {
        parent::__construct();
        $this->em = $em;
        $this->validator = $validator;
        $this->teachingManager = $teachingManager;
    }


    protected function configure()
    {
        $this
            ->setDescription('Transfer otherTeaching from courseInfo data in a new table');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Attempted transfer other teaching data');

        $courseInfos = $this->em->getRepository(CourseInfo::class)->findAll();



        $io->progressStart(count($courseInfos));

        /** @var CourseInfo $courseInfo */
        foreach ($courseInfos as $courseInfo) {
            $errors = [];

            switch ($courseInfo->getTeachingMode()) {
                case TeachingMode::IN_CLASS:

                    $teaching = $this->teachingManager->new(
                        $courseInfo->getTeachingOtherTypeClass(),
                        $courseInfo->getTeachingOtherClass(),
                        $courseInfo->getTeachingMode()
                    );

                    $errors = $this->validator->validate($teaching);

                    if (count($errors) <= 0) {

                        /** @var Teaching|false $oldTeaching */
                        $oldTeaching = $courseInfo->getTeachings()->filter(function ($teaching) use ($courseInfo) {
                            return $teaching->getType() === $courseInfo->getTeachingOtherTypeClass()
                                and  $teaching->getMode() === $courseInfo->getTeachingMode();
                        })->first();

                        if ($oldTeaching instanceof Teaching) {
                            $oldTeaching->setHourlyVolume($teaching->getHourlyVolume());
                        } else {
                            $courseInfo->addTeaching($teaching);
                        }

                    }

                    $errors = [$errors];
                    break;

                case TeachingMode::DIST:

                    $teaching = $this->teachingManager->new(
                        $courseInfo->getTeachingOtherTypeDist(),
                        $courseInfo->getTeachingOtherDist(),
                        $courseInfo->getTeachingMode()
                    );

                    $errors = $this->validator->validate($teaching);

                    if (count($errors) <= 0) {
                        /** @var Teaching|false $oldTeaching */
                        $oldTeaching = $courseInfo->getTeachings()->filter(function ($teaching) use ($courseInfo) {
                            return $teaching->getType() === $courseInfo->getTeachingOtherTypeDist()
                                and  $teaching->getMode() === $courseInfo->getTeachingMode();
                        })->first();

                        if ($oldTeaching instanceof Teaching) {
                            $oldTeaching->setHourlyVolume($teaching->getHourlyVolume());
                        } else {
                            $courseInfo->addTeaching($teaching);
                        }
                    }

                    $errors = [$errors];

                    break;

                case TeachingMode::HYBRID:

                    $teachingClass = $this->teachingManager->new(
                        $courseInfo->getTeachingOtherTypeHybridClass(),
                        $courseInfo->getTeachingOtherHybridClass(),
                        TeachingMode::IN_CLASS
                    );
                    $teachingDist = $this->teachingManager->new(
                        $courseInfo->getTeachingOtherTypeHybridDistant(),
                        $courseInfo->getTeachingOtherHybridDist(),
                        TeachingMode::DIST
                    );

                    $errorsClass = $this->validator->validate($teachingClass);

                    if (count($errorsClass) <= 0) {
                        /** @var Teaching|false $oldTeaching */
                        $oldTeaching = $courseInfo->getTeachings()->filter(function ($teaching) use ($courseInfo) {
                            return $teaching->getType() === $courseInfo->getTeachingOtherTypeHybridClass()
                                and  $teaching->getMode() === TeachingMode::IN_CLASS;
                        })->first();

                        if ($oldTeaching instanceof Teaching) {
                            $oldTeaching->setHourlyVolume($teachingClass->getHourlyVolume());
                        } else {
                            $courseInfo->addTeaching($teachingClass);
                        }
                    }

                    $errorsDist = $this->validator->validate($teachingDist);

                    if (count($errorsDist) <= 0) {
                        /** @var Teaching|false $oldTeaching */
                        $oldTeaching = $courseInfo->getTeachings()->filter(function ($teaching) use ($courseInfo) {
                            return $teaching->getType() === $courseInfo->getTeachingOtherTypeHybridDistant()
                                and  $teaching->getMode() === TeachingMode::DIST;
                        })->first();

                        if ($oldTeaching instanceof Teaching) {
                            $oldTeaching->setHourlyVolume($teachingDist->getHourlyVolume());
                        } else {
                            $courseInfo->addTeaching($teachingDist);
                        }
                    }

                    $errors = [$errorsClass, $errorsDist];

                    break;
            }

            foreach ($errors as $error) {

                if (count($error) > 0) {
                    $io->newLine();
                    $io->note('CourseInfo (Id - mode) => ' . $courseInfo->getId() . ' - ' . $courseInfo->getTeachingMode() . ': ' . "\n" . $error);
                }
            }

            $io->progressAdvance();
        }

        $io->progressFinish();

        $this->em->flush();
        $io->success('Transfer succeed');

    }
}