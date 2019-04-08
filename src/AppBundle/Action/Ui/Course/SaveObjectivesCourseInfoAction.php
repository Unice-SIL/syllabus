<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Command\Course\EditActivitiesCourseInfoCommand;
use AppBundle\Command\Course\EditObjectivesCourseInfoCommand;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Helper\CourseInfoHelper;
use AppBundle\Form\Course\EditActivitiesCourseInfoType;
use AppBundle\Form\Course\EditObjectivesCourseInfoType;
use AppBundle\Query\Course\EditActivitiesCourseInfoQuery;
use AppBundle\Query\Course\EditObjectivesCourseInfoQuery;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Class SaveObjectivesCourseInfoAction
 * @package AppBundle\Action\Ui\Course
 */
class SaveObjectivesCourseInfoAction implements ActionInterface
{

    /**
     * @var FindCourseInfoByIdQuery
     */
    private $findCourseInfoByIdQuery;

    /**
     * @var EditObjectivesCourseInfoQuery
     */
    private $editObjectivesCourseInfoQuery;

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
     * SaveObjectivesCourseInfoAction constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param EditObjectivesCourseInfoQuery $editObjectivesCourseInfoQuery
     * @param FormFactoryInterface $formFactory
     * @param LoggerInterface $logger
     * @param CourseInfoHelper $courseInfoHelper
     */
    public function __construct(
        FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
        EditObjectivesCourseInfoQuery $editObjectivesCourseInfoQuery,
        FormFactoryInterface $formFactory,
        Environment $templating,
        LoggerInterface $logger,
        CourseInfoHelper $courseInfoHelper
    )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->editObjectivesCourseInfoQuery = $editObjectivesCourseInfoQuery;
        $this->formFactory = $formFactory;
        $this->logger = $logger;
        $this->templating = $templating;
        $this->courseInfoHelper = $courseInfoHelper;
    }

    /**
     * @Route("/course/objectives/save/{id}", name="save_objectives_course_info")
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

                // Init command
                $editObjectivesCourseInfoCommand = new EditObjectivesCourseInfoCommand($courseInfo);
                // Keep original command before modifications
                $originalEditObjectivesCourseInfoCommand = clone $editObjectivesCourseInfoCommand;
                //
                $form = $this->formFactory->create(EditObjectivesCourseInfoType::class, $editObjectivesCourseInfoCommand);
                $form->handleRequest($request);
                if($form->isSubmitted()){
                    $editObjectivesCourseInfoCommand = $form->getData();

                    // Check if form is valid
                    if(!$form->isValid()){
                        $messages[] = [
                            'type' => "warning",
                            'message' => "Attention, pour pouvoir publier le cours vous devez renseigner tous les champs obligatoires."
                        ];
                    }else{
                        $editObjectivesCourseInfoCommand->setTemObjectivesTabValid(true);
                    }

                    // Check if there have been anny changes
                    if($editObjectivesCourseInfoCommand != $originalEditObjectivesCourseInfoCommand) {
                        // Save changes
                        $this->editObjectivesCourseInfoQuery->setEditObjectivesCourseInfoCommand($editObjectivesCourseInfoCommand)->execute();

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
                        'element' => '#panel_tab-3',
                        'content' => $this->templating->render(
                            'course/edit_objectives_course_info_tab.html.twig',
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