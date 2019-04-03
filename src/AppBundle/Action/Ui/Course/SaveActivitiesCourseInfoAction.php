<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Command\Course\EditActivitiesCourseInfoCommand;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Form\Course\EditActivitiesCourseInfoType;
use AppBundle\Query\Course\EditActivitiesCourseInfoQuery;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
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
     * @param FormFactoryInterface $formFactory
     * @param Environment $templating
     * @param LoggerInterface $logger
     */
    public function __construct(
        FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
        EditActivitiesCourseInfoQuery $editActivitiesCourseInfoQuery,
        FormFactoryInterface $formFactory,
        Environment $templating,
        LoggerInterface $logger
    )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->editActivitiesCourseInfoQuery = $editActivitiesCourseInfoQuery;
        $this->formFactory = $formFactory;
        $this->logger = $logger;
        $this->templating = $templating;
    }

    /**
     * @Route("/course/activities/save/{id}", name="save_activities_course_info")
     */
    public function __invoke(Request $request)
    {
        $messages = [];
        $render = null;
        try{
            $id = $request->get('id', null);
            // Find course info by id
            try{
                $courseInfo = $this->findCourseInfoByIdQuery->setId($id)->execute();

                // Init command
                $editActivitiesCourseInfoCommand = new EditActivitiesCourseInfoCommand($courseInfo);
                // Keep original command before modifications
                $originalEditActivitiesCourseInfoCommand = clone $editActivitiesCourseInfoCommand;
                //
                $form = $this->formFactory->create(EditActivitiesCourseInfoType::class, $editActivitiesCourseInfoCommand);
                $form->handleRequest($request);
                if($form->isSubmitted()){
                    $editActivitiesCourseInfoCommand = $form->getData();

                    // Check if there have been anny changes
                    if($editActivitiesCourseInfoCommand != $originalEditActivitiesCourseInfoCommand) {
                        // Save changes
                        $this->editActivitiesCourseInfoQuery->setEditActivitiesCourseInfoCommand($editActivitiesCourseInfoCommand)->execute();
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

                    // Check if form is valid
                    if(!$form->isValid()){
                        $messages[] = [
                            'type' => "warning",
                            'message' => "Attention, pour pouvoir publier le cours vous devez renseigner tous les champs obligatoires"
                        ];
                    }

                    // Get render to reload form
                    $render = $this->templating->render(
                        'course/edit_activities_course_info_tab.html.twig',
                        [
                            'courseInfo' => $courseInfo,
                            'form' => $form->createView()
                        ]
                    );
                }else {
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
                'messages' => $messages
            ]
        );
    }

}