<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Command\Course\EditClosingRemarksCourseInfoCommand;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Form\Course\EditClosingRemarksCourseInfoType;
use AppBundle\Helper\FileUploaderHelper;
use AppBundle\Query\Course\EditClosingRemarksCourseInfoQuery;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var FileUploaderHelper
     */
    private $fileUploaderHelper;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * SaveClosingRemarksCourseInfoAction constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param EditClosingRemarksCourseInfoQuery $editClosingRemarksCourseInfoQuery
     * @param FormFactoryInterface $formFactory
     * @param FileUploaderHelper $fileUploaderHelper
     * @param LoggerInterface $logger
     */
    public function __construct(
        FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
        EditClosingRemarksCourseInfoQuery $editClosingRemarksCourseInfoQuery,
        FormFactoryInterface $formFactory,
        FileUploaderHelper $fileUploaderHelper,
        LoggerInterface $logger
    )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->editClosingRemarksCourseInfoQuery = $editClosingRemarksCourseInfoQuery;
        $this->formFactory = $formFactory;
        $this->fileUploaderHelper = $fileUploaderHelper;
        $this->logger = $logger;
    }

    /**
     * @Route("/course/closingremarks/save/{id}", name="save_closing_remarks_course_info")
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
                if($editClosingRemarksCourseInfoCommand == $originalEditClosingRemarksCourseInfoCommand){
                    return new JsonResponse([
                        'type' => "info",
                        'message' => "Aucun changement a enregistrer"
                    ]);
                }
                // Save changes
                $this->editClosingRemarksCourseInfoQuery->setEditClosingRemarksCourseInfoCommand(
                    $editClosingRemarksCourseInfoCommand
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
            $this->logger->error((string) $e);
            // Return message error
            return new JsonResponse([
                'type' => "danger",
                'message' => "Une erreur est survenue"
            ]);
        }
    }

}