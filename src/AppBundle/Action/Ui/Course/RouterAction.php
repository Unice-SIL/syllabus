<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Constant\Permission;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Helper\CoursePermissionHelper;
use AppBundle\Query\Course\FindCourseInfoByCodeAndYearQuery;
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
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

/**
 * Class RouterAction
 * @package AppBundle\Action\Ui\Course
 */
class RouterAction implements ActionInterface
{
    /**
     * @var FindCourseInfoByCodeAndYearQuery
     */
    private $findCourseInfoByCodeAndYearQuery;

    /**
     * @var CoursePermissionHelper
     */
    private $coursePermissionHelper;

    /**
     * @var Environment
     */
    private $templating;

    /**
     * @var Security
     */
    private $security;

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
     * @param FindCourseInfoByCodeAndYearQuery $findCourseInfoByCodeAndYearQuery
     * @param CoursePermissionHelper $coursePermissionHelper
     * @param Environment $templating
     * @param Security $security
     * @param SessionInterface $session
     * @param RouterInterface $router
     * @param LoggerInterface $logger
     */
    public function __construct(
        FindCourseInfoByCodeAndYearQuery $findCourseInfoByCodeAndYearQuery,
        CoursePermissionHelper $coursePermissionHelper,
        Environment $templating,
        Security $security,
        SessionInterface $session,
        RouterInterface $router,
        LoggerInterface $logger
    )
    {
        $this->findCourseInfoByCodeAndYearQuery = $findCourseInfoByCodeAndYearQuery;
        $this->coursePermissionHelper = $coursePermissionHelper;
        $this->templating = $templating;
        $this->security = $security;
        $this->session = $session;
        $this->router = $router;
        $this->logger = $logger;
    }

    /**
     * @param $code
     * @param $year
     * @param Request $request
     * @return RedirectResponse
     */
    public function __invoke($code, $year, Request $request)
    {
        $courseInfo = null;
        $id = $code;
        try {
            $courseInfo = $this->findCourseInfoByCodeAndYearQuery->setCode($id)->setYear($year)->execute();
            if($this->coursePermissionHelper->hasPermission($courseInfo, $this->security->getUser(), Permission::WRITE)){
                return new RedirectResponse($this->router->generate('edit_course', [
                    'id' => $courseInfo->getId(),
                    'iframe' => $request->get('iframe')
                ]));
            }
            $id = $courseInfo->getId();

        } catch (CourseInfoNotFoundException $e) {
            //

        }catch (\Exception $e){
            $this->logger->error((string) $e);
            $this->session->getFlashBag()->add('danger', "Une erreur est survenue durant le chargement du cours.");
        }

        return new RedirectResponse($this->router->generate('view_student', [
            'id' => $id,
            'iframe' => $request->get('iframe')
        ]));
    }
}
