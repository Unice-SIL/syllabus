<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Constant\Permission;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use AppBundle\Helper\CoursePermissionHelper;
use AppBundle\Entity\User;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
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
     * @var Session
     */
    private $session;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var CoursePermissionHelper
     */
    private $coursePermissionHelper;

    /**
     * ViewStudentAction constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param Environment $templating
     * @param SessionInterface $session
     * @param TokenStorageInterface $tokenStorage
     * @param LoggerInterface $logger
     * @param CoursePermissionHelper $coursePermissionHelper
     */
    public function __construct(
            FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
            Environment $templating,
            SessionInterface $session,
            LoggerInterface $logger,
            TokenStorageInterface $tokenStorage,
            CoursePermissionHelper $coursePermissionHelper
        )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->templating = $templating;
        $this->session = $session;
        $this->logger = $logger;
        $this->tokenStorage = $tokenStorage;
        $this->coursePermissionHelper = $coursePermissionHelper;
    }

    /**
     * @Route("/course/view/student/{id}", name="view_student")
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $courseInfo = null;
        try {
            $id = $request->get('id', null);
            try {
                $courseInfo = $this->findCourseInfoByIdQuery->setId($id)->execute();
            } catch (CourseInfoNotFoundException $e) {
                // Nothing to do
            }
        }catch (\Exception $e){
            $this->logger->error((string) $e);
            $this->session->getFlashBag()->add('danger', "Une erreur est survenue durant la récupération du cours");
        }

        $user = $this->tokenStorage->getToken()->getUser();

        $permission = $this->coursePermissionHelper->hasPermission($courseInfo, $user, Permission::WRITE);

        return new Response(
            $this->templating->render(
                'course/view_student.html.twig',
                [
                    'course' => $courseInfo,
                    'permission' => $permission
                ]
            )
        );
    }
}
