<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Command\Course\EditPresentationCourseInfoCommand;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Form\Course\EditPresentationCourseInfoType;
use AppBundle\Helper\FileUploaderHelper;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Class EditPresentationCourseInfoAction
 * @package AppBundle\Action\Ui\Test
 */
class EditPresentationCourseInfoAction implements ActionInterface
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
     * @var FileUploaderHelper
     */
    private $fileUploaderHelper;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * EditPresentationCourseInfoAction constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param FormFactoryInterface $formFactory
     * @param SessionInterface $session
     * @param Environment $templating
     * @param FileUploaderHelper $fileUploaderHelper
     * @param LoggerInterface $logger
     */
    public function __construct(
        FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
        FormFactoryInterface $formFactory,
        SessionInterface $session,
        Environment $templating,
        FileUploaderHelper $fileUploaderHelper,
        LoggerInterface $logger
    )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->formFactory = $formFactory;
        $this->templating = $templating;
        $this->session = $session;
        $this->fileUploaderHelper = $fileUploaderHelper;
        $this->logger = $logger;
    }

    /**
     * @Route("/course/presentation/edit/{id}", name="edit_presentation_course_info")
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        try{
            $id = $request->get('id', null);
            try {
                $courseInfo = $this->findCourseInfoByIdQuery->setId($id)->execute();
            }catch (CourseInfoNotFoundException $e){
                // TODO
                return new Response("");
            }
            if(!is_null($courseInfo->getImage())) {
                $courseInfo->setImage(new File($this->fileUploaderHelper->getDirectory().'/'.$courseInfo->getImage()));
            }
            $editPresentationCourseInfoCommand = new EditPresentationCourseInfoCommand($courseInfo);
            $form = $this->formFactory->create(EditPresentationCourseInfoType::class, $editPresentationCourseInfoCommand);
            $form->handleRequest($request);

            return new Response(
                $this->templating->render(
                    'course/edit_presentation_course_tab.html.twig',
                    [
                        'courseInfo' => $courseInfo,
                        'form' => $form->createView()
                    ]
                )
            );
        }catch (\Exception $e){
            // TODO
        }
        return new Response("");
    }
}