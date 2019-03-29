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
        LoggerInterface $logger
    )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->editEquipmentsCourseInfoQuery = $editEquipmentsCourseInfoQuery;
        $this->formFactory = $formFactory;
        $this->fileUploaderHelper = $fileUploaderHelper;
        $this->logger = $logger;
    }

    /**
     * @Route("/course/equipments/save/{id}", name="save_equipments_course_info")
     */
    public function __invoke(Request $request)
    {
        try {
            $id = $request->get('id', null);
            // Find course info by id
            try {
                $courseInfo = $this->findCourseInfoByIdQuery->setId($id)->execute();
            } catch (CourseInfoNotFoundException $e) {
                // Return message course not found
                return new JsonResponse(
                    [
                        'type' => "danger",
                        'message' => sprintf("Le paiement %s n'existe pas", $id)
                    ]
                );
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
                // Check if there have been anny changes
                if($editEquipmentsCourseInfoCommand == $originalEditEquipmentsCourseInfoCommand){
                    return new JsonResponse([
                        'type' => "info",
                        'message' => "Aucun changement a enregistrer"
                    ]);
                }
                // Save changes
                /*
                $this->editEquipmentsCourseInfoQuery->setEditEquipmentsCourseInfoCommand(
                    $editEquipmentsCourseInfoCommand
                )->execute();
                */
                // Return message success
                return new JsonResponse([
                    'type' => "success",
                    'message' => "Modifications enregistrées avec succès"
                ]);
            }
            return new JsonResponse([
                'type' => "danger",
                'message' => "Le formulaire n'a pas été soumis"
            ]);
        }catch (\Exception $e) {
            // Log error
            $this->logger->error((string)$e);

            // Return message error
            return new JsonResponse(
                [
                    'type' => "danger",
                    'message' => "Une erreur est survenue"
                ]
            );
        }
    }

}