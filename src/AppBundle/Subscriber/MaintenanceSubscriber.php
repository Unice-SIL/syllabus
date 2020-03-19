<?php

namespace AppBundle\Subscriber;

use AppBundle\Constant\UserRole;
use Dmishh\SettingsBundle\Manager\SettingsManager;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Twig\Environment;

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
     * @var Security
     */
    private $authorizationChecker;

    /**
     * MaintenanceSubscriber constructor.
     * @param Environment $twigEnvironment
     * @param SettingsManager $settingsManager
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(Environment $twigEnvironment, SettingsManager $settingsManager, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->inMaintenance = $settingsManager->get('in_maintenance');
        $this->twigEnvironment = $twigEnvironment;
        $this->authorizationChecker = $authorizationChecker;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [
                ['diplayMaintenancePage'],
            ],
        ];
    }

    public function diplayMaintenancePage(GetResponseEvent $event)
    {
        if ($this->authorizationChecker->isGranted(UserRole::ROLE_SUPER_ADMIN)) {
            return;
        }
        $exceptionRoutes = ['app.maintenance.index', 'dmishh_settings_manage_global'];

        if ($this->inMaintenance and  !in_array($event->getRequest()->attributes->get('_route'), $exceptionRoutes)) {

            $content = $this->twigEnvironment->render('maintenance/index.html.twig');
            $event->setResponse(new Response($content));
        }
    }

}

