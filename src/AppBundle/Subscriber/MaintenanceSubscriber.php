<?php

namespace AppBundle\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
     * @param bool $inMaintenance
     * @param UrlGeneratorInterface $twigEnvironment
     */
    public function __construct(bool $inMaintenance, Environment $twigEnvironment)
    {
        $this->inMaintenance = $inMaintenance;
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
        $maintenanceRoute = 'app.maintenance.index';

        if ($this->inMaintenance and $event->getRequest()->attributes->get('_route') !== $maintenanceRoute) {

            $content = $this->twigEnvironment->render('maintenance/index.html.twig');
            $event->setResponse(new Response($content));
        }
    }

}

