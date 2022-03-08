<?php


namespace App\Syllabus\Twig;


use Symfony\Component\Form\ChoiceList\View\ChoiceView;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\RuntimeExtensionInterface;

class AppRuntime implements RuntimeExtensionInterface
{
    /**
     * @var Request|null
     */
    private $masterRequest;

    /**
     * AppRuntime constructor.
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->masterRequest = $requestStack->getMainRequest();
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
        }

        return null;
    }

    /**
     * @param string $label
     * @param array<ChoiceView> $choices
     * @return int|null
     */
    public function findChoiceIdByLabel(string $label, array $choices): ?int
    {
        /** @var ChoiceView $choice */
        foreach ($choices as $key => $choice)
        {
            if($choice instanceof ChoiceView)
            {
                if($choice->label === $label)
                {
                    return $key;
                }
            }
        }
        return null;
    }

    /**
     * @return string
     */
    public function getMemoryLimit()
    {
        return ini_get('memory_limit');
    }
    
}