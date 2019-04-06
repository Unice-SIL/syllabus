<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Command\Course\PublishCourseInfoCommand;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Helper\CourseInfoHelper;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use AppBundle\Query\Course\PublishCourseInfoQuery;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Class PublishCourseInfoAction
 * @package AppBundle\Action\Ui\Course
 */
class PublishCourseInfoAction implements ActionInterface
{
    /**
     * @var FindCourseInfoByIdQuery
     */
    private $findCourseInfoByIdQuery;

    /**
     * @var Environment
     */
    private $templating;

    /**
     * @var CourseInfoHelper
     */
    private $courseInfoHelper;

    /**
     * @var PublishCourseInfoQuery
     */
    private $publishCourseInfoQuery;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * PublishCourseInfoAction constructor.
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param Environment $templating
     * @param CourseInfoHelper $courseInfoHelper
     * @param PublishCourseInfoQuery $publishCourseInfoQuery
     * @param LoggerInterface $logger
     */
    public function __construct(
            FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
            Environment $templating,
            CourseInfoHelper $courseInfoHelper,
            PublishCourseInfoQuery $publishCourseInfoQuery,
            LoggerInterface $logger
        )
    {
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->templating = $templating;
        $this->courseInfoHelper =$courseInfoHelper;
        $this->publishCourseInfoQuery = $publishCourseInfoQuery;
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Route("/course/publish/{id}", name="publish_course_info")
     */
    public function __invoke(Request $request)
    {
        $messages = [];
        $renders = [];
        try {
            $id = $request->get('id', null);
            try{
                $courseInfo = $this->findCourseInfoByIdQuery->setId($id)->execute();
                // Check if course can be published
                if($this->courseInfoHelper->canBePublished($courseInfo)){
                    // Generate command
                    $publishCourseInfoCommand = new PublishCourseInfoCommand($courseInfo);
                    // Set course published
                    $this->publishCourseInfoQuery->setPublishCourseInfoCommand($publishCourseInfoCommand)->execute();
                    // Return message course cannot published
                    $messages[] = [
                        'type' => "success",
                        'message' => sprintf("Le cours a été publié")
                    ];
                    // Get render to reload course info panel
                    $renders[] = [
                        'element' => '#course_info_panel',
                        'content' => $this->templating->render(
                            'course/edit_course_info_panel.html.twig',
                            [
                                'courseInfo' => $courseInfo,
                                'courseInfoHelper' => $this->courseInfoHelper
                            ]
                        )
                    ];
                }else{
                    // Return message course cannot published
                    $messages[] = [
                        'type' => "danger",
                        'message' => sprintf("Le cours ne peut pas être publié")
                    ];
                }
            } catch (CourseInfoNotFoundException $e) {
                // Return message course not found
                $messages[] = [
                    'type' => "danger",
                    'message' => sprintf("Le course n'a pas été retrouvé")
                ];
            }
        }catch (\Exception $e) {
            // Log error
            $this->logger->error((string) $e);
            // Return message error
            $messages[] = [
                'type' => "danger",
                'message' => "Une erreur est survenue"
            ];
        }
        return new JsonResponse(
            [
                'messages' => $messages,
                'renders' => $renders
            ]
        );
    }

}
