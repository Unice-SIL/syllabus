<?php


namespace AppBundle\Manager;


use AppBundle\Entity\Course;
use AppBundle\Helper\ErrorManager;
use AppBundle\Repository\Doctrine\CourseDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

class CourseManager
{
    /**
     * @var CourseDoctrineRepository
     */
    private $repository;
    /**
     * @var ErrorManager
     */
    private $errorManager;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * CourseManager constructor.
     * @param CourseDoctrineRepository $repository
     * @param ErrorManager $errorManager
     */
    public function __construct(CourseDoctrineRepository $repository, ErrorManager $errorManager, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->errorManager = $errorManager;
        $this->em = $em;
    }

    /**
     * @return Course
     */
    public function new()
    {
        return new Course();
    }

    /**
     * @param string $id
     * @return Course|null
     */
    public function find(string $id): ?Course
    {
        return $this->repository->find($id);
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @param $code
     * @return Course|null
     */
    public function findByCode($code): ?Course
    {
        return $this->repository->findOneBy(['code' => $code]);
    }

    /**
     * @param Course $course
     */
    public function create(Course $course): void
    {
        $this->em->persist($course);
        $this->em->flush();
    }

    /**
     * @param Course $course
     */
    public function update(Course $course): void
    {
        $this->em->flush();
    }

    /**
     * @param Course $course
     */
    public function delete(Course $course): void
    {
        $this->em->remove($course);
        $this->em->flush();
    }

    /**
     * @param Course $courseData
     * @param array $options
     * @throws \Exception
     */
    public function createOrUpdate(Course $courseData, array $options = [])
    {

        $options = array_merge([
            'flush' => false,
            'validation_groups' => null
        ], $options);


            if (!$course = $this->repository->find($courseData->getId())) {

                $course = new Course();
                $course->setType($courseData->getType());
                $course->setTitle($courseData->getTitle());
                $course->setParents($courseData->getParents());
                $course->setChildren($courseData->getChildren());
                $course->setCourseInfos($courseData->getCourseInfos());
                $course->setCode($courseData->getCode());
                $course->setSource($courseData->getSource());

                $this->em->persist($course);
            } elseif (!$course->isSynchronized()) {
                throw new \Exception('Ce cours n\'est pas synchronisable.');
            }

            $this->errorManager->throwExceptionIfError($course, null, $options['validation_groups']);

            if (true === $options['flush']) {
                $this->em->flush();
            }


    }
}