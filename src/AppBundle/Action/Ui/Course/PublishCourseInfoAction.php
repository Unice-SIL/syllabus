<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Twig\Environment;

/**
 * Class PublishCourseInfoAction
 * @package AppBundle\Action\Ui\Course
 */
class PublishCourseInfoAction implements ActionInterface
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
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * PublishCourseInfoAction constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param Environment $templating
     * @param ValidatorInterface $validator
     */
    public function __construct(
            FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
            Environment $templating,
            ValidatorInterface $validator
        )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->templating = $templating;
        $this->validator = $validator;
    }

    /**
     * @Route("/course/publish/{id}", name="publish_course_info")
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $id = $request->get('id', null);
        $courseInfo = $this->findCourseInfoByIdQuery->setId($id)->execute();


        $errors = $this->validator->validate($courseInfo);
        dump($courseInfo);
        dump($errors);


        return new Response(
            $this->templating->render(
                'course/publish_course_info.html.twig',
                [
                    'course' => $courseInfo
                ]
            )
        );
    }


}
