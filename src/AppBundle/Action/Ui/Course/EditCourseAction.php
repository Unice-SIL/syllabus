<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use AppBundle\Helper\CourseInfoHelper;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

/**
 * Class EditCourseAction
 * @package AppBundle\Action\Ui\Course
 */
class EditCourseAction implements ActionInterface
{
    /**
     * @var FindCourseInfoByIdQuery
     */
    private $findCourseInfoByIdQuery;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var Environment
     */
    private $templating;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var CourseInfoHelper
     */
    private $courseInfoHelper;

    /**
     * EditCourseAction constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param FormFactoryInterface $formFactory
     * @param SessionInterface $session
     * @param Environment $templating
     * @param RouterInterface $router
     * @param CourseInfoHelper $courseInfoHelper
     */
    public function __construct(
            FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
            FormFactoryInterface $formFactory,
            SessionInterface $session,
            Environment $templating,
            RouterInterface $router,
            CourseInfoHelper $courseInfoHelper
        )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->formFactory = $formFactory;
        $this->templating = $templating;
        $this->session = $session;
        $this->router = $router;
        $this->courseInfoHelper = $courseInfoHelper;
    }

    /**
     * @Route("/course/edit/{id}", name="edit_course")
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $id = $request->get('id', null);
        try {
            $courseInfo = $this->findCourseInfoByIdQuery->setId($id)->execute();
        }catch (CourseInfoNotFoundException $e){
            $this->session->getFlashBag()->add('danger', sprintf("Course %s does not exist", $id));
            return new RedirectResponse($this->router->generate('homepage'));
        }

        return new Response(
            $this->templating->render(
                'course/edit_course.html.twig',
                [
                    'courseInfo' => $courseInfo,
                    'courseInfoHelper' => $this->courseInfoHelper
                ]
            )
        );
    }
}
