<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Command\Course\EditClosingRemarksCourseInfoCommand;
use AppBundle\Command\Course\EditInfosCourseInfoCommand;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Form\Course\EditClosingRemarksCourseInfoType;
use AppBundle\Form\Course\EditInfosCourseInfoType;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Class EditInfosCourseInfoAction
 * @package AppBundle\Action\Ui\Course
 */
class EditInfosCourseInfoAction implements ActionInterface
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
     * @var LoggerInterface
     */
    private $logger;

    /**
     * EditClosingRemarksCourseInfoAction constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param FormFactoryInterface $formFactory
     * @param SessionInterface $session
     * @param Environment $templating
     * @param LoggerInterface $logger
     */
    public function __construct(
        FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
        FormFactoryInterface $formFactory,
        SessionInterface $session,
        Environment $templating,
        LoggerInterface $logger
    )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->formFactory = $formFactory;
        $this->templating = $templating;
        $this->session = $session;
        $this->logger = $logger;
    }

    /**
     * @Route("/course/infos/edit/{id}", name="edit_infos_course_info")
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        try {
            $id = $request->get('id', null);
            try {
                $courseInfo = $this->findCourseInfoByIdQuery->setId($id)->execute();
            } catch (CourseInfoNotFoundException $e) {
                return new JsonResponse([
                    'alert' => [
                        'type' => 'danger',
                        'message' => sprintf("Le cours %s n'existe pas", $id)
                    ]
                ]);
            }
            $editInfosCourseInfoCommand = new EditInfosCourseInfoCommand($courseInfo);
            $form = $this->formFactory->create(EditInfosCourseInfoType::class, $editInfosCourseInfoCommand);
            $form->handleRequest($request);

            return new JsonResponse([
                'content' => $this->templating->render(
                    'course/edit_infos_course_info_tab.html.twig',
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
                    'message' => "Une erreur est survenue pendant le chargement du formulaire"
                ]
            ]);
        }
    }
}