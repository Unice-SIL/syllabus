<?php

namespace AppBundle\Action\Ui\CourseTeacher;

use AppBundle\Action\ActionInterface;
use AppBundle\Factory\FindCourseTeacherByIdFactory;
use AppBundle\Factory\ImportCourseTeacherFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FindCourseTeacherByIdJsonAction
 * @package AppBundle\Action\Ui\CourseTeacher
 */
class FindCourseTeacherByIdJsonAction implements ActionInterface
{
    /**
     * @var ImportCourseTeacherFactory
     */
    private $importCourseTeacherFactory;

    /**
     * FindCourseTeacherByIdJsonAction constructor.
     * @param ImportCourseTeacherFactory $importCourseTeacherFactory
     */
    public function __construct(
        ImportCourseTeacherFactory $importCourseTeacherFactory
    )
    {
        $this->importCourseTeacherFactory = $importCourseTeacherFactory;
    }

    /**
     * @Route("/courseteacher/find/json", name="find_course_teacher_json")
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        $courseTeacherArray = null;
        $id = $request->query->get('id');
        $source = $request->query->get('source');
        $courseTeacher = $this->importCourseTeacherFactory->getFindByIdQuery($source)->setId($id)->execute();
        if(!is_null($courseTeacher)){
            $courseTeacherArray = [
                'id' => $courseTeacher->getId(),
                'completeName' => trim($courseTeacher->getLastname()." ".$courseTeacher->getFirstname()),
                'firstname' => $courseTeacher->getFirstname(),
                'lastname' => $courseTeacher->getLastname(),
                'email' => $courseTeacher->getEmail()
            ];
        }
        return new JsonResponse($courseTeacherArray);
    }
}