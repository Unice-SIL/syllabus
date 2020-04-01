<?php


namespace AppBundle\Import\Matching;

use AppBundle\Constant\Permission;
use AppBundle\Entity\User;
use AppBundle\Helper\Report\Report;
use AppBundle\Helper\Report\ReportLine;
use AppBundle\Manager\CoursePermissionManager;
use AppBundle\Repository\Doctrine\CourseInfoDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

class CoursePermissionCsvMatching extends AbstractMatching implements MatchingInterface
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
     * @param CourseInfoDoctrineRepository $courseInfoDoctrineRepository
     * @param CoursePermissionManager $coursePermissionManager
     */
    public function __construct(
        CourseInfoDoctrineRepository $courseInfoDoctrineRepository,
        CoursePermissionManager $coursePermissionManager
    )
    {
        $this->courseInfoDoctrineRepository = $courseInfoDoctrineRepository;
        $this->coursePermissionManager = $coursePermissionManager;
    }

    public function getNewEntity(): object
    {
        return $this->coursePermissionManager->new();
    }

    public function getBaseMatching(): array
    {
        return [
            'code' => ['required' => true, 'description' => "Code du cours du syllabus"],
            'year' => ['required' => true, 'description' => "Année du syllabus"],
            'user' => ['name'=> 'username', 'required' => true, 'type' => 'object', 'entity' => User::class, 'findBy' => 'username', 'description' => "Login de l'utilisateur"],
            'permission' => ['choices' => Permission::PERMISSIONS, 'required' => true, 'description' => "Niveau de permission accordé"],
        ];
    }

    public function getLineIds(): array
    {
        return ['code', 'year', 'username', 'permission'];
    }

    public function manageSpecialCase($entity, string $property, string $name, string $type, $data, ReportLine $reportLine, Report $report): bool
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