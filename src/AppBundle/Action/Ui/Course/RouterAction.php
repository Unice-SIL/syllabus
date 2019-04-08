<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Constant\Permission;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Helper\CoursePermissionHelper;
use AppBundle\Query\Course\FindCourseInfoByEtbIdAndYearQuery;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use Psr\Log\LoggerInterface;
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
 * Class RouterAction
 * @package AppBundle\Action\Ui\Course
 */
class RouterAction implements ActionInterface
{
    /**
     * @var FindCourseInfoByEtbIdAndYearQuery
     */
    private $findCourseInfoByEtbIdAndYearQuery;

    /**
     * @var CoursePermissionHelper
     */
    private $coursePermissionHelper;

    /**
     * @var Environment
     */
    private $templating;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * RouterAction constructor.
     * @param FindCourseInfoByEtbIdAndYearQuery $findCourseInfoByEtbIdAndYearQuery
     * @param CoursePermissionHelper $coursePermissionHelper
     * @param Environment $templating
     * @param TokenStorageInterface $tokenStorage
     * @param SessionInterface $session
     * @param RouterInterface $router
     * @param LoggerInterface $logger
     */
    public function __construct(
        FindCourseInfoByEtbIdAndYearQuery $findCourseInfoByEtbIdAndYearQuery,
        CoursePermissionHelper $coursePermissionHelper,
        Environment $templating,
        TokenStorageInterface $tokenStorage,
        SessionInterface $session,
        RouterInterface $router,
        LoggerInterface $logger
    )
    {
        $this->findCourseInfoByEtbIdAndYearQuery = $findCourseInfoByEtbIdAndYearQuery;
        $this->coursePermissionHelper = $coursePermissionHelper;
        $this->templating = $templating;
        $this->tokenStorage = $tokenStorage;
        $this->session = $session;
        $this->router = $router;
        $this->logger = $logger;
    }

    /**
     * @Route("/course/router/{etbId}/{year}", name="course_router")
     * @param Request $request
     * @return Response
     */
    public function __invoke($etbId, $year, Request $request)
    {
        $courseInfo = null;
        try {
            try {
                $courseInfo = $this->findCourseInfoByEtbIdAndYearQuery->setEtbId($etbId)->setYear($year)->execute();
                if($this->coursePermissionHelper->hasPermission($courseInfo, $this->tokenStorage->getToken()->getUser(), Permission::WRITE)){
                    return new RedirectResponse($this->router->generate('edit_course', [
                        'id' => $courseInfo->getId()
                    ]));
                }else{
                    return new RedirectResponse($this->router->generate('view_student', [
                        'id' => $courseInfo->getId()
                    ]));
                }

            } catch (CourseInfoNotFoundException $e) {
                // Nothing to do
            }
        }catch (\Exception $e){
            $this->logger->error((string) $e);
            $this->session->getFlashBag()->add('danger', "Une erreur est survenue durant la récupération du cours");
        }

        return new Response($this->templating->render(
            'base.html.twig',
            [
            ]
        ));
    }
}