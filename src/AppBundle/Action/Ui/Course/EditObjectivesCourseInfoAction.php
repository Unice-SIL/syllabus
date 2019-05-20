<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Command\Course\EditObjectivesCourseInfoCommand;
use AppBundle\Constant\Permission;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Exception\CoursePermissionDeniedException;
use AppBundle\Form\Course\EditObjectivesCourseInfoType;
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
 * Class EditObjectivesCourseInfoAction
 * @package AppBundle\Action\Ui\Course
 */
class EditObjectivesCourseInfoAction implements ActionInterface
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
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var Environment
     */
    private $templating;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * EditObjectivesCourseInfoAction constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param CoursePermissionHelper $coursePermissionHelper
     * @param TokenStorageInterface $tokenStorage
     * @param FormFactoryInterface $formFactory
     * @param SessionInterface $session
     * @param Environment $templating
     * @param LoggerInterface $logger
     */
    public function __construct(
        FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
        CoursePermissionHelper $coursePermissionHelper,
        TokenStorageInterface $tokenStorage,
        FormFactoryInterface $formFactory,
        SessionInterface $session,
        Environment $templating,
        LoggerInterface $logger
    )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->coursePermissionHelper = $coursePermissionHelper;
        $this->tokenStorage = $tokenStorage;
        $this->formFactory = $formFactory;
        $this->templating = $templating;
        $this->session = $session;
        $this->logger = $logger;
    }

    /**
     * @Route("/course/objectives/edit/{id}", name="edit_objectives_course_info")
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
                        'message' => "Vous ne disposez pas des permissions nécessaires pour éditer ce syllabus."
                    ]
                ]);
            } catch (CourseInfoNotFoundException $e) {
                return new JsonResponse([
                    'alert' => [
                        'type' => 'danger',
                        'message' => sprintf("Le cours « %s » n'existe pas.", $id)
                    ]
                ]);
            }

            $editObjectivesCourseInfoCommand = new EditObjectivesCourseInfoCommand($courseInfo);
            $form = $this->formFactory->create(EditObjectivesCourseInfoType::class, $editObjectivesCourseInfoCommand);
            $form->handleRequest($request);

            return new JsonResponse([
                'content' => $this->templating->render(
                    'course/edit_objectives_course_info_tab.html.twig',
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
                    'message' => "Une erreur est survenue pendant le chargement du formulaire."
                ]
            ]);
        }
    }
}