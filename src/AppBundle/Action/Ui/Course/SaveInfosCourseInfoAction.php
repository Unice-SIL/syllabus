<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Command\Course\EditInfosCourseInfoCommand;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Form\Course\EditInfosCourseInfoType;
use AppBundle\Helper\CourseInfoHelper;
use AppBundle\Helper\FileUploaderHelper;
use AppBundle\Query\Course\EditInfosCourseInfoQuery;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Class SaveInfosCourseInfoAction
 * @package AppBundle\Action\Ui\Course
 */
class SaveInfosCourseInfoAction implements ActionInterface
{

    /**
     * @var FindCourseInfoByIdQuery
     */
    private $findCourseInfoByIdQuery;

    /**
     * @var EditInfosCourseInfoQuery
     */
    private $editInfosCourseInfoQuery;

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
     * SaveInfosCourseInfoAction constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param EditInfosCourseInfoQuery $editInfosCourseInfoQuery
     * @param FormFactoryInterface $formFactory
     * @param FileUploaderHelper $fileUploaderHelper
     * @param Environment $templating
     * @param LoggerInterface $logger
     * @param CourseInfoHelper $courseInfoHelper
     */
    public function __construct(
        FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
        EditInfosCourseInfoQuery $editInfosCourseInfoQuery,
        FormFactoryInterface $formFactory,
        FileUploaderHelper $fileUploaderHelper,
        Environment $templating,
        LoggerInterface $logger,
        CourseInfoHelper $courseInfoHelper
    )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->editInfosCourseInfoQuery = $editInfosCourseInfoQuery;
        $this->formFactory = $formFactory;
        $this->fileUploaderHelper = $fileUploaderHelper;
        $this->templating = $templating;
        $this->logger = $logger;
        $this->courseInfoHelper = $courseInfoHelper;
    }

    /**
     * @Route("/course/infos/save/{id}", name="save_infos_course_info")
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
                $editInfosCourseInfoCommand = new EditInfosCourseInfoCommand($courseInfo);
                // Keep original command before modifications
                $originalEditInfosCourseInfoCommand = clone $editInfosCourseInfoCommand;
                // Generate form
                $form = $this->formFactory->create(
                    EditInfosCourseInfoType::class,
                    $editInfosCourseInfoCommand
                );
                $form->handleRequest($request);
                if ($form->isSubmitted()) {
                    $editInfosCourseInfoCommand = $form->getData();
                    // Check if there have been anny changes
                    if(!$form->isValid()){
                        $messages[] = [
                            'type' => "warning",
                            'message' => "Attention, pour pouvoir publier le cours vous devez renseigner tous les champs obligatoires"
                        ];
                        $render = $this->templating->render(
                            'course/edit_infos_course_info_tab.html.twig',
                            [
                                'courseInfo' => $courseInfo,
                                'form' => $form->createView()
                            ]
                        );
                    }else{
                        $editInfosCourseInfoCommand->setTemInfosTabValid(true);
                    }

                    if($editInfosCourseInfoCommand != $originalEditInfosCourseInfoCommand){
                        // Save changes
                        $this->editInfosCourseInfoQuery->setEditInfosCourseInfoCommand(
                            $editInfosCourseInfoCommand
                        )->execute();

                        // Return message success
                        $messages[] = [
                            'type' => "success",
                            'message' => "Modifications enregistrées avec succès"
                        ];
                    }else{
                        $messages[] = [
                            'type' => "info",
                            'message' => "Aucun changement a enregistrer"
                        ];
                    }

                    // Get render to reload form
                    $renders[] = [
                        'element' => '#panel_tab-6',
                        'content' => $this->templating->render(
                            'course/edit_infos_course_info_tab.html.twig',
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
                'render' => $render,
                'messages' => $messages,
                'canBePublish' => $canBePublish
            ]
        );
    }

}