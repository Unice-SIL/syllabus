<?php


namespace AppBundle\Controller;


use AppBundle\Command\Course\EditActivitiesCourseInfoCommand;
use AppBundle\Constant\Permission;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Exception\CoursePermissionDeniedException;
use AppBundle\Form\Course\EditActivitiesCourseInfoType;
use AppBundle\Helper\CoursePermissionHelper;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Twig\Environment;

/**
 * Class CourseInfoContentActivitiesController
 * @package AppBundle\Controller
 *
 */
class CourseInfoContentActivitiesController extends AbstractController
{

    /**
     * @Route("/course/{id}/activities", name="course_info_content_activities")
     * @Security("is_granted('WRITE', courseInfo)")
     *
     * @param string $id
     * @param Request $request
     * @param CoursePermissionHelper $coursePermissionHelper
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param FormFactoryInterface $formFactory
     * @param Environment $templating
     * @param LoggerInterface $logger
     * @param TokenStorageInterface $tokenStorage
     * @return JsonResponse
     */
    public function activitiesCourseInfoAction(string $id,
                                               Request $request,
                                               CoursePermissionHelper $coursePermissionHelper,
                                               FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
                                               FormFactoryInterface $formFactory,
                                               Environment $templating,
                                               LoggerInterface $logger,
                                               TokenStorageInterface $tokenStorage)
    {

        try {

            try {
                $courseInfo = $findCourseInfoByIdQuery->setId($id)->execute();
                if (!$coursePermissionHelper->hasPermission($courseInfo, $tokenStorage->getToken()->getUser(), Permission::WRITE)) {
                    throw new CoursePermissionDeniedException();
                }
            } catch (CoursePermissionDeniedException $e) {
                return new JsonResponse([
                    'alert' => [
                        'type' => 'danger',
                        'message' => "Vous ne disposez pas des permissions nécessaires pour éditer ce syllabus."
                    ]
                ]);
            } catch (CourseInfoNotFoundException $e) {
                return new JsonResponse([
                    'alert' => [
                        'type' => 'danger',
                        'message' => sprintf("Le syllabus « %s » n'existe pas.", $id)
                    ]
                ]);
            }
            $editActivitiesCourseInfoCommand = new EditActivitiesCourseInfoCommand($courseInfo);
            $form = $formFactory->create(EditActivitiesCourseInfoType::class, $editActivitiesCourseInfoCommand);
            $form->handleRequest($request);

            return new JsonResponse([
                'content' => $templating->render(
                    'course/edit_activities_course_info_tab.html.twig',
                    [
                        'courseInfo' => $courseInfo,
                        'form' => $form->createView()
                    ]
                )
            ]);
        } catch (\Exception $e) {
            $logger->error((string)$e);
            return new JsonResponse([
                'alert' => [
                    'type' => 'danger',
                    'message' => "Une erreur est survenue pendant le chargement du formulaire."
                ]
            ]);
        }

    }
}