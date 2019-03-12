<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Command\Course\EditPresentationCourseInfoCommand;
use AppBundle\Form\Course\EditPresentationCourseInfoType;
use AppBundle\Helper\FileUploaderHelper;
use AppBundle\Query\Course\EditPresentationCourseInfoQuery;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\File\File;
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
     * @var FileUploaderHelper
     */
    private $fileUploaderHelper;

    /**
     * SavePresentationCourseInfoAction constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param EditPresentationCourseInfoQuery $editPresentationCourseInfoQuery
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(
        FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
        EditPresentationCourseInfoQuery $editPresentationCourseInfoQuery,
        FormFactoryInterface $formFactory,
        FileUploaderHelper $fileUploaderHelper
    )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->editPresentationCourseInfoQuery = $editPresentationCourseInfoQuery;
        $this->formFactory = $formFactory;
        $this->fileUploaderHelper = $fileUploaderHelper;
    }

    /**
     * @Route("/course/presentation/save/{id}", name="save_presentation_course_info")
     */
    public function __invoke(Request $request)
    {
        $id = $request->get('id', null);
        $courseInfo = $this->findCourseInfoByIdQuery->setId($id)->execute();
        if(!is_null($courseInfo->getImage())) {
            $courseInfo->setImage(new File($this->fileUploaderHelper->getDirectory().'/'.$courseInfo->getImage()));
        }
        $editPresentationCourseInfoCommand = new EditPresentationCourseInfoCommand($courseInfo);
        $form = $this->formFactory->create(EditPresentationCourseInfoType::class, $editPresentationCourseInfoCommand);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $editPresentationCourseInfoCommand = $form->getData();
            // If there is no new image to upload keep the actual image
            if(is_null($editPresentationCourseInfoCommand->getImage())){
                $editPresentationCourseInfoCommand->setImage($courseInfo->getImage());
            }
            $this->editPresentationCourseInfoQuery->setEditPresentationCourseInfoCommand($editPresentationCourseInfoCommand)->execute();
        }
        return new JsonResponse([]);
    }

}