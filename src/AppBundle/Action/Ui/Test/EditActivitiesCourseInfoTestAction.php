<?php

namespace AppBundle\Action\Ui\Test;

use AppBundle\Action\ActionInterface;
use AppBundle\Command\Course\EditActivitiesCourseInfoCommand;
use AppBundle\Form\Course\EditActivitiesCourseInfoType;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Class EditActivitiesCourseInfoTestAction
 * @package AppBundle\Action\Ui\Test
 */
class EditActivitiesCourseInfoTestAction implements ActionInterface
{
    /**
     * @var FindCourseInfoByIdQuery
     */
    private $findCourseInfoByIdQuery;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var Environment
     */
    private $templating;

    /**
     * EditActivitiesCourseInfoTestAction constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param FormFactoryInterface $formFactory
     * @param Environment $templating
     */
    public function __construct(
        FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
        FormFactoryInterface $formFactory,
        Environment $templating
    )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->formFactory = $formFactory;
        $this->templating = $templating;
    }

    /**
     * @Route("/test/course/activities/edit/{id}", name="edit_activities_course_info_test")
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $id = $request->get('id', null);
        $courseInfo = $this->findCourseInfoByIdQuery->setId($id)->execute();
        $editActivitiesCourseInfoCommand = new EditActivitiesCourseInfoCommand($courseInfo);
        $form = $this->formFactory->create(EditActivitiesCourseInfoType::class, $editActivitiesCourseInfoCommand);
        $form->handleRequest($request);

        return new Response(
            $this->templating->render(
                'course/edit_activities_course_info_tab.html.twig',
                [
                    'courseInfo' => $courseInfo,
                    'form' => $form->createView()
                ]
            )
        );
    }
}