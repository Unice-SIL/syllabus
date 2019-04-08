<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Command\Course\EditMccCourseInfoCommand;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Form\Course\EditMccCourseInfoType;
use AppBundle\Helper\CourseInfoHelper;
use AppBundle\Helper\FileUploaderHelper;
use AppBundle\Query\Course\EditMccCourseInfoQuery;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Class SaveMccCourseInfoAction
 * @package AppBundle\Action\Ui\Course
 */
class SaveMccCourseInfoAction implements ActionInterface
{

    /**
     * @var FindCourseInfoByIdQuery
     */
    private $findCourseInfoByIdQuery;

    /**
     * @var EditMccCourseInfoQuery
     */
    private $editMccCourseInfoQuery;

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
     * SaveMccCourseInfoAction constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param EditMccCourseInfoQuery $editMccCourseInfoQuery
     * @param FormFactoryInterface $formFactory
     * @param FileUploaderHelper $fileUploaderHelper
     * @param Environment $templating
     * @param LoggerInterface $logger
     * @param CourseInfoHelper $courseInfoHelper
     */
    public function __construct(
        FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
        EditMccCourseInfoQuery $editMccCourseInfoQuery,
        FormFactoryInterface $formFactory,
        FileUploaderHelper $fileUploaderHelper,
        Environment $templating,
        LoggerInterface $logger,
        CourseInfoHelper $courseInfoHelper
    )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->editMccCourseInfoQuery = $editMccCourseInfoQuery;
        $this->formFactory = $formFactory;
        $this->fileUploaderHelper = $fileUploaderHelper;
        $this->templating = $templating;
        $this->logger = $logger;
        $this->courseInfoHelper = $courseInfoHelper;
    }

    /**
     * @Route("/course/mcc/save/{id}", name="save_mcc_course_info")
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
                // Init command
                $editMccCourseInfoCommand = new EditMccCourseInfoCommand($courseInfo);
                // Keep original command before modifications
                $originalEditMccCourseInfoCommand = clone $editMccCourseInfoCommand;
                // Generate form
                $form = $this->formFactory->create(
                    EditMccCourseInfoType::class,
                    $editMccCourseInfoCommand
                );
                $form->handleRequest($request);
                if ($form->isSubmitted()) {
                    $editMccCourseInfoCommand = $form->getData();
                    if(!$form->isValid()){
                        $messages[] = [
                            'type' => "warning",
                            'message' => "Attention, pour pouvoir publier le cours vous devez renseigner tous les champs obligatoires."
                        ];
                    }else{
                        $editMccCourseInfoCommand->setTemMccTabValid(true);
                    }

                    // Check if there have been any changes
                    if($editMccCourseInfoCommand != $originalEditMccCourseInfoCommand){
                        // Save changes
                        $this->editMccCourseInfoQuery->setEditMccCourseInfoCommand(
                            $editMccCourseInfoCommand
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
                        'element' => '#panel_tab-4',
                        'content' => $this->templating->render(
                            'course/edit_mcc_course_info_tab.html.twig',
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
                        'message' => "Le formulaire n'a pas été soumis"
                    ];
                }
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