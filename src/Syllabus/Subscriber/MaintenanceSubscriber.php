<?php

namespace App\Syllabus\Subscriber;

use App\Syllabus\Constant\UserRole;
use Dmishh\SettingsBundle\Manager\SettingsManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class MaintenanceSubscriber implements EventSubscriberInterface
{
    /**
     * @var bool
     */
    private $inMaintenance;

    /**
     * @var UrlGeneratorInterface
     */
    private $twigEnvironment;
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * @var Security
     */
    private $security;

    /**
     * MaintenanceSubscriber constructor.
     * @param Environment $twigEnvironment
     * @param SettingsManager $settingsManager
     * @param AuthorizationCheckerInterface $authorizationChecker
     * @param Security $security
     */
    public function __construct(Environment $twigEnvironment, SettingsManager $settingsManager, AuthorizationCheckerInterface $authorizationChecker, Security $security)
    {
        $this->inMaintenance = $settingsManager->get('in_maintenance');
        $this->twigEnvironment = $twigEnvironment;
        $this->authorizationChecker = $authorizationChecker;
        $this->security = $security;
    }

    /**
     * @return string[][][]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [
                ['displayMaintenancePage'],
            ],
        ];
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function displayMaintenancePage(RequestEvent $event)
    {
        $user = $this->security->getUser();

        if ($user instanceof UserInterface && $this->authorizationChecker->isGranted(UserRole::ROLE_SUPER_ADMIN) ) {
            return;
        }
        $exceptionRoutes = ['app.maintenance.index', 'dmishh_settings_manage_global'];

        if ($this->inMaintenance and  !in_array($event->getRequest()->attributes->get('_route'), $exceptionRoutes)) {

            $content = $this->twigEnvironment->render('maintenance/index.html.twig');
            $event->setResponse(new Response($content));
        }
    }

}

