<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Command\Course\EditEquipmentsCourseInfoCommand;
use AppBundle\Command\CourseResourceEquipment\CourseResourceEquipmentCommand;
use AppBundle\Constant\Permission;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Exception\CoursePermissionDeniedException;
use AppBundle\Form\Course\EditEquipmentsCourseInfoType;
use AppBundle\Helper\CourseInfoHelper;
use AppBundle\Helper\CoursePermissionHelper;
use AppBundle\Helper\FileUploaderHelper;
use AppBundle\Query\Course\EditEquipmentsCourseInfoQuery;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use Doctrine\Common\Collections\ArrayCollection;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Twig\Environment;

/**
 * Class SaveEquipmentsCourseInfoAction
 * @package AppBundle\Action\Ui\Course
 */
class SaveEquipmentsCourseInfoAction implements ActionInterface
{

    /**
     * @var FindCourseInfoByIdQuery
     */
    private $findCourseInfoByIdQuery;

    /**
     * @var EditEquipmentsCourseInfoQuery
     */
    private $editEquipmentsCourseInfoQuery;

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

    private $courseInfoHelper;

    /**
     * SaveEquipmentsCourseInfoAction constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param EditEquipmentsCourseInfoQuery $editEquipmentsCourseInfoQuery
     * @param CoursePermissionHelper $coursePermissionHelper
     * @param TokenStorageInterface $tokenStorage
     * @param FormFactoryInterface $formFactory
     * @param FileUploaderHelper $fileUploaderHelper
     * @param Environment $templating
     * @param LoggerInterface $logger
     * @param CourseInfoHelper $courseInfoHelper
     */
    public function __construct(
        FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
        EditEquipmentsCourseInfoQuery $editEquipmentsCourseInfoQuery,
        CoursePermissionHelper $coursePermissionHelper,
        TokenStorageInterface $tokenStorage,
        FormFactoryInterface $formFactory,
        FileUploaderHelper $fileUploaderHelper,
        Environment $templating,
        LoggerInterface $logger,
        CourseInfoHelper $courseInfoHelper
    )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->editEquipmentsCourseInfoQuery = $editEquipmentsCourseInfoQuery;
        $this->coursePermissionHelper = $coursePermissionHelper;
        $this->tokenStorage = $tokenStorage;
        $this->formFactory = $formFactory;
        $this->fileUploaderHelper = $fileUploaderHelper;
        $this->logger = $logger;
        $this->templating = $templating;
        $this->courseInfoHelper = $courseInfoHelper;
    }

    /**
     * @Route("/course/equipments/save/{id}", name="save_equipments_course_info")
     */
    public function __invoke(Request $request)
    {
        $messages = [];
        $renders = [];
        try {
            $id = $request->get('id', null);
            // Find course info by id
            try {
                $courseInfo = $this->findCourseInfoByIdQuery->setId($id)->execute();
                if(!$this->coursePermissionHelper->hasPermission($courseInfo, $this->tokenStorage->getToken()->getUser(),Permission::WRITE)){
                    throw new CoursePermissionDeniedException();
                }
                // Init command
                $editEquipmentsCourseInfoCommand = new EditEquipmentsCourseInfoCommand($courseInfo);
                // Keep original command before modifications
                $originalEditEquipmentsCourseInfoCommand = clone $editEquipmentsCourseInfoCommand;
                // Generate form
                $form = $this->formFactory->create(
                    EditEquipmentsCourseInfoType::class,
                    $editEquipmentsCourseInfoCommand
                );
                $form->handleRequest($request);
                if ($form->isSubmitted()) {
                    $editEquipmentsCourseInfoCommand = $form->getData();
                    // Check if form is valid
                    if(!$form->isValid()){
                        $messages[] = [
                            'type' => "warning",
                            'message' => "Attention : l'ensemble des champs obligatoires doit être renseigné pour que le syllabus puisse être publié."
                        ];
                    }else{
                        $editEquipmentsCourseInfoCommand->setTemEquipmentsTabValid(true);
                    }

                    // Check if there have been any changes
                    if($editEquipmentsCourseInfoCommand != $originalEditEquipmentsCourseInfoCommand) {
                        // Save changes
                        $this->editEquipmentsCourseInfoQuery->setEditEquipmentsCourseInfoCommand(
                            $editEquipmentsCourseInfoCommand
                        )->execute();

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
                    $renders[] = [
                        'element' => '#panel_tab-5',
                        'content' => $this->templating->render(
                            'course/edit_equipments_course_info_tab.html.twig',
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

                }else{
                    $messages[] = [
                        'type' => "danger",
                        'message' => "Le formulaire n'a pas été soumis."
                    ];
                }
            }catch (CoursePermissionDeniedException $e){
                $messages[] = [
                    'type' => "danger",
                    'message' => "Vous ne disposez pas des permissions nécessaires pour éditer ce cours."
                ];
            } catch (CourseInfoNotFoundException $e) {
                // Return message course not found
                $messages[] = [
                    'type' => "danger",
                    'message' => sprintf("Le cours « %s » n'existe pas.", $id)
                ];
            }

        }catch (\Exception $e) {
            // Log error
            $this->logger->error((string)$e);

            // Return message error
            $messages[] = [
                'type' => "danger",
                'message' => "Une erreur est survenue."
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