<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Command\Course\EditActivitiesCourseInfoCommand;
use AppBundle\Constant\Permission;
use AppBundle\Exception\CoursePermissionDeniedException;
use AppBundle\Helper\CourseInfoHelper;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Form\Course\EditActivitiesCourseInfoType;
use AppBundle\Helper\CoursePermissionHelper;
use AppBundle\Query\Course\EditActivitiesCourseInfoQuery;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Twig\Environment;

/**
 * Class SaveActivitiesCourseInfoAction
 * @package AppBundle\Action\Ui\Course
 */
class SaveActivitiesCourseInfoAction implements ActionInterface
{

    /**
     * @var FindCourseInfoByIdQuery
     */
    private $findCourseInfoByIdQuery;

    /**
     * @var EditActivitiesCourseInfoQuery
     */
    private $editActivitiesCourseInfoQuery;

    /**
     * @var CourseInfoHelper
     */
    private $courseInfoHelper;

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
    private  $templating;

    /**
     * @var LoggerInterface
     */
    private $logger;


    /**
     * SaveActivitiesCourseInfoAction constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param EditActivitiesCourseInfoQuery $editActivitiesCourseInfoQuery
     * @param CoursePermissionHelper $coursePermissionHelper
     * @param TokenStorageInterface $tokenStorage
     * @param FormFactoryInterface $formFactory
     * @param Environment $templating
     * @param LoggerInterface $logger
     * @param CourseInfoHelper $courseInfoHelper
     */
    public function __construct(
        FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
        EditActivitiesCourseInfoQuery $editActivitiesCourseInfoQuery,
        CourseInfoHelper $courseInfoHelper,
        CoursePermissionHelper $coursePermissionHelper,
        TokenStorageInterface $tokenStorage,
        FormFactoryInterface $formFactory,
        Environment $templating,
        LoggerInterface $logger
    )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->editActivitiesCourseInfoQuery = $editActivitiesCourseInfoQuery;
        $this->courseInfoHelper = $courseInfoHelper;
        $this->coursePermissionHelper = $coursePermissionHelper;
        $this->tokenStorage = $tokenStorage;
        $this->formFactory = $formFactory;
        $this->logger = $logger;
        $this->templating = $templating;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Route("/course/activities/save/{id}", name="save_activities_course_info")
     */
    public function __invoke(Request $request)
    {
        $messages = [];
        $renders = [];
        try{
            $id = $request->get('id', null);
            // Find course info by id
            try{
                $courseInfo = $this->findCourseInfoByIdQuery->setId($id)->execute();
                if(!$this->coursePermissionHelper->hasPermission($courseInfo, $this->tokenStorage->getToken()->getUser(),Permission::WRITE)){
                    throw new CoursePermissionDeniedException();
                }
                // Init command
                $editActivitiesCourseInfoCommand = new EditActivitiesCourseInfoCommand($courseInfo);
                // Keep original command before modifications
                $originalEditActivitiesCourseInfoCommand = clone $editActivitiesCourseInfoCommand;
                //
                $form = $this->formFactory->create(EditActivitiesCourseInfoType::class, $editActivitiesCourseInfoCommand);
                $form->handleRequest($request);
                if($form->isSubmitted()){
                    $editActivitiesCourseInfoCommand = $form->getData();

                    // Check if form is valid
                    if(!$form->isValid()){
                        $messages[] = [
                            'type' => "warning",
                            'message' => "Attention, pour pouvoir publier le cours vous devez renseigner tous les champs obligatoires."
                        ];
                    }else{
                        $editActivitiesCourseInfoCommand->setTemActivitiesTabValid(true);
                    }

                    // Check if there have been any changes
                    if($editActivitiesCourseInfoCommand != $originalEditActivitiesCourseInfoCommand) {
                        // Save changes
                        $this->editActivitiesCourseInfoQuery->setEditActivitiesCourseInfoCommand($editActivitiesCourseInfoCommand)->execute();

                        // Return message success
                        $messages[] = [
                            'type' => "success",
                            'message' => "Modifications enregistrées avec succès."
                        ];
                    }else{
                        $messages[] = [
                            'type' => "info",
                            'message' => "Aucun changement à enregistrer."
                        ];
                    }

                    // Get render to reload form
                    $render[] = [
                        'element' => '#panel_tab-2',
                        'content' => $this->templating->render(
                            'course/edit_activities_course_info_tab.html.twig',
                            [
                                'courseInfo' => $courseInfo,
                                'form' => $form->createView()
                            ]
                        )
                    ];

                    // Get render to reload course info panel
                    $renders[] = [
                        'element' => '#course_info_panel',
                        'content' => $this->templating->render(
                            'course/edit_course_info_panel.html.twig',
                            [
                                'courseInfo' => $courseInfo,
                                'courseInfoHelper' => $this->courseInfoHelper
                            ]
                        )
                    ];
                }else {
                    $messages[] = [
                        'type' => "danger",
                        'message' => "Le formulaire n'a pas été soumis"
                    ];
                }
            }catch (CoursePermissionDeniedException $e){
                $messages[] = [
                    'type' => "danger",
                    'message' => sprintf("Vous n'avez pas les permissions nécessaires pour éditer ce cours.")
                ];
            } catch (CourseInfoNotFoundException $e) {
                // Return message course not found
                $messages[] = [
                    'type' => "danger",
                    'message' => sprintf("Le paiement %s n'existe pas", $id)
                ];
            }
        }catch (\Exception $e) {
            // Log error
            $this->logger->error((string) $e);
            // Return message error
            $messages[] = [
                'type' => "danger",
                'message' => "Une erreur est survenue"
            ];
        }
        return new JsonResponse(
            [
                'renders' => $renders,
                'messages' => $messages
            ]
        );
    }

}