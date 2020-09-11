<?php


namespace AppBundle\Helper;


use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\User;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class MailHelper
{
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
     * @var Environment
     */
    private $twig;
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * MailHelper constructor.
     * @param \Swift_Mailer $mailer
     * @param string $mailerSource
     * @param string $mailerTarget
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(\Swift_Mailer $mailer, string $mailerSource, string $mailerTarget, UrlGeneratorInterface $urlGenerator, Environment $twig)
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

        $message = (new \Swift_Message('Réinitialisation du mot de passe'))
            ->setFrom($this->mailerSource)
            ->setTo($user->getEmail())
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
     */
    public function sendNewSyllabusPublishedMessage(CourseInfo  $courseInfo, User $user)
    {
        $message = (new \Swift_Message('Nouveau syllabus publié'))
            ->setFrom($this->mailerSource)
            ->setTo($this->mailerTarget)
            ->setBody(
                $this->twig->render('email/publication.html.twig', [
                    'courseInfo' => $courseInfo
                ]),
                'text/html'
            );

        return $this->mailer->send($message);
    }
}