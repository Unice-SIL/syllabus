<?php


namespace AppBundle\Helper;


use AppBundle\Entity\User;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * MailHelper constructor.
     * @param \Swift_Mailer $mailer
     * @param string $mailerSource
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(\Swift_Mailer $mailer, string $mailerSource, UrlGeneratorInterface $urlGenerator)
    {
        $this->mailer = $mailer;
        $this->mailerSource = $mailerSource;
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

        $this->mailer->send($message);
    }
}