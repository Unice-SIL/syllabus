<?php


namespace AppBundle\Parser;

use AppBundle\Entity\User;
use AppBundle\Helper\Report\ReportLine;
use AppBundle\Manager\CoursePermissionManager;
use AppBundle\Repository\Doctrine\CourseInfoDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

class CoursePermissionCsvParser extends AbstractCsvParser implements ParserInterface
{
    /**
     * @var CourseInfoDoctrineRepository
     */
    private $courseInfoDoctrineRepository;
    private $code;
    /**
     * @var CoursePermissionManager
     */
    private $coursePermissionManager;

    /**
     * CoursePermissionCsvParser constructor.
     * @param EntityManagerInterface $em
     * @param CourseInfoDoctrineRepository $courseInfoDoctrineRepository
     * @param CoursePermissionManager $coursePermissionManager
     */
    public function __construct(
        EntityManagerInterface $em,
        CourseInfoDoctrineRepository $courseInfoDoctrineRepository,
        CoursePermissionManager $coursePermissionManager
    )
    {
        parent::__construct($em);
        $this->courseInfoDoctrineRepository = $courseInfoDoctrineRepository;
        $this->coursePermissionManager = $coursePermissionManager;
    }

    protected function getNewEntity(): object
    {
        return $this->coursePermissionManager->create();
    }

    protected function getBaseMatching(): array
    {
        return [
            'code',
            'year',
            'user' => ['name'=> 'username', 'type' => 'object', 'entity' => User::class, 'findBy' => 'username'],
            'permission' => ['choices' => ['READ', 'WRITE']],
        ];
    }

    protected function getLineIds(): array
    {
        return ['code', 'year', 'username', 'permission'];
    }

    protected function manageSpecialCase($entity, string $property, string $name, string $type, $data, ReportLine $reportLine): bool
    {
        switch ($name) {
            case 'code':
                $this->code = $data;
                return false;
            case 'year':

                if ($courseInfo = $this->courseInfoDoctrineRepository->findByCodeAndYear($this->code, $data))
                {
                    $entity->setCourseInfo($courseInfo);
                    return false;
                }

                $reportLine->addComment('Le syllabus de code ' . $this->code . ' et d\'année ' . $data . ' n\'exist pas.');
                return false;
        }

        return true;
    }


}