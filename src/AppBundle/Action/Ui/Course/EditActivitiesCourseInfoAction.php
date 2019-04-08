<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Command\Course\EditActivitiesCourseInfoCommand;
use AppBundle\Constant\Permission;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Exception\CoursePermissionDeniedException;
use AppBundle\Form\Course\EditActivitiesCourseInfoType;
use AppBundle\Helper\CoursePermissionHelper;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Twig\Environment;

/**
 * Class EditActivitiesCourseInfoTestAction
 * @package AppBundle\Action\Ui\Test
 */
class EditActivitiesCourseInfoAction implements ActionInterface
{
    /**
     * @var FindCourseInfoByIdQuery
     */
    private $findCourseInfoByIdQuery;

    /**
     * @var CoursePermissionHelper
     */
    private $coursePermissionHelper;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var Environment
     */
    private $templating;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * EditActivitiesCourseInfoAction constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param CoursePermissionHelper $coursePermissionHelper
     * @param FormFactoryInterface $formFactory
     * @param SessionInterface $session
     * @param Environment $templating
     * @param LoggerInterface $logger
     */
    public function __construct(
        FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
        CoursePermissionHelper $coursePermissionHelper,
        FormFactoryInterface $formFactory,
        TokenStorageInterface $tokenStorage,
        SessionInterface $session,
        Environment $templating,
        LoggerInterface $logger
    )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->coursePermissionHelper = $coursePermissionHelper;
        $this->formFactory = $formFactory;
        $this->tokenStorage = $tokenStorage;
        $this->templating = $templating;
        $this->session = $session;
        $this->logger = $logger;
    }

    /**
     * @Route("/course/activities/edit/{id}", name="edit_activities_course_info")
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        try {
            $id = $request->get('id', null);
            try {
                $courseInfo = $this->findCourseInfoByIdQuery->setId($id)->execute();
                if(!$this->coursePermissionHelper->hasPermission($courseInfo, $this->tokenStorage->getToken()->getUser(),Permission::WRITE)){
                    throw new CoursePermissionDeniedException();
                }
            }catch (CoursePermissionDeniedException $e){
                return new JsonResponse([
                    'alert' => [
                        'type' => 'danger',
                        'message' => sprintf("Vous n'avez pas les permissions nécessaires pour éditer ce cours")
                    ]
                ]);
            } catch (CourseInfoNotFoundException $e) {
                return new JsonResponse([
                    'alert' => [
                        'type' => 'danger',
                        'message' => sprintf("Le cours %s n'existe pas", $id)
                    ]
                ]);
            }
            $editActivitiesCourseInfoCommand = new EditActivitiesCourseInfoCommand($courseInfo);
            $form = $this->formFactory->create(EditActivitiesCourseInfoType::class, $editActivitiesCourseInfoCommand);
            $form->handleRequest($request);

            return new JsonResponse([
                'content' => $this->templating->render(
                    'course/edit_activities_course_info_tab.html.twig',
                    [
                        'courseInfo' => $courseInfo,
                        'form' => $form->createView()
                    ]
                )
            ]);
        }catch (\Exception $e){
            $this->logger->error((string)$e);
            return new JsonResponse([
                'alert' => [
                    'type' => 'danger',
                    'message' => "Une erreur est survenue pendant le chargement du formulaire"
                ]
            ]);
        }
    }
}