<?php


namespace AppBundle\Twig;

use AppBundle\Twig\Runtime\ReportRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('humanizeBoolean', [$this, 'humanizeBoolean']),
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('printActiveAdminSidebarLink', [AppRuntime::class, 'printActiveAdminSidebarLink']),
            new TwigFunction('report_render', [ReportRuntime::class, 'reportRender']),
        ];
    }

    public function humanizeBoolean($boolean)
    {
        return $boolean ? 'Oui' : 'Non' ;
    }
}
