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

            //Some routes starts by app_admin_course_info but are stored in different tabs in the admin sidebar
            $specialCourseInfoRoutes = ['app_admin_course_info_field_index'];
            if (in_array($this->masterRequest->get('_route'), $specialCourseInfoRoutes)) {
                return $this->masterRequest->get('_route') === $route ? 'active' : null;
            }

            if (strpos($this->masterRequest->get('_route'), $route) !== false) {
                return 'active';
            }

            continue;
        }

        return null;
    }
}