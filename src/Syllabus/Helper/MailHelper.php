<?php


namespace App\Syllabus\Helper;


use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\User;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class MailHelper
{
    /**
     * @var Swift_Mailer
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
     * @var Environment
     */
    private $twig;
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * MailHelper constructor.
     * @param Swift_Mailer $mailer
     * @param string $mailerSource
     * @param string $mailerTarget
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(Swift_Mailer $mailer, string $mailerSource, string $mailerTarget, UrlGeneratorInterface $urlGenerator, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->mailerSource = $mailerSource;
        $this->mailerTarget = $mailerTarget;
        $this->twig = $twig;
        $this->urlGenerator = $urlGenerator;
    }

    public function sendResetPasswordMessage(User $user, string $token)
    {
        $url = $this->urlGenerator->generate('app.security.reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

        $message = (new Swift_Message('Réinitialisation du mot de passe'))
            ->setFrom($this->mailerSource)
            ->setTo($user->getEmail())
            ->setBcc($this->mailerTarget)
            ->setBody(
                "Voici le lien pour changer votre mot de passe : " . $url,
                'text/html'
            );

        return $this->mailer->send($message);
    }

    /**
     * @param CourseInfo $courseInfo
     * @param User $user
     * @return int
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function sendNewSyllabusPublishedMessageToPublisher(CourseInfo  $courseInfo, User $user): int
    {
        $message = (new Swift_Message('Nouveau syllabus publié'))
            ->setFrom($this->mailerSource)
            ->setTo($user->getEmail())
            ->setBody(
                $this->twig->render('email/publication_publisher.html.twig', [
                    'courseInfo' => $courseInfo
                ]),
                'text/html'
            );

        return $this->mailer->send($message);
    }

    /**
     * @param CourseInfo $courseInfo
     * @return int
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function sendNewSyllabusPublishedMessageToAdmin(CourseInfo  $courseInfo): int
    {
        $message = (new Swift_Message('Nouveau syllabus publié'))
            ->setFrom($this->mailerSource)
            ->setTo($this->mailerTarget)
            ->setBody(
                $this->twig->render('email/publication_admin.html.twig', [
                    'courseInfo' => $courseInfo
                ]),
                'text/html'
            );

        return $this->mailer->send($message);
    }
}