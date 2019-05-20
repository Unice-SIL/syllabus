<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Command\Course\EditClosingRemarksCourseInfoCommand;
use AppBundle\Constant\Permission;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Exception\CoursePermissionDeniedException;
use AppBundle\Form\Course\EditClosingRemarksCourseInfoType;
use AppBundle\Helper\CourseInfoHelper;
use AppBundle\Helper\CoursePermissionHelper;
use AppBundle\Helper\FileUploaderHelper;
use AppBundle\Query\Course\EditClosingRemarksCourseInfoQuery;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Twig\Environment;

/**
 * Class SaveClosingRemarksCourseInfoAction
 * @package AppBundle\Action\Ui\Course
 */
class SaveClosingRemarksCourseInfoAction implements ActionInterface
{

    /**
     * @var FindCourseInfoByIdQuery
     */
    private $findCourseInfoByIdQuery;

    /**
     * @var EditClosingRemarksCourseInfoQuery
     */
    private $editClosingRemarksCourseInfoQuery;

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
    private  $templating;

    /**
     * @var LoggerInterface
     */
    private $logger;


    /**
     * SaveClosingRemarksCourseInfoAction constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param EditClosingRemarksCourseInfoQuery $editClosingRemarksCourseInfoQuery
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
        EditClosingRemarksCourseInfoQuery $editClosingRemarksCourseInfoQuery,
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
        $this->editClosingRemarksCourseInfoQuery = $editClosingRemarksCourseInfoQuery;
        $this->courseInfoHelper = $courseInfoHelper;
        $this->coursePermissionHelper = $coursePermissionHelper;
        $this->tokenStorage = $tokenStorage;
        $this->formFactory = $formFactory;
        $this->fileUploaderHelper = $fileUploaderHelper;
        $this->templating = $templating;
        $this->logger = $logger;
    }

    /**
     * @Route("/course/closingremarks/save/{id}", name="save_closing_remarks_course_info")
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
                $editClosingRemarksCourseInfoCommand = new EditClosingRemarksCourseInfoCommand($courseInfo);
                // Keep original command before modifications
                $originalEditClosingRemarksCourseInfoCommand = clone $editClosingRemarksCourseInfoCommand;
                // Generate form
                $form = $this->formFactory->create(
                    EditClosingRemarksCourseInfoType::class,
                    $editClosingRemarksCourseInfoCommand
                );
                $form->handleRequest($request);
                if ($form->isSubmitted()) {
                    $editClosingRemarksCourseInfoCommand = $form->getData();
                    // Check if there have been anny changes
                    if(!$form->isValid()){
                        $messages[] = [
                            'type' => "warning",
                            'message' => "Attention : l'ensemble des champs obligatoires doit être renseigné pour que le syllabus puisse être publié."
                        ];
                    }else{
                        $editClosingRemarksCourseInfoCommand->setTemClosingRemarksTabValid(true);
                    }

                    // Check if there have been any changes
                    if($editClosingRemarksCourseInfoCommand != $originalEditClosingRemarksCourseInfoCommand){
                        // Save changes
                        $this->editClosingRemarksCourseInfoQuery->setEditClosingRemarksCourseInfoCommand(
                            $editClosingRemarksCourseInfoCommand
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
                        'element' => '#panel_tab-7',
                        'content' => $this->templating->render(
                            'course/edit_closing_remarks_course_info_tab.html.twig',
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

                }
                else{
                    $messages[] = [
                        'type' => "danger",
                        'message' => "Le formulaire n'a pas été soumis."
                    ];
                }
            } catch (CourseInfoNotFoundException $e) {
                // Return message course not found
                $messages[] = [
                        'type' => "danger",
                        'message' => sprintf("Le cours « %s » n'existe pas.", $id)
                ];
            }
        }catch (CoursePermissionDeniedException $e){
            $messages[] = [
                'type' => "danger",
                'message' => "Vous ne disposez pas des permissions nécessaires pour éditer ce syllabus."
            ];
        }catch (\Exception $e) {
            // Log error
            $this->logger->error((string) $e);
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