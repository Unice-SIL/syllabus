<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Command\Course\EditEquipmentsCourseInfoCommand;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Form\Course\EditEquipmentsCourseInfoType;
use AppBundle\Helper\FileUploaderHelper;
use AppBundle\Query\Course\EditEquipmentsCourseInfoQuery;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
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
     * SaveEquipmentsCourseInfoAction constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param EditEquipmentsCourseInfoQuery $editEquipmentsCourseInfoQuery
     * @param FormFactoryInterface $formFactory
     * @param FileUploaderHelper $fileUploaderHelper
     * @param LoggerInterface $logger
     */
    public function __construct(
        FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
        EditEquipmentsCourseInfoQuery $editEquipmentsCourseInfoQuery,
        FormFactoryInterface $formFactory,
        FileUploaderHelper $fileUploaderHelper,
        Environment $templating,
        LoggerInterface $logger
    )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->editEquipmentsCourseInfoQuery = $editEquipmentsCourseInfoQuery;
        $this->formFactory = $formFactory;
        $this->fileUploaderHelper = $fileUploaderHelper;
        $this->logger = $logger;
        $this->templating = $templating;
    }

    /**
     * @Route("/course/equipments/save/{id}", name="save_equipments_course_info")
     */
    public function __invoke(Request $request)
    {
        $messages = [];
        $render = null;
        try {
            $id = $request->get('id', null);
            // Find course info by id
            try {
                $courseInfo = $this->findCourseInfoByIdQuery->setId($id)->execute();

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
                            'message' => "Attention, pour pouvoir publier le cours vous devez renseigner tous les champs obligatoires"
                        ];
                    }else{
                        $editEquipmentsCourseInfoCommand->setTemEquipmentsTabValid(true);
                    }

                    // Check if there have been anny changes
                    if($editEquipmentsCourseInfoCommand != $originalEditEquipmentsCourseInfoCommand) {
                        // Save changes
                        $this->editEquipmentsCourseInfoQuery->setEditEquipmentsCourseInfoCommand(
                            $editEquipmentsCourseInfoCommand
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
                    $render = $this->templating->render(
                        'course/edit_equipments_course_info_tab.html.twig',
                        [
                            'courseInfo' => $courseInfo,
                            'form' => $form->createView()
                        ]
                    );
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
            $this->logger->error((string)$e);

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