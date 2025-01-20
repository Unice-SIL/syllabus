<?php


namespace App\Syllabus\Helper;


use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\User;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\File;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class MailHelper
{
    /**
     * @var MailerInterface
     */
    private MailerInterface $mailer;
    /**
     * @var string
     */
    private string $mailerSource;
    /**
     * @var string
     */
    private string $mailerTarget;
    /**
     * @var Environment
     */
    private Environment $twig;
    /**
     * @var UrlGeneratorInterface
     */
    private UrlGeneratorInterface $urlGenerator;

    /**
     * MailHelper constructor.
     * @param Mailer $mailer
     * @param string $mailerSource
     * @param string $mailerTarget
     * @param UrlGeneratorInterface $urlGenerator
     * @param Environment $twig
     */
    public function __construct(MailerInterface $mailer, string $mailerSource, string $mailerTarget, UrlGeneratorInterface $urlGenerator, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->mailerSource = $mailerSource;
        $this->mailerTarget = $mailerTarget;
        $this->twig = $twig;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param User $user
     * @param string $token
     * @return void
     * @throws TransportExceptionInterface
     */
    public function sendResetPasswordMessage(User $user, string $token): void
    {
        $url = $this->urlGenerator->generate('app.security.reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

        $message = (new Email())
            ->from($this->mailerSource)
            ->to($user->getEmail())
            ->subject('Réinitialisation du mot de passe')
            ->bcc($this->mailerTarget)
            ->html("Voici le lien pour changer votre mot de passe : " . $url);
        $this->mailer->send($message);
    }

    /**
     * @param CourseInfo $courseInfo
     * @param User $user
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws TransportExceptionInterface
     */
    public function sendNewSyllabusPublishedMessageToPublisher(CourseInfo  $courseInfo, User $user): void
    {
        $message = (new Email())
            ->from($this->mailerSource)
            ->to($user->getEmail())
            ->subject('Nouveau syllabus publié')
            ->html($this->twig->render('email/publication_publisher.html.twig', [
                    'courseInfo' => $courseInfo
                ]));

        $this->mailer->send($message);
    }

    /**
     * @param CourseInfo $courseInfo
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws TransportExceptionInterface
     */
    public function sendNewSyllabusPublishedMessageToAdmin(CourseInfo  $courseInfo): void
    {
        $message = (new Email())
            ->from($this->mailerSource)
            ->to($this->mailerTarget)
            ->subject('Nouveau syllabus publié')
            ->html($this->twig->render('email/publication_admin.html.twig', [
                    'courseInfo' => $courseInfo
                ]));
        $this->mailer->send($message);
    }

    /**
     * @param string $mailerTarget
     * @param StreamedResponse $report
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws TransportExceptionInterface
     */
    public function sendWeeklyCSVReport(string $mailerTarget, string $filename): void
    {
        $date = date('d/m/Y');
        $content = file_get_contents($filename);
        $dataPart = new DataPart($content, 'Liste_Syllabus_' . $date . '.csv', 'text/csv');
        $message = (new Email())
            ->from($this->mailerSource)
            ->to($mailerTarget)
            ->subject('[Syllabus] Rapport du ' . $date)
            ->addPart($dataPart)
            ->html($this->twig->render('email/weekly_csv_report.html.twig'));
        $this->mailer->send($message);
    }
}