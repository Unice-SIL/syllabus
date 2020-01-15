<?php

namespace AppBundle\Action\Ui\CourseTeacher;

use AppBundle\Action\ActionInterface;
use AppBundle\Factory\ImportCourseTeacherFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SearchCourseTeacherJsonAction
 * @package AppBundle\Action\Ui\CourseTeacher
 */
class SearchCourseTeacherJsonAction implements ActionInterface
{
    /**
     * @var ImportCourseTeacherFactory
     */
    private $importCourseTeacherFactory;

    /**
     * SearchCourseTeacherJsonAction constructor.
     * @param ImportCourseTeacherFactory $importCourseTeacherFactory
     */
    public function __construct(
        ImportCourseTeacherFactory $importCourseTeacherFactory
    )
    {
        $this->importCourseTeacherFactory = $importCourseTeacherFactory;
    }

    /**
     * @Route("/courseteacher/search/json", name="search_course_teacher_json")
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function __invoke(Request $request)
    {
        $courseTeachersArray = [];
        $term = $request->query->get('q');
        $source = $request->query->get('source');
        //$source = 'ldap_uns';
        $courseTeachers = $this->importCourseTeacherFactory->getSearchQuery($source)->setTerm($term)->execute();
        foreach ($courseTeachers as $courseTeacher){
            $courseTeachersArray[] = [
                'id' => $courseTeacher->getId(),
                'text' => $courseTeacher->getLastname().' '.$courseTeacher->getFirstname().' ('.$courseTeacher->getEmail().')'
            ];
        }
        return new JsonResponse($courseTeachersArray);
    }
}