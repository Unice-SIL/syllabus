<?php

namespace AppBundle\Subscriber;

use Dmishh\SettingsBundle\Manager\SettingsManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
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
     * MaintenanceSubscriber constructor.
     * @param Environment $twigEnvironment
     * @param SettingsManager $settingsManager
     */
    public function __construct(Environment $twigEnvironment, SettingsManager $settingsManager)
    {
        $this->inMaintenance = $settingsManager->get('in_maintenance');
        $this->twigEnvironment = $twigEnvironment;
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
        $exceptionRoutes = ['app.maintenance.index', 'dmishh_settings_manage_global'];

        if ($this->inMaintenance and  !in_array($event->getRequest()->attributes->get('_route'), $exceptionRoutes)) {

            $content = $this->twigEnvironment->render('maintenance/index.html.twig');
            $event->setResponse(new Response($content));
        }
    }

}

