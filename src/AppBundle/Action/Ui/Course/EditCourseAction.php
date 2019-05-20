<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Constant\Permission;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Exception\CoursePermissionDeniedException;
use AppBundle\Helper\CoursePermissionHelper;
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
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
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
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var CourseInfoHelper
     */
    private $courseInfoHelper;

    /**
     * @var CoursePermissionHelper
     */
    private $coursePermissionHelper;

    /**
     * EditCourseAction constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param FormFactoryInterface $formFactory
     * @param SessionInterface $session
     * @param Environment $templating
     * @param RouterInterface $router
     * @param TokenStorageInterface $tokenStorage
     * @param CourseInfoHelper $courseInfoHelper
     * @param CoursePermissionHelper $coursePermissionHelper
     */
    public function __construct(
            FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
            FormFactoryInterface $formFactory,
            SessionInterface $session,
            Environment $templating,
            RouterInterface $router,
            TokenStorageInterface $tokenStorage,
            CourseInfoHelper $courseInfoHelper,
            CoursePermissionHelper $coursePermissionHelper
        )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->formFactory = $formFactory;
        $this->templating = $templating;
        $this->session = $session;
        $this->router = $router;
        $this->tokenStorage = $tokenStorage;
        $this->courseInfoHelper = $courseInfoHelper;
        $this->coursePermissionHelper = $coursePermissionHelper;
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
            if(!$this->coursePermissionHelper->hasPermission($courseInfo, $this->tokenStorage->getToken()->getUser(),Permission::WRITE)){
                throw new CoursePermissionDeniedException();
            }
        }catch (CourseInfoNotFoundException $e){
            $this->session->getFlashBag()->add('danger', sprintf("Le syllabus demandé n'existe pas."));
            return new RedirectResponse($this->router->generate('homepage'));
        }catch (CoursePermissionDeniedException $e){
            $this->session->getFlashBag()->add('danger', sprintf("Vous ne disposez pas des permissions nécessaires pour éditer le syllabus demandé."));
            return new RedirectResponse($this->router->generate('view_student', [
                'id' => $courseInfo->getId()
            ]));
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
