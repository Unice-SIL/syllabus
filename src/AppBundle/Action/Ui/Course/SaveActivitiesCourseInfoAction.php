<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Command\Course\EditActivitiesCourseInfoCommand;
use AppBundle\Command\Course\EditPresentationCourseInfoCommand;
use AppBundle\Form\Course\EditActivitiesCourseInfoType;
use AppBundle\Form\Course\EditPresentationCourseInfoType;
use AppBundle\Query\Course\EditActivitiesCourseInfoQuery;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
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
     * SavePresentationCourseInfoAction constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param EditActivitiesCourseInfoQuery $editActivitiesCourseInfoQuery
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(
        FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
        EditActivitiesCourseInfoQuery $editActivitiesCourseInfoQuery,
        FormFactoryInterface $formFactory
    )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->editActivitiesCourseInfoQuery = $editActivitiesCourseInfoQuery;
        $this->formFactory = $formFactory;
    }

    /**
     * @Route("/course/activities/save/{id}", name="save_activities_course_info")
     */
    public function __invoke(Request $request)
    {
        $id = $request->get('id', null);
        $courseInfo = $this->findCourseInfoByIdQuery->setId($id)->execute();
        $editActivitiesCourseInfoCommand = new EditActivitiesCourseInfoCommand($courseInfo);
        $form = $this->formFactory->create(EditActivitiesCourseInfoType::class, $editActivitiesCourseInfoCommand);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $editActivitiesCourseInfoCommand = $form->getData();
            $this->editActivitiesCourseInfoQuery->setEditActivitiesCourseInfoCommand($editActivitiesCourseInfoCommand)->execute();
        }
        return new JsonResponse([]);
    }

}