<?php

namespace AppBundle\Action\Ui\Test;

use AppBundle\Action\ActionInterface;
use AppBundle\Command\Course\EditPresentationCourseInfoCommand;
use AppBundle\Form\Course\EditPresentationCourseInfoType;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Class EditCourseAction
 * @package AppBundle\Action\Ui\Course
 */
class EditPresentationCourseInfoTestAction implements ActionInterface
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
     * EditCourseAction constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param FormFactoryInterface $formFactory
     * @param Environment $templating
     */
    public function __construct(
            FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
            FormFactoryInterface $formFactory,
            SessionInterface $session,
            Environment $templating
        )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->formFactory = $formFactory;
        $this->templating = $templating;
        $this->session = $session;
    }

    /**
     * @Route("/test/course/presentation/edit/{id}", name="edit_presentation_course_info_test")
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $id = $request->get('id', null);
        $courseInfo = $this->findCourseInfoByIdQuery->setId($id)->execute();
        $editPresentationCourseInfoCommand = new EditPresentationCourseInfoCommand($courseInfo);
        $form = $this->formFactory->create(EditPresentationCourseInfoType::class, $editPresentationCourseInfoCommand);
        $form->handleRequest($request);

        #$this->session->getFlashBag()->add('danger', "You have reached the moulbification point.");

        return new Response(
            $this->templating->render(
                'course/edit_presentation_course_tab.html.twig',
                [
                    'courseInfo' => $courseInfo,
                    'form' => $form->createView()
                ]
            )
        );
    }
}