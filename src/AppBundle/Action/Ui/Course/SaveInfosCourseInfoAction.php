<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Command\Course\EditInfosCourseInfoCommand;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Form\Course\EditInfosCourseInfoType;
use AppBundle\Helper\FileUploaderHelper;
use AppBundle\Query\Course\EditInfosCourseInfoQuery;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
     * @var LoggerInterface
     */
    private $logger;

    /**
     * SaveInfosCourseInfoAction constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param EditInfosCourseInfoQuery $editInfosCourseInfoQuery
     * @param FormFactoryInterface $formFactory
     * @param FileUploaderHelper $fileUploaderHelper
     * @param LoggerInterface $logger
     */
    public function __construct(
        FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
        EditInfosCourseInfoQuery $editInfosCourseInfoQuery,
        FormFactoryInterface $formFactory,
        FileUploaderHelper $fileUploaderHelper,
        LoggerInterface $logger
    )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->editInfosCourseInfoQuery = $editInfosCourseInfoQuery;
        $this->formFactory = $formFactory;
        $this->fileUploaderHelper = $fileUploaderHelper;
        $this->logger = $logger;
    }

    /**
     * @Route("/course/infos/save/{id}", name="save_infos_course_info")
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
                if($editInfosCourseInfoCommand == $originalEditInfosCourseInfoCommand){
                    return new JsonResponse([
                        'type' => "info",
                        'message' => "Aucun changement a enregistrer"
                    ]);
                }
                // Save changes
                $this->editInfosCourseInfoQuery->setEditInfosCourseInfoCommand(
                    $editInfosCourseInfoCommand
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