<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Command\Course\EditMccCourseInfoCommand;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Form\Course\EditMccCourseInfoType;
use AppBundle\Helper\FileUploaderHelper;
use AppBundle\Query\Course\EditMccCourseInfoQuery;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
     * @var LoggerInterface
     */
    private $logger;

    /**
     * SaveMccCourseInfoAction constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param EditMccCourseInfoQuery $editMccCourseInfoQuery
     * @param FormFactoryInterface $formFactory
     * @param FileUploaderHelper $fileUploaderHelper
     * @param LoggerInterface $logger
     */
    public function __construct(
        FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
        EditMccCourseInfoQuery $editMccCourseInfoQuery,
        FormFactoryInterface $formFactory,
        FileUploaderHelper $fileUploaderHelper,
        LoggerInterface $logger
    )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->editMccCourseInfoQuery = $editMccCourseInfoQuery;
        $this->formFactory = $formFactory;
        $this->fileUploaderHelper = $fileUploaderHelper;
        $this->logger = $logger;
    }

    /**
     * @Route("/course/mcc/save/{id}", name="save_mcc_course_info")
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
                // Check if there have been anny changes
                if($editMccCourseInfoCommand == $originalEditMccCourseInfoCommand){
                    return new JsonResponse([
                        'type' => "info",
                        'message' => "Aucun changement a enregistrer"
                    ]);
                }
                // Save changes
                $this->editMccCourseInfoQuery->setEditMccCourseInfoCommand(
                    $editMccCourseInfoCommand
                )->execute();
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