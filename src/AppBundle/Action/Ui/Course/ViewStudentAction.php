<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Class ViewStudentAction
 * @package AppBundle\Action\Ui\Course
 */
class ViewStudentAction implements ActionInterface
{
    /**
     * @var FindCourseInfoByIdQuery
     */
    private $findCourseInfoByIdQuery;

    /**
     * @var Environment
     */
    private $templating;

    /**
     * StudentViewAction constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param Environment $templating
     */
    public function __construct(
            FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
            Environment $templating
        )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->templating = $templating;
    }

    /**
     * @Route("/course/view/student/{id}", name="view_student")
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $id = $request->get('id', null);
        $courseInfo = $this->findCourseInfoByIdQuery->setId($id)->execute();

        return new Response(
            $this->templating->render(
                'course/view_student.html.twig',
                [
                    'course' => $courseInfo
                ]
            )
        );
    }
}
