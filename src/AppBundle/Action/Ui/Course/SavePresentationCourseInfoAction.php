<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Command\Course\EditPresentationCourseInfoCommand;
use AppBundle\Constant\Permission;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Exception\CoursePermissionDeniedException;
use AppBundle\Form\Course\EditPresentationCourseInfoType;
use AppBundle\Helper\CourseInfoHelper;
use AppBundle\Helper\CoursePermissionHelper;
use AppBundle\Helper\FileUploaderHelper;
use AppBundle\Query\Course\EditPresentationCourseInfoQuery;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Twig\Environment;

/**
 * Class SavePresentationCourseInfoAction
 * @package AppBundle\Action\Ui\Course
 */
class SavePresentationCourseInfoAction implements ActionInterface
{

    /**
     * @var FindCourseInfoByIdQuery
     */
    private $findCourseInfoByIdQuery;

    /**
     * @var EditPresentationCourseInfoQuery
     */
    private $editPresentationCourseInfoQuery;

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
     * @var FileUploaderHelper
     */
    private $fileUploaderHelper;

    /**
     * @var Environment
     */
    private $templating;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * SavePresentationCourseInfoAction constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param EditPresentationCourseInfoQuery $editPresentationCourseInfoQuery
     * @param CourseInfoHelper $courseInfoHelper
     * @param CoursePermissionHelper $coursePermissionHelper
     * @param TokenStorageInterface $tokenStorage
     * @param FormFactoryInterface $formFactory
     * @param FileUploaderHelper $fileUploaderHelper
     * @param Environment $templating
     * @param LoggerInterface $logger
     */
    public function __construct(
        FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
        EditPresentationCourseInfoQuery $editPresentationCourseInfoQuery,
        CourseInfoHelper $courseInfoHelper,
        CoursePermissionHelper $coursePermissionHelper,
        TokenStorageInterface $tokenStorage,
        FormFactoryInterface $formFactory,
        FileUploaderHelper $fileUploaderHelper,
        Environment $templating,
        LoggerInterface $logger
    )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->editPresentationCourseInfoQuery = $editPresentationCourseInfoQuery;
        $this->coursePermissionHelper = $coursePermissionHelper;
        $this->tokenStorage = $tokenStorage;
        $this->formFactory = $formFactory;
        $this->fileUploaderHelper = $fileUploaderHelper;
        $this->logger = $logger;
        $this->templating = $templating;
        $this->courseInfoHelper = $courseInfoHelper;
    }

    /**
     * @Route("/course/presentation/save/{id}", name="save_presentation_course_info")
     */
    public function __invoke(Request $request)
    {
        $messages = [];
        $renders = [];
        try {
            $id = $request->get('id', null);
            try {
                // Find course info by id
                $courseInfo = $this->findCourseInfoByIdQuery->setId($id)->execute();

                if (!$this->coursePermissionHelper->hasPermission(
                            $courseInfo,
                            $this->tokenStorage->getToken()->getUser(),
                            Permission::WRITE
                        )) {
                    throw new CoursePermissionDeniedException();
                }

                // Init command
                $editPresentationCourseInfoCommand = new EditPresentationCourseInfoCommand($courseInfo);
                // Keep original command before modifications
                $originalEditPresentationCourseInfoCommand = clone $editPresentationCourseInfoCommand;

                // Generate form
                $form = $this->formFactory->create(
                    EditPresentationCourseInfoType::class,
                    $editPresentationCourseInfoCommand
                );
                $form->handleRequest($request);

                // Check if form is submitted
                if ($form->isSubmitted()) {

                    // Get form data from request
                    $editPresentationCourseInfoCommand = $form->getData();

                    // If there is no new image to upload keep the actual image
                    if (is_null($editPresentationCourseInfoCommand->getImage())) {
                        $editPresentationCourseInfoCommand->setImage($courseInfo->getImage());
                    }

                    // Check if form is valid
                    if (!$form->isValid()) {
                        if (is_null($courseInfo->getPublicationDate())) {
                            $messages[] = [
                                'type' => "warning",
                                'message' => "Attention : tous les champs obligatoires doivent être renseignés pour que le syllabus puisse être publié."
                            ];
                        } else {
                            $messages[] = [
                                'type' => "error",
                                'message' => "Attention : certains champs obligatoires ne sont plus renseignés alors que le syllabus est publié."
                            ];
                        }
                    } else {
                        $editPresentationCourseInfoCommand->setTemPresentationTabValid(true);
                    }

                    // Check if there have been any changes
                    if ($editPresentationCourseInfoCommand != $originalEditPresentationCourseInfoCommand) {
                        // Save changes
                        $this->editPresentationCourseInfoQuery->setEditPresentationCourseInfoCommand(
                            $editPresentationCourseInfoCommand
                        )->execute();

                        // Return message success
                        $messages[] = [
                            'type' => "success",
                            'message' => "Modifications enregistrées avec succès."
                        ];

                    } else {
                        $messages[] = [
                            'type' => "info",
                            'message' => "Aucun changement à enregistrer."
                        ];
                    }

                    // Get render to reload form
                    $renders[] = [
                        'element' => '#panel_tab-1',
                        'content' => $this->templating->render(
                            'course/edit_presentation_course_tab.html.twig',
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
                } else {
                    $messages[] = [
                        'type' => "danger",
                        'message' => "Le formulaire n'a pas été soumis."
                    ];
                }
            } catch(CoursePermissionDeniedException $e) {
                $messages[] = [
                    'type' => "danger",
                    'message' => "Vous ne disposez pas des permissions nécessaires pour éditer ce syllabus."
                ];
            } catch(CourseInfoNotFoundException $e) {
                // Return message course not found
                $messages[] = [
                    'type' => "danger",
                    'message' => sprintf("Le syllabus « %s » n'existe pas.", $id)
                ];
            }
        } catch(\Exception $e) {
            // Log error
            $this->logger->error((string) $e);
            // Return message error
            $messages[] = [
                'type' => "danger",
                'message' => "Une erreur est survenue."
            ];
        }
        return new JsonResponse([
            'renders' => $renders,
            'messages' => $messages
        ]);
    }

}