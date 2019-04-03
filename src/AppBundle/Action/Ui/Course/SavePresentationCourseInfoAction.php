<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Command\Course\EditPresentationCourseInfoCommand;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Form\Course\EditPresentationCourseInfoType;
use AppBundle\Helper\FileUploaderHelper;
use AppBundle\Query\Course\EditPresentationCourseInfoQuery;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Class SavePresentationCourseInfoAction
 * @package AppBundle\Action\Ui\Course
 */
class SavePresentationCourseInfoAction implements ActionInterface
{

    /**
     * @var FindCourseInfoByIdQuery
     */
    private $findCourseInfoByIdQuery;

    /**
     * @var EditPresentationCourseInfoQuery
     */
    private $editPresentationCourseInfoQuery;

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
     * SavePresentationCourseInfoAction constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param EditPresentationCourseInfoQuery $editPresentationCourseInfoQuery
     * @param FormFactoryInterface $formFactory
     * @param FileUploaderHelper $fileUploaderHelper
     * @param Environment $templating
     * @param LoggerInterface $logger
     */
    public function __construct(
        FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
        EditPresentationCourseInfoQuery $editPresentationCourseInfoQuery,
        FormFactoryInterface $formFactory,
        FileUploaderHelper $fileUploaderHelper,
        Environment $templating,
        LoggerInterface $logger
    )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->editPresentationCourseInfoQuery = $editPresentationCourseInfoQuery;
        $this->formFactory = $formFactory;
        $this->fileUploaderHelper = $fileUploaderHelper;
        $this->logger = $logger;
        $this->templating = $templating;
    }

    /**
     * @Route("/course/presentation/save/{id}", name="save_presentation_course_info")
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

                if (!is_null($courseInfo->getImage())) {
                    $courseInfo->setImage(new File($this->fileUploaderHelper->getDirectory().'/'.$courseInfo->getImage()));
                }

                // Init command
                $editPresentationCourseInfoCommand = new EditPresentationCourseInfoCommand($courseInfo);
                // Keep original command before modifications
                $originalEditPresentationCourseInfoCommand = clone $editPresentationCourseInfoCommand;

                // Generate form
                $form = $this->formFactory->create(
                    EditPresentationCourseInfoType::class,
                    $editPresentationCourseInfoCommand
                );
                $form->handleRequest($request);
                // Check if form is submitted
                if ($form->isSubmitted()) {
                    // Get form data from request
                    $editPresentationCourseInfoCommand = $form->getData();
                    // If there is no new image to upload keep the actual image
                    if (is_null($editPresentationCourseInfoCommand->getImage())) {
                        $editPresentationCourseInfoCommand->setImage($courseInfo->getImage());
                    }
                    // Check if there have been any changes
                    if($editPresentationCourseInfoCommand != $originalEditPresentationCourseInfoCommand) {
                        // Save changes
                        $this->editPresentationCourseInfoQuery->setEditPresentationCourseInfoCommand(
                            $editPresentationCourseInfoCommand
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

                    if(!$form->isValid()){
                        $messages[] = [
                            'type' => "warning",
                            'message' => "Attention, pour pouvoir publier le cours vous devez renseigner tous les champs obligatoires"
                        ];
                    }

                    $render = $this->templating->render(
                        'course/edit_presentation_course_tab.html.twig',
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