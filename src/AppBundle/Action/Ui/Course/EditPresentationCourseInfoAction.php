<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Command\Course\EditPresentationCourseInfoCommand;
use AppBundle\Constant\Permission;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Exception\CoursePermissionDeniedException;
use AppBundle\Form\Course\EditPresentationCourseInfoType;
use AppBundle\Helper\CoursePermissionHelper;
use AppBundle\Helper\FileUploaderHelper;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
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
     * @var CoursePermissionHelper
     */
    private $coursePermissionHelper;

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
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * EditPresentationCourseInfoAction constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param CoursePermissionHelper $coursePermissionHelper
     * @param FormFactoryInterface $formFactory
     * @param TokenStorageInterface $tokenStorage
     * @param Environment $templating
     * @param FileUploaderHelper $fileUploaderHelper
     * @param LoggerInterface $logger
     */
    public function __construct(
        FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
        CoursePermissionHelper $coursePermissionHelper,
        FormFactoryInterface $formFactory,
        TokenStorageInterface $tokenStorage,
        Environment $templating,
        FileUploaderHelper $fileUploaderHelper,
        LoggerInterface $logger
    )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->coursePermissionHelper = $coursePermissionHelper;
        $this->formFactory = $formFactory;
        $this->templating = $templating;
        $this->tokenStorage = $tokenStorage;
        $this->fileUploaderHelper = $fileUploaderHelper;
        $this->logger = $logger;
    }

    /**
     * @Route("/course/presentation/edit/{id}", name="edit_presentation_course_info")
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        try{
            $id = $request->get('id', null);
            try {
                $courseInfo = $this->findCourseInfoByIdQuery->setId($id)->execute();
                if(!$this->coursePermissionHelper->hasPermission($courseInfo, $this->tokenStorage->getToken()->getUser(),Permission::WRITE)){
                    throw new CoursePermissionDeniedException();
                }
            }catch (CoursePermissionDeniedException $e){
                return new JsonResponse([
                    'alert' => [
                        'type' => 'danger',
                        'message' => sprintf("Vous n'avez pas les permissions nécessaires pour éditer ce cours.")
                    ]
                ]);
            }catch (CourseInfoNotFoundException $e){
                return new JsonResponse([
                    'alert' => [
                        'type' => 'danger',
                        'message' => sprintf("Le cours « %s » n'existe pas.", $id)
                    ]
                ]);
            }
            if(!is_null($courseInfo->getImage())) {
                $courseInfo->setImage(new File($this->fileUploaderHelper->getDirectory().'/'.$courseInfo->getImage()));
            }
            $editPresentationCourseInfoCommand = new EditPresentationCourseInfoCommand($courseInfo);
            $form = $this->formFactory->create(EditPresentationCourseInfoType::class, $editPresentationCourseInfoCommand);
            $form->handleRequest($request);

            return new JsonResponse([
                'content' => $this->templating->render(
                    'course/edit_presentation_course_tab.html.twig',
                    [
                        'courseInfo' => $courseInfo,
                        'form' => $form->createView()
                    ]
                )
            ]);
        }catch (\Exception $e){
            $this->logger->error((string)$e);
            return new JsonResponse([
                'alert' => [
                    'type' => 'danger',
                    'message' => "Une erreur est survenue pendant le chargement du formulaire."
                ]
            ]);
        }
    }
}