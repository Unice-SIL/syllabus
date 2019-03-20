<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Command\Course\EditActivitiesCourseInfoCommand;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Form\Course\EditActivitiesCourseInfoType;
use AppBundle\Query\Activity\FindActivitiesByCriteriaQuery;
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
 * Class EditActivitiesCourseInfoTestAction
 * @package AppBundle\Action\Ui\Test
 */
class EditActivitiesCourseInfoAction implements ActionInterface
{
    /**
     * @var FindCourseInfoByIdQuery
     */
    private $findCourseInfoByIdQuery;

    /**
     * @var FindActivitiesByCriteriaQuery
     */
    private $findActivitiesByCriteriaQuery;

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
     * EditActivitiesCourseInfoAction constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param FindActivitiesByCriteriaQuery $findActivitiesByCriteriaQuery
     * @param FormFactoryInterface $formFactory
     * @param SessionInterface $session
     * @param Environment $templating
     * @param LoggerInterface $logger
     */
    public function __construct(
        FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
        FindActivitiesByCriteriaQuery $findActivitiesByCriteriaQuery,
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
        $this->findActivitiesByCriteriaQuery = $findActivitiesByCriteriaQuery;
    }

    /**
     * @Route("/course/activities/edit/{id}", name="edit_activities_course_info")
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
            $activitiesClass = $this->findActivitiesByCriteriaQuery->execute();
            $activitiesDistant = $this->findActivitiesByCriteriaQuery->setType('activity')->setMode('class')->execute();

            $editActivitiesCourseInfoCommand = new EditActivitiesCourseInfoCommand($courseInfo);
            $form = $this->formFactory->create(EditActivitiesCourseInfoType::class, $editActivitiesCourseInfoCommand);
            $form->handleRequest($request);

            return new JsonResponse([
                'content' => $this->templating->render(
                    'course/edit_activities_course_info_tab.html.twig',
                    [
                        'courseInfo' => $courseInfo,
                        'activitiesClass' => $activitiesClass,
                        'activitiesDistant' => $activitiesDistant,
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
        return new Response("");
    }
}