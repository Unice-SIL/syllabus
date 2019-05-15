<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Constant\Permission;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Helper\CourseInfoHelper;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use AppBundle\Helper\CoursePermissionHelper;
use AppBundle\Entity\User;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use manuelodelain\Twig\Extension\LinkifyExtension;

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
     * @var CourseInfoHelper
     */
    private $courseInfoHelper;

    /**
     * @var CoursePermissionHelper
     */
    private $coursePermissionHelper;

    /**
     * ViewStudentAction constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param Environment $templating
     * @param SessionInterface $session
     * @param LoggerInterface $logger
     * @param CourseInfoHelper $courseInfoHelper
     * @param CoursePermissionHelper $coursePermissionHelper
     */
    public function __construct(
            FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
            Environment $templating,
            SessionInterface $session,
            LoggerInterface $logger,
            CourseInfoHelper $courseInfoHelper,
            CoursePermissionHelper $coursePermissionHelper
        )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->templating = $templating;
        $this->session = $session;
        $this->logger = $logger;
        $this->courseInfoHelper = $courseInfoHelper;
        $this->coursePermissionHelper = $coursePermissionHelper;

        $templating->addExtension(new LinkifyExtension(array(
            'attr' => array('target' => '_blank')
        )));
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
            $this->session->getFlashBag()->add('danger', "Une erreur est survenue durant le chargement du cours.");
        }

        return new Response(
            $this->templating->render(
                'course/view_student.html.twig',
                [
                    'course' => $courseInfo,
                    'courseInfoHelper' => $this->courseInfoHelper,
                    'coursePermissionHelper' => $this->coursePermissionHelper
                ]
            )
        );
    }
}
