<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Command\Course\EditPresentationCourseInfoCommand;
use AppBundle\Form\Course\EditPresentationCourseInfoType;
use AppBundle\Query\Course\EditPresentationCourseInfoQuery;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
     * SavePresentationCourseInfoAction constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param EditPresentationCourseInfoQuery $editPresentationCourseInfoQuery
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(
        FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
        EditPresentationCourseInfoQuery $editPresentationCourseInfoQuery,
        FormFactoryInterface $formFactory
    )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->editPresentationCourseInfoQuery = $editPresentationCourseInfoQuery;
        $this->formFactory = $formFactory;
    }

    /**
     * @Route("/course/presentation/save/{id}", name="save_presentation_course_info")
     */
    public function __invoke(Request $request)
    {
        $id = $request->get('id', null);
        $courseInfo = $this->findCourseInfoByIdQuery->setId($id)->execute();
        $editPresentationCourseInfoCommand = new EditPresentationCourseInfoCommand($courseInfo);
        $form = $this->formFactory->create(EditPresentationCourseInfoType::class, $editPresentationCourseInfoCommand);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $editPresentationCourseInfoCommand = $form->getData();
            $this->editPresentationCourseInfoQuery->setEditPresentationCourseInfoCommand($editPresentationCourseInfoCommand)->execute();
        }
        return new JsonResponse([]);
    }

}