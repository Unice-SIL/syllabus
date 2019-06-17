<?php

namespace AppBundle\Action\Ui\Course;

use AppBundle\Action\ActionInterface;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Twig\Environment;

/**
 * Class PublishCourseInfoAction
 * @package AppBundle\Action\Ui\Course
 */
class AskForAdviceCourseInfoAction implements ActionInterface
{
    /**
     * @var FindCourseInfoByIdQuery
     */
    private $findCourseInfoByIdQuery;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var Environment
     */
    private $templating;

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var string
     */
    private $mailerSource;

    /**
     * @var string
     */
    private $mailerTarget;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * AskForAdviceCourseInfoAction constructor.
     * @param string $mailerSource
     * @param string $mailerTarget
     * @param FindCourseInfoByIdQuery $findCourseInfoByIdQuery
     * @param TokenStorageInterface $tokenStorage
     * @param Environment $templating
     * @param \Swift_Mailer $mailer
     * @param LoggerInterface $logger
     */
    public function __construct(
            string $mailerSource,
            string $mailerTarget,
            FindCourseInfoByIdQuery $findCourseInfoByIdQuery,
            TokenStorageInterface $tokenStorage,
            Environment $templating,
            \Swift_Mailer $mailer,
            LoggerInterface $logger
        )
    {
        $this->mailerSource = $mailerSource;
        $this->mailerTarget = $mailerTarget;
        $this->findCourseInfoByIdQuery = $findCourseInfoByIdQuery;
        $this->tokenStorage = $tokenStorage;
        $this->templating = $templating;
        $this->mailer = $mailer;
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Route("/course/ask4advice/{id}", name="ask_for_advice_course_info")
     */
    public function __invoke(Request $request)
    {
        $messages = [];
        $renders = [];

        try {

            $id = $request->get('id', null);

            try {

                $courseInfo = $this->findCourseInfoByIdQuery->setId($id)->execute();

                $message = (new \Swift_Message("[SYLLABUS] Demande d'avis."))
                    ->setFrom($this->mailerSource)
                    ->setTo($this->mailerTarget)
                    ->setReplyTo($this->tokenStorage->getToken()->getUser()->getEmail())
                    ->setBody(
                        $this->templating->render(
                            'email/advice.html.twig',
                            [
                                'courseInfo' => $courseInfo,
                                'user' => $this->tokenStorage->getToken()->getUser(),
                            ]
                        ),
                        'text/html'
                    )
                    ->addPart(
                        $this->templating->render(
                            'email/advice.txt.twig',
                            [
                                'courseInfo' => $courseInfo,
                                'user' => $this->tokenStorage->getToken()->getUser(),
                            ]
                        ),
                        'text/plain'
                    );

                $this->mailer->send($message);

                $messages[] = [
                    'type' => "success",
                    'message' => "L'avis a été demandé : vous allez être contacté bientôt."
                ];

            } catch (\Exception $e) {
                $this->logger->error((string) $e);
                $messages[] = [
                    'type' => "danger",
                    'message' => "Une erreur est survenue : l'avis n'a pas été demandé."
                ];
            }

        } catch (CourseInfoNotFoundException $e) {

            $messages[] = [
                'type' => "danger",
                'message' =>"Le cours n'a pas été retrouvé."
            ];
        }

        return new JsonResponse(['messages' => $messages]);
    }

}
