<?php


namespace AppBundle\Twig;


use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\RuntimeExtensionInterface;

class AppRuntime implements RuntimeExtensionInterface
{
    /**
     * @var RequestStack
     */
    private $requestStack;
    /**
     * @var \Symfony\Component\HttpFoundation\Request|null
     */
    private $masterRequest;

    /**
     * AppRuntime constructor.
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->masterRequest = $requestStack->getMasterRequest();
    }

    public function printActiveAdminSidebarLink(array $routes, array $options = [])
    {

        foreach ($routes as $route) {

            if (strpos($route, 'app_admin_activity') !== false) {
                if (array_key_exists('activityType', $options)) {
                    if (in_array($this->masterRequest->attributes->get('type'), $options['activityType'])) {
                        return 'active';
                    }

                    return null;
                }

                if (strpos($this->masterRequest->get('_route'), $route) !== false) {
                    return 'active';
                }

                continue;

            }

            if (strpos($this->masterRequest->get('_route'), $route) !== false) {
                return 'active';
            }

            continue;
        }

        return null;
    }
}