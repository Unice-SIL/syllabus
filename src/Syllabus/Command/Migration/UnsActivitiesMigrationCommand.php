<?php

namespace App\Syllabus\Command\Migration;


use App\Syllabus\Entity\Activity;
use App\Syllabus\Entity\ActivityMode;
use App\Syllabus\Entity\ActivityType;
use App\Syllabus\Entity\BakCourseEvaluationCt;
use App\Syllabus\Entity\BakCourseSectionActivity;
use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\CourseSection;
use App\Syllabus\Entity\CourseSectionActivity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class UnsActivitiesMigrationCommand
 * @package AppBundle\Command\DB
 */
class UnsActivitiesMigrationCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:uns-activities-migration';

    protected  static $batchSize = 10;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    const OLD_TYPE_ACTIVITY = 'activity';
    const OLD_TYPE_EVALUATION = 'evaluation';

    const OLD_MODE_IN_CLASS = 'class';
    const OLD_MODE_IN_AUTONOMY = 'autonomy';
    const OLD_MODE_CC = 'cc';
    const OLD_MODE_CT = 'ct';

    const OLD_GROUP_TOGETHER = 'together';
    const OLD_GROUP_COLLECTIVE = 'collective';
    const OLD_GROUP_GROUP = 'groups';
    const OLD_GROUP_INDIVIDUAL = 'individual';

    const MODE_TOGETHER_ID = 'e7b64ee5-58f6-4a89-b2a7-2a4c1a31c9d3';
    const MODE_GROUP_ID = '8b157e10-aa8d-45e4-a9b1-9cf5b3f8250d';
    const MODE_COLLECTIVE_ID = 'c0fb3c20-9092-4a9d-a17b-01b794fe9d3b';
    const MODE_INDIVIDUAL_ID = 'b0e55736-6c5f-44a5-aec2-0b09ae023f63';

    const TYPE_CLASS_ID = '793edce0-fdb9-454d-a846-ab442c314aef';
    const TYPE_AUTONOMY_ID = 'dd1c2778-93d0-4a77-8262-60bcc778a93b';

    /**
     * UnsActivitiesMigrationCommand constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setDescription('Transfer actvities and courses sections activities data in new tables');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Migrate activities data');

        $stmt = $this->em->getConnection()->prepare("SELECT version FROM migration_versions WHERE version='20200127105326'");
        $stmt->execute();
        $result = $stmt->fetchAll();

        if(empty($result))
        {
            $io->error('You have to migrate to version 20200127105326 before');
        }

        $propertyAccessor = PropertyAccess::createPropertyAccessor();


        /*
         * MODES
         */

        $io->text("Creation des modes d'activite");

        $dataModes = [
            [
                'id' => self::MODE_TOGETHER_ID,
                'label' => 'Tous ensemble'
            ],
            [
                'id' => self::MODE_GROUP_ID,
                'label' => 'En groupe'
            ],
            [
                'id' => self::MODE_COLLECTIVE_ID,
                'label' => 'Collectivement'
            ],
            [
                'id' => self::MODE_INDIVIDUAL_ID,
                'label' => 'Individuellement'
            ]
        ];

        $modes = [];

        $io->progressStart(count($dataModes));
        foreach ($dataModes as $data)
        {
            $mode = $this->em->getRepository(ActivityMode::class)->find($data['id']);
            if(!$mode instanceof ActivityMode)
            {
                $mode = new ActivityMode();
            }
            foreach ($data as $attribute => $value)
            {
                $propertyAccessor->setValue($mode, $attribute, $value);
            }
            $this->em->persist($mode);
            $modes[$data['id']] = $mode;
            $io->progressAdvance();
        }
        $this->em->flush();
        unset($dataModes);
        $io->progressFinish();


        /*
         * TYPES
         */

        $io->text("Creation des types d'activite");

        $dataTypes = [
            [
                'id' => self::TYPE_CLASS_ID,
                'label' => 'En présentiel',
                'modes' => [
                    'e7b64ee5-58f6-4a89-b2a7-2a4c1a31c9d3',
                    '8b157e10-aa8d-45e4-a9b1-9cf5b3f8250d'
                ]
            ],
            [
                'id' => self::TYPE_AUTONOMY_ID,
                'label' => 'En autonomie',
                'modes' => [
                    'e7b64ee5-58f6-4a89-b2a7-2a4c1a31c9d3',
                    '8b157e10-aa8d-45e4-a9b1-9cf5b3f8250d'
                ]
            ]
        ];

        $types = [];

        $io->progressStart(count($dataTypes));
        foreach ($dataTypes as $data)
        {
            $type = $this->em->getRepository(ActivityType::class)->find($data['id']);
            if(!$type instanceof ActivityType)
            {
                $type = new ActivityType();
            }
            foreach ($data as $attribute => $value)
            {
                if($attribute === 'modes')
                {
                    $type->setActivityModes(new ArrayCollection());
                    foreach ($value as $id)
                    {
                        if(array_key_exists($id, $modes))
                        {
                            $type->addActivityMode($modes[$id]);
                        }
                    }
                }
                else
                {
                    $propertyAccessor->setValue($type, $attribute, $value);
                }
            }
            $this->em->persist($type);
            $types[$data['id']] = $type;
            $io->progressAdvance();
        }
        $this->em->flush();
        unset($dataTypes);
        $io->progressFinish();


        /*
         * ACTIVITIES
         */

        $io->text("Creation des activites");

        $dataActivities = [
            [
                'id' => '58f9603a-31b8-42fb-912a-0fba3ea87af4',
                'label' => 'Contribution au forum',
                'types' => [
                    self::TYPE_AUTONOMY_ID
                ]
            ],
            [
                'id' => 'bbfde579-6b10-43f5-a99f-4795c33e131c',
                'label' => 'Cours en ligne',
                'types' => [
                    self::TYPE_AUTONOMY_ID
                ]
            ],
            [
                'id' => '43521e2b-be92-4667-bbda-73cef56c9702',
                'label' => 'Cours Magistral',
                'types' => [
                    self::TYPE_CLASS_ID
                ]
            ],
            [
                'id' => '7206cee3-1cd7-48c9-9a0e-f02622f3625e',
                'label' => 'Débat',
                'types' => [
                    self::TYPE_CLASS_ID
                ]
            ],
            [
                'id' => '4307bae1-e872-42f5-8777-22cb3a8e3dcc',
                'label' => 'Démonstration',
                'types' => [
                    self::TYPE_CLASS_ID
                ]
            ],
            [
                'id' => '27037d89-952a-4f08-b688-ba1357532939',
                'label' => 'Discussion / réflexion',
                'types' => [
                    self::TYPE_CLASS_ID
                ]
            ],
            [
                'id' => '3f214ba7-fe94-4928-ae8f-4473d6052c55',
                'label' => 'Étude d\'un document',
                'description' => 'texte, vidéo, cours en ligne, ...',
                'types' => [
                    self::TYPE_CLASS_ID,
                    self::TYPE_AUTONOMY_ID
                ]
            ],
            [
                'id' => '5d1e4f70-652a-4832-94fd-7144445be5f5',
                'label' => 'Étude de cas',
                'types' => [
                    self::TYPE_CLASS_ID,
                    self::TYPE_AUTONOMY_ID
                ]
            ],
            [
                'id' => 'f73ac4d5-6124-4965-aecb-f9cc6eb66f3f',
                'label' => 'Evalué plus tard',
                'types' => [
                    self::TYPE_CLASS_ID,
                    self::TYPE_AUTONOMY_ID
                ]
            ],
            [
                'id' => '99bdc043-436d-4591-8943-37ffbfff00fd',
                'label' => 'Exercice d\'évaluation par les pairs',
                'types' => [
                    self::TYPE_CLASS_ID,
                    self::TYPE_AUTONOMY_ID
                ]
            ],
            [
                'id' => '1e46eb19-e63b-4e3c-b329-06694db99feb',
                'label' => 'Exercices',
                'types' => [
                    self::TYPE_CLASS_ID,
                    self::TYPE_AUTONOMY_ID
                ]
            ],
            [
                'id' => '107c5e86-36d3-4489-a9f1-d2647af1f0de',
                'label' => 'Exercices pratiques',
                'types' => [
                    self::TYPE_CLASS_ID
                ]
            ],
            [
                'id' => '139fc77f-a875-11e9-9eb8-005056953f80',
                'label' => 'Jeu de rôle',
                'types' => [
                    self::TYPE_CLASS_ID
                ]
            ],
            [
                'id' => 'adf24314-c3cb-4d76-8807-44b8c15a97cd',
                'label' => 'Jeu sérieux',
                'types' => [
                    self::TYPE_CLASS_ID,
                    self::TYPE_AUTONOMY_ID
                ]
            ],
            [
                'id' => '76744418-612d-4efd-86ef-4d26b4762b5d',
                'label' => 'Mise en situation',
                'types' => [
                    self::TYPE_CLASS_ID,
                    self::TYPE_AUTONOMY_ID
                ]
            ],
            [
                'id' => '2207091e-0b60-4e32-861c-19039e836591',
                'label' => 'Participation au forum de discussion',
                'types' => [
                    self::TYPE_AUTONOMY_ID
                ]
            ],
            [
                'id' => '1e41231c-9830-44cd-a853-0571be98f656',
                'label' => 'Production artistique',
                'description' => 'installation, sculpture, performance, ..',
                'types' => [
                    self::TYPE_CLASS_ID,
                    self::TYPE_AUTONOMY_ID
                ]
            ],
            [
                'id' => '16e6528d-0081-4d05-aecd-45a259d1299f',
                'label' => 'Production écrite',
                'description' => 'dissertation, compte-rendu, ...',
                'types' => [
                    self::TYPE_CLASS_ID,
                    self::TYPE_AUTONOMY_ID
                ]
            ],
            [
                'id' => '04cac0bb-2866-40db-b4ee-7a795cff9e84',
                'label' => 'Production multimédia',
                'description' => 'vidéo, affiche, poster, blog, wiki, prototype, portfolio, ...',
                'types' => [
                    self::TYPE_CLASS_ID,
                    self::TYPE_AUTONOMY_ID
                ]
            ],
            [
                'id' => '028dfb83-afbb-45e9-80a9-5e91139d1f9e',
                'label' => 'Production orale',
                'description' => 'entretien, argumentaire, exposé, narration, ...',
                'types' => [
                    self::TYPE_CLASS_ID,
                    self::TYPE_AUTONOMY_ID
                ]
            ],
            [
                'id' => '6e8b4481-3c0b-441e-9470-95baa06d4bad',
                'label' => 'Projet',
                'types' => [
                    self::TYPE_CLASS_ID,
                    self::TYPE_AUTONOMY_ID
                ]
            ],
            [
                'id' => '79e07d29-ec8e-4f25-ac22-98be0c159bd6',
                'label' => 'Recherche documentaire',
                'types' => [
                    self::TYPE_CLASS_ID,
                    self::TYPE_AUTONOMY_ID
                ]
            ],
            [
                'id' => '018ae167-bc6b-4c68-b0e2-08a0a6c06459',
                'label' => 'Séance question / réponse',
                'types' => [
                    self::TYPE_CLASS_ID,
                ]
            ],
            [
                'id' => 'ae75a9f9-ccd4-4110-adc4-8485294b198a',
                'label' => 'Test d\'auto-évaluation',
                'types' => [
                    self::TYPE_AUTONOMY_ID,
                ]
            ],
            [
                'id' => '121ec64c-8037-4e74-9b6e-5a06f0668431',
                'label' => 'Test standardisé',
                'description' => 'Moodle, QCM, WIMS, ...',
                'types' => [
                    self::TYPE_AUTONOMY_ID,
                ]
            ],
            [
                'id' => 'd1033f48-47b8-475c-afd3-ae7246efe873',
                'label' => 'Tournoi',
                'description' => 'Moodle, QCM, WIMS, ...',
                'types' => [
                    self::TYPE_CLASS_ID,
                    self::TYPE_AUTONOMY_ID
                ]
            ],
            [
                'id' => '788ec6e4-77b2-4947-939e-46e766d0aaf1',
                'label' => 'Vote interactif',
                'description' => 'Quizlet, Socrative, Mentimeter',
                'types' => [
                    self::TYPE_CLASS_ID
                ]
            ]
        ];

        $activities = [];

        $io->progressStart(count($dataActivities));
        foreach ($dataActivities as $data)
        {
            $activity = $this->em->getRepository(Activity::class)->find($data['id']);
            if(!$activity instanceof Activity)
            {
                $activity = new Activity();
            }
            foreach ($data as $attribute => $value)
            {
                if($attribute === 'types')
                {
                    $activity->setActivityTypes(new ArrayCollection());
                    foreach ($value as $id)
                    {
                        if(array_key_exists($id, $types))
                        {
                            $activity->addActivityType($types[$id]);
                        }
                    }
                }
                else
                {
                    $propertyAccessor->setValue($activity, $attribute, $value);
                }
            }
            $this->em->persist($activity);
            $activities[$data['id']] = $activity;
            $io->progressAdvance();
        }
        $this->em->flush();
        unset($dataActivities);
        $io->progressFinish();



        /*
         * TABLES DE MATCHING
         */

        $typesMatching = [
            self::OLD_MODE_IN_CLASS => self::TYPE_CLASS_ID,
            self::OLD_MODE_IN_AUTONOMY => self::TYPE_AUTONOMY_ID,
            self::OLD_MODE_CC => self::TYPE_AUTONOMY_ID
        ];

        $modesMatching = [
            self::OLD_GROUP_COLLECTIVE => self::MODE_COLLECTIVE_ID,
            self::OLD_GROUP_GROUP => self::MODE_GROUP_ID,
            self::OLD_GROUP_INDIVIDUAL => self::MODE_INDIVIDUAL_ID,
            self::OLD_GROUP_TOGETHER => self::MODE_TOGETHER_ID,
        ];

        $activitiesMatching = [
            // Contribution au forum
            '58f9603a-31b8-42fb-912a-0fba3ea87af4' => '58f9603a-31b8-42fb-912a-0fba3ea87af4',
            // Cours en ligne
            'bbfde579-6b10-43f5-a99f-4795c33e131c' => 'bbfde579-6b10-43f5-a99f-4795c33e131c',
            // Cours Magistral
            '43521e2b-be92-4667-bbda-73cef56c9702' => '43521e2b-be92-4667-bbda-73cef56c9702',
            // Débat
            '7206cee3-1cd7-48c9-9a0e-f02622f3625e' => '7206cee3-1cd7-48c9-9a0e-f02622f3625e',
            'acc3cc23-0299-4b8c-8a80-a796e4a16e97' => '7206cee3-1cd7-48c9-9a0e-f02622f3625e',
            // Démonstration
            '4307bae1-e872-42f5-8777-22cb3a8e3dcc' => '4307bae1-e872-42f5-8777-22cb3a8e3dcc',
            '99b80f05-7997-4c07-96fb-3aa777e4d161' => '4307bae1-e872-42f5-8777-22cb3a8e3dcc',
            // Discussion / réflexion
            '27037d89-952a-4f08-b688-ba1357532939' => '27037d89-952a-4f08-b688-ba1357532939',
            'c097946d-763d-4db3-989c-34a9c4fd7f4b' => '27037d89-952a-4f08-b688-ba1357532939',
            // Étude d'un document
            '3f214ba7-fe94-4928-ae8f-4473d6052c55' => '3f214ba7-fe94-4928-ae8f-4473d6052c55',
            'df068e46-52c5-494f-b280-d31faeca8aeb' => '3f214ba7-fe94-4928-ae8f-4473d6052c55',
            '4aac1d1b-5add-4268-8e72-75459e2e0c42' => '3f214ba7-fe94-4928-ae8f-4473d6052c55',
            '4fa286e2-7207-4132-b488-ce23eb8c8c92' => '3f214ba7-fe94-4928-ae8f-4473d6052c55',
            // Étude de cas
            '5d1e4f70-652a-4832-94fd-7144445be5f5' => '5d1e4f70-652a-4832-94fd-7144445be5f5',
            '7724e181-5af5-444e-ac9e-a7efc1f511a6' => '5d1e4f70-652a-4832-94fd-7144445be5f5',
            'b4be56ca-7209-475b-abfd-ee8e526938aa' => '5d1e4f70-652a-4832-94fd-7144445be5f5',
            'f2b8f9d9-6a38-4e6a-8387-9c291bab278f' => '5d1e4f70-652a-4832-94fd-7144445be5f5',
            // Evalué plus tard
            'f73ac4d5-6124-4965-aecb-f9cc6eb66f3f' => 'f73ac4d5-6124-4965-aecb-f9cc6eb66f3f',
            // Exercice d'évaluation par les pairs
            '99bdc043-436d-4591-8943-37ffbfff00fd' => '99bdc043-436d-4591-8943-37ffbfff00fd',
            'ae2e0f24-a874-11e9-9eb8-005056953f80' => '99bdc043-436d-4591-8943-37ffbfff00fd',
            'c12af46f-1b60-4b2f-8ad9-e8a0f5c32349' => '99bdc043-436d-4591-8943-37ffbfff00fd',
            'fbae3c86-6fa0-47d9-b00f-4263c474ad92' => '99bdc043-436d-4591-8943-37ffbfff00fd',
            // Exercices
            '1e46eb19-e63b-4e3c-b329-06694db99feb' => '1e46eb19-e63b-4e3c-b329-06694db99feb',
            '8ad39a6e-c976-4ca1-967b-f35947a331f7' => '1e46eb19-e63b-4e3c-b329-06694db99feb',
            'c050b1ed-e3c2-49e4-8a10-ee7395daa46a' => '1e46eb19-e63b-4e3c-b329-06694db99feb',
            'c0816966-ace2-4989-a747-3f100a5e5505' => '1e46eb19-e63b-4e3c-b329-06694db99feb',
            // Exercices pratiques
            '107c5e86-36d3-4489-a9f1-d2647af1f0de' => '107c5e86-36d3-4489-a9f1-d2647af1f0de',
            '4879e57e-a876-11e9-9eb8-005056953f80' => '107c5e86-36d3-4489-a9f1-d2647af1f0de',
            // Jeu de rôle
            '139fc77f-a875-11e9-9eb8-005056953f80' => '139fc77f-a875-11e9-9eb8-005056953f80',
            '21a0ad38-cf8a-4777-9dbf-9813f096e711' => '139fc77f-a875-11e9-9eb8-005056953f80',
            // Jeu sérieux
            'adf24314-c3cb-4d76-8807-44b8c15a97cd' => 'adf24314-c3cb-4d76-8807-44b8c15a97cd',
            'afcea54f-a875-11e9-9eb8-005056953f80' => 'adf24314-c3cb-4d76-8807-44b8c15a97cd',
            'dd970866-a875-11e9-9eb8-005056953f80' => 'adf24314-c3cb-4d76-8807-44b8c15a97cd',
            'f9531fa8-a875-11e9-9eb8-005056953f80' => 'adf24314-c3cb-4d76-8807-44b8c15a97cd',
            // Mise en situation
            '76744418-612d-4efd-86ef-4d26b4762b5d' => '76744418-612d-4efd-86ef-4d26b4762b5d',
            '7cdebb9d-a454-426d-bde9-d9b8ebf4775e' => '76744418-612d-4efd-86ef-4d26b4762b5d',
            'a68b1ec8-55c2-4596-940e-bf69206ab396' => '76744418-612d-4efd-86ef-4d26b4762b5d',
            'd9a82413-a874-11e9-9eb8-005056953f80' => '76744418-612d-4efd-86ef-4d26b4762b5d',
            // Participation au forum de discussion
            '2207091e-0b60-4e32-861c-19039e836591' => '2207091e-0b60-4e32-861c-19039e836591',
            // Production artistique
            '1e41231c-9830-44cd-a853-0571be98f656' => '1e41231c-9830-44cd-a853-0571be98f656',
            '42259f31-1b15-4258-b968-22be434afd70' => '1e41231c-9830-44cd-a853-0571be98f656',
            '4f93b808-5056-4b5b-94ac-f2327cc593c8' => '1e41231c-9830-44cd-a853-0571be98f656',
            '6ed1a915-bcd8-4345-a5d1-c1f6b581ec6d' => '1e41231c-9830-44cd-a853-0571be98f656',
            '7eb68a6e-fb73-4c7d-a5c7-93b60237b033' => '1e41231c-9830-44cd-a853-0571be98f656',
            'eac6c77b-33e6-4145-9693-f3911187a8ef' => '1e41231c-9830-44cd-a853-0571be98f656',
            // Production écrite
            '16e6528d-0081-4d05-aecd-45a259d1299f' => '16e6528d-0081-4d05-aecd-45a259d1299f',
            '8d6e286c-91d7-4213-bb43-bed2939d3edc' => '16e6528d-0081-4d05-aecd-45a259d1299f',
            'a45e6c27-82d9-4358-ba86-d305432697b8' => '16e6528d-0081-4d05-aecd-45a259d1299f',
            'e304dea5-430f-4442-ab93-f7edbc938710' => '16e6528d-0081-4d05-aecd-45a259d1299f',
            'f0446243-b684-4eeb-b9d5-38a45e7a09e7' => '16e6528d-0081-4d05-aecd-45a259d1299f',
            'f4bca4a1-2ca1-4119-aee3-6ed57c0748dc' => '16e6528d-0081-4d05-aecd-45a259d1299f',
            // Production multimédia
            '04cac0bb-2866-40db-b4ee-7a795cff9e84' => '04cac0bb-2866-40db-b4ee-7a795cff9e84',
            '15c9e6f7-faf8-4b40-b529-36908499de02' => '04cac0bb-2866-40db-b4ee-7a795cff9e84',
            '62ce8f5b-f4b5-4963-a999-23b6943adcf5' => '04cac0bb-2866-40db-b4ee-7a795cff9e84',
            'ae4032c5-5cd4-4fa4-b4fc-ae17fe160b17' => '04cac0bb-2866-40db-b4ee-7a795cff9e84',
            'cac2dc93-a2ee-4a43-8e48-371e7db75483' => '04cac0bb-2866-40db-b4ee-7a795cff9e84',
            'df581469-17bd-47d4-a452-6b4049ee625d' => '04cac0bb-2866-40db-b4ee-7a795cff9e84',
            // Production orale
            '028dfb83-afbb-45e9-80a9-5e91139d1f9e' => '028dfb83-afbb-45e9-80a9-5e91139d1f9e',
            '186b8e94-ad36-40ab-829d-08f401260e7e' => '028dfb83-afbb-45e9-80a9-5e91139d1f9e',
            '993fecbe-621d-4774-a79a-9a492cb360d7' => '028dfb83-afbb-45e9-80a9-5e91139d1f9e',
            'b17a1b77-9cab-4c74-8075-b06bd0ba44eb' => '028dfb83-afbb-45e9-80a9-5e91139d1f9e',
            '41c08ede-912c-4591-8cde-ea4baa47adec' => '028dfb83-afbb-45e9-80a9-5e91139d1f9e',
            'ce9b11a6-9009-4d2b-98d1-3aa2c1043b30' => '028dfb83-afbb-45e9-80a9-5e91139d1f9e',
            // Projet
            '6e8b4481-3c0b-441e-9470-95baa06d4bad' => '6e8b4481-3c0b-441e-9470-95baa06d4bad',
            '831fc9d9-976b-458e-ab2b-0b3781c24b80' => '6e8b4481-3c0b-441e-9470-95baa06d4bad',
            'e5f2a4db-4dc4-43a7-bae9-f5286ab90672' => '6e8b4481-3c0b-441e-9470-95baa06d4bad',
            'e6648c01-deab-42b7-8605-8ce9fcf24b1f' => '6e8b4481-3c0b-441e-9470-95baa06d4bad',
            // Recherche documentaire
            '79e07d29-ec8e-4f25-ac22-98be0c159bd6' => '79e07d29-ec8e-4f25-ac22-98be0c159bd6',
            '9c9b3ba9-38ed-4658-b66b-28098146b0ad' => '79e07d29-ec8e-4f25-ac22-98be0c159bd6',
            'f0481f47-a874-11e9-9eb8-005056953f80' => '79e07d29-ec8e-4f25-ac22-98be0c159bd6',
            'f2a95e9c-eef9-472d-895b-e3fcca42ea8c' => '79e07d29-ec8e-4f25-ac22-98be0c159bd6',
            // Séance question / réponse
            '018ae167-bc6b-4c68-b0e2-08a0a6c06459' => '018ae167-bc6b-4c68-b0e2-08a0a6c06459',
            'c3491f29-cbb8-4a46-8671-432fecad7e68' => '018ae167-bc6b-4c68-b0e2-08a0a6c06459',
            // Test d'auto-évaluation
            'ae75a9f9-ccd4-4110-adc4-8485294b198a' => 'ae75a9f9-ccd4-4110-adc4-8485294b198a',
            // Test standardisé
            '121ec64c-8037-4e74-9b6e-5a06f0668431' => '121ec64c-8037-4e74-9b6e-5a06f0668431',
            '74030b3f-7548-4ad9-afe9-94f2de43bdb6' => '121ec64c-8037-4e74-9b6e-5a06f0668431',
            // Tournoi
            'd1033f48-47b8-475c-afd3-ae7246efe873' => 'd1033f48-47b8-475c-afd3-ae7246efe873',
            'e2836103-aa4b-459a-916a-e95cda0f65d8' => 'd1033f48-47b8-475c-afd3-ae7246efe873',
            'f13c06bc-aa1e-4153-99fa-7642fdc58cdb' => 'd1033f48-47b8-475c-afd3-ae7246efe873',
            // Vote interactif
            '788ec6e4-77b2-4947-939e-46e766d0aaf1' => '788ec6e4-77b2-4947-939e-46e766d0aaf1',
            'a61599e4-8207-4bc2-ae9f-8fca3a8ea82b' => '788ec6e4-77b2-4947-939e-46e766d0aaf1',
        ];

        /*
         * REPRISE DES ACTIVITES ET EVALUATIONS CC
         */
        $io->text("Reprise des activites et evaluations CC utilisees dans les sections des syllabus");

        /*
        $qb = $this->em->createQueryBuilder();
        $qb->select('cia')
            ->from(BakCourseSectionActivity::class, 'cia')
            ->innerJoin('cia.activity', 'a', Join::WITH, $qb->expr()->eq('a.type', ':type'))
            ->setParameter('type', \AppBundle\Constant\ActivityType::ACTIVITY);

        $oldSectionActivities = $qb->getQuery()->execute();
        */
        $oldSectionActivities = $this->em->getRepository(BakCourseSectionActivity::class)->findAll();

        $io->progressStart(count($oldSectionActivities));
        $i = 0;
        /** @var BakCourseSectionActivity $oldSectionActivity */
        foreach ($oldSectionActivities as $oldSectionActivity)
        {
            $sectionActivity = $this->em->getRepository(CourseSectionActivity::class)->find(
                $oldSectionActivity->getId()
            );
            if ($sectionActivity instanceof CourseSectionActivity) {
                continue;
            }

            $sectionActivity = new CourseSectionActivity();

            $sectionActivity->setId($oldSectionActivity->getId())
                ->setDescription($oldSectionActivity->getDescription())
                ->setPosition($oldSectionActivity->getPosition())
                ->setCourseSection($oldSectionActivity->getCourseSection());

            if (!array_key_exists($oldSectionActivity->getActivity()->getId(), $activitiesMatching)) {
                $io->warning(
                    "L'activite {$oldSectionActivity->getActivity()->getId()} n'est pas referencee pas dans la table de correspondance des activites"
                );
                continue;
            }
            if (!array_key_exists($activitiesMatching[$oldSectionActivity->getActivity()->getId()], $activities)) {
                $io->warning(
                    "L'activite {$activitiesMatching[$oldSectionActivity->getActivity()->getId()]} n'est pas referencee pas dans la table des activites"
                );
                continue;
            }
            $sectionActivity->setActivity(
                $activities[$activitiesMatching[$oldSectionActivity->getActivity()->getId()]]
            );

            if (!array_key_exists($oldSectionActivity->getActivity()->getMode(), $typesMatching)) {
                $io->warning(
                    "Le type {$oldSectionActivity->getActivity()->getMode()} n'est pas referencee pas dans la table de correspondance des types d'activite"
                );
                continue;
            }
            $sectionActivity->setActivityType(
                $types[$typesMatching[$oldSectionActivity->getActivity()->getMode()]]
            );

            /*
             * TRAITEMENTS PARTICULIERS
             */

            // Anciennes activités de type évaluation
            if ($oldSectionActivity->getActivity()->getType() === self::OLD_TYPE_EVALUATION) {
                $sectionActivity
                    ->setEvaluable(true)
                    ->setEvaluationCt(false)
                    ->setEvaluationRate($oldSectionActivity->getEvaluationRate())
                    ->setEvaluationTeacher($oldSectionActivity->isEvaluationTeacher())
                    ->setEvaluationPeer($oldSectionActivity->isEvaluationPeer())
                    ->setActivityMode($modes[self::MODE_INDIVIDUAL_ID]);
            } // Cours Magistral
            elseif ($oldSectionActivity->getActivity()->getId() === '43521e2b-be92-4667-bbda-73cef56c9702')
            {
                $sectionActivity->setActivityMode($modes[self::MODE_TOGETHER_ID]);
            }
            elseif ($oldSectionActivity->getActivity()->getId() === 'bbfde579-6b10-43f5-a99f-4795c33e131c')
            {
                $sectionActivity->setActivityMode($modes[self::MODE_INDIVIDUAL_ID]);
            }
            else
            {
                /*
                 * TRAITEMENTS GENERIQUES
                 */

                if (!array_key_exists($oldSectionActivity->getActivity()->getGrp(), $modesMatching)) {
                    $io->warning(
                        "Le mode {$oldSectionActivity->getActivity()->getGrp()} n'est pas referencee pas dans la table de correspondance des modes d'activite(activité: {$oldSectionActivity->getActivity()->getId()})"
                    );
                    continue;
                }
                $sectionActivity->setActivityMode(
                    $modes[$modesMatching[$oldSectionActivity->getActivity()->getGrp()]]
                );
            }

            $this->em->persist($sectionActivity);
            $this->em->getUnitOfWork()->removeFromIdentityMap($oldSectionActivity);

            if ($i % self::$batchSize === 0) {
                $this->em->flush();
                $this->em->clear(CourseSectionActivity::class);
                gc_collect_cycles();
            }

            $i++;
            $io->progressAdvance();

        }

        $this->em->flush();
        $this->em->clear(CourseSectionActivity::class);
        $this->em->clear(BakCourseSectionActivity::class);
        $io->progressFinish();


        /*
         * REPRISE DES EVALUATIONS CT
         */
        $io->text("Reprise des evaluations CT utilisees dans les syllabus");

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('course_info_id', 'id');

        $query = $this->em->createNativeQuery('SELECT DISTINCT course_info_id FROM bak_course_evaluation_ct', $rsm);
        $courseInfoIds = $query->getResult();

        $io->progressStart(count($courseInfoIds));
        foreach ($courseInfoIds as $courseInfoId)
        {
            $courseInfo = $this->em->getRepository(CourseInfo::class)->find($courseInfoId['id']);

            if(!$courseInfo instanceof CourseInfo)
            {
                $io->warning("Le syllabus {$courseInfoId['id']} n'a pas été retrouvé");
                continue;
            }

            $sectionCt = $this->em->getRepository(CourseSection::class)->findBy([
                'courseInfo' => $courseInfo,
                'title' => 'Évaluations terminales'
            ]);

            if(!$sectionCt instanceof CourseSection)
            {
                $sectionCt = new CourseSection();
                $sectionCt->setId(Uuid::uuid4())
                    ->setTitle('Évaluations terminales')
                    ->setPosition(10)
                    ->setCourseInfo($courseInfo);
            }

            $oldSectionEvaluations = $this->em->getRepository(BakCourseEvaluationCt::class)->findBy(['courseInfo'=>$courseInfo]);

            foreach ($oldSectionEvaluations as $oldSectionEvaluation)
            {
                $sectionActivity = $this->em->getRepository(CourseSectionActivity::class)->find($oldSectionEvaluation->getId());
                if ($sectionActivity instanceof CourseSectionActivity) {
                    continue;
                }

                $sectionActivity = new CourseSectionActivity();

                $sectionActivity->setId($oldSectionEvaluation->getId())
                    ->setDescription($oldSectionEvaluation->getDescription())
                    ->setEvaluable(true)
                    ->setEvaluationCt(true)
                    ->setEvaluationRate($oldSectionEvaluation->getEvaluationRate())
                    ->setActivityType($types[self::TYPE_CLASS_ID])
                    ->setActivityMode($modes[self::MODE_INDIVIDUAL_ID])
                    ->setPosition($oldSectionEvaluation->getPosition())
                    ->setCourseSection($sectionCt);

                if (!array_key_exists($oldSectionEvaluation->getActivity()->getId(), $activitiesMatching)) {
                    $io->warning(
                        "L'activite {$oldSectionEvaluation->getActivity()->getId()} n'est pas referencee pas dans la table de correspondance des activites"
                    );
                    continue;
                }
                if (!array_key_exists($activitiesMatching[$oldSectionEvaluation->getActivity()->getId()], $activities)) {
                    $io->warning(
                        "L'activite {$activitiesMatching[$oldSectionEvaluation->getActivity()->getId()]} n'est pas referencee pas dans la table des activites"
                    );
                    continue;
                }
                $sectionActivity->setActivity(
                    $activities[$activitiesMatching[$oldSectionEvaluation->getActivity()->getId()]]
                );


                $this->em->persist($sectionActivity);
            }

            $this->em->persist($sectionCt);

            $this->em->getUnitOfWork()->removeFromIdentityMap($courseInfo);
            $this->em->flush();

            $this->em->clear(CourseSectionActivity::class);
            $this->em->clear(CourseSection::class);
            $this->em->clear(BakCourseEvaluationCt::class);

            $io->progressAdvance();
        }

        $io->progressFinish();

        /*
        $oldSectionEvaluations = $this->em->getRepository(BakCourseEvaluationCt::class)->findAll();

        $io->progressStart(count($oldSectionActivities));
        $i = 0;

        foreach ($oldSectionEvaluations as $oldSectionEvaluation)
        {
            $sectionActivity = $this->em->getRepository(CourseSectionActivity::class)->find($oldSectionEvaluation->getId());
            if ($sectionActivity instanceof CourseSectionActivity) {
                continue;
            }

            $sectionActivity = new CourseSectionActivity();

            $sectionActivity->setId($oldSectionEvaluation->getId())
                ->setDescription($oldSectionEvaluation->getDescription())
                ->setPosition($oldSectionEvaluation->getPosition())
                ->setCourseSection($oldSectionEvaluation->getCourseSection());
        }
        */
    }

}