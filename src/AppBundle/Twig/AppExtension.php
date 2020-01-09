<?php


namespace AppBundle\Twig;

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
        ];
    }

    public function humanizeBoolean($boolean)
    {
        return $boolean ? 'Oui' : 'Non' ;
    }
}
