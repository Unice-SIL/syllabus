<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Command\Course\EditCourseInfoCommand;
use AppBundle\Form\EditCourseInfoType;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class EditCourse
 * @package AppBundle\Action\Ui\Course
 */
class EditCourse implements ActionInterface
{

    private $findCourseInfoByIdQuery;

    private $formFactory;

    /**
     * EditCourse constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(
        FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
        FormFactoryInterface $formFactory
    )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->formFactory = $formFactory;
    }

    /**
     * @param $id
     * @param Request $request
     */
    public function __invoke(Request $request)
    {
        $id = $request->get('id', null);
        $editCourseInfoCommand = $this->findCourseInfoByIdQuery->setId($id)->execute();
        $editCourseInfoCommand = new EditCourseInfoCommand($editCourseInfoCommand);
        $form = $this->formFactory->create(EditCourseInfoType::class, $editCourseInfoCommand);
        $form->handleRequest($request);


    }
}