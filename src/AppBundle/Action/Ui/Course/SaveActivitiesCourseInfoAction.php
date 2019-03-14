<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Command\Course\EditActivitiesCourseInfoCommand;
use AppBundle\Command\Course\EditPresentationCourseInfoCommand;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Form\Course\EditActivitiesCourseInfoType;
use AppBundle\Form\Course\EditPresentationCourseInfoType;
use AppBundle\Query\Course\EditActivitiesCourseInfoQuery;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
     * @var LoggerInterface
     */
    private $logger;

    /**
     * SaveActivitiesCourseInfoAction constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param EditActivitiesCourseInfoQuery $editActivitiesCourseInfoQuery
     * @param FormFactoryInterface $formFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
        EditActivitiesCourseInfoQuery $editActivitiesCourseInfoQuery,
        FormFactoryInterface $formFactory,
        LoggerInterface $logger
    )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->editActivitiesCourseInfoQuery = $editActivitiesCourseInfoQuery;
        $this->formFactory = $formFactory;
        $this->logger = $logger;
    }

    /**
     * @Route("/course/activities/save/{id}", name="save_activities_course_info")
     */
    public function __invoke(Request $request)
    {
        try{
            $id = $request->get('id', null);
            try{
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
            $editActivitiesCourseInfoCommand = new EditActivitiesCourseInfoCommand($courseInfo);
            $form = $this->formFactory->create(EditActivitiesCourseInfoType::class, $editActivitiesCourseInfoCommand);
            $form->handleRequest($request);
            if($form->isSubmitted()){
                $editActivitiesCourseInfoCommand = $form->getData();
                // Save changes
                $this->editActivitiesCourseInfoQuery->setEditActivitiesCourseInfoCommand($editActivitiesCourseInfoCommand)->execute();
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