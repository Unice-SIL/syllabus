<?php


namespace App\Syllabus\Controller;


use App\Syllabus\Entity\Language;
use App\Syllabus\Factory\ImportCourseTeacherFactory;
use App\Syllabus\Manager\LanguageManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Select2Controller extends AbstractController
{
    /**
     * @Route("/teachers/select2/list", name="teachers_select2_list")
     *
     * @param Request $request
     * @param ImportCourseTeacherFactory $factory
     * @return JsonResponse
     * @throws \Exception
     */
    public function listUsersFromExternalRepositoryAction(Request $request, ImportCourseTeacherFactory $factory)
    {
        $courseTeachersArray = [];
        $term = $request->query->get('q');
        $source = $request->query->get('source');
        //$source = 'ldap_uns';
        $courseTeachers = $factory->getSearchQuery($source)->setTerm($term)->execute();
        foreach ($courseTeachers as $courseTeacher){
            $courseTeachersArray[] = [
                'id' => $courseTeacher->getId(),
                'text' => $courseTeacher->getLastname().' '.$courseTeacher->getFirstname().' ('.$courseTeacher->getEmail().')'
            ];
        }
        return new JsonResponse($courseTeachersArray);
    }

}