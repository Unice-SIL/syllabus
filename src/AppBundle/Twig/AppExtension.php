<?php


namespace AppBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('humanizeBoolean', [$this, 'humanizeBoolean']),
        ];
    }

    public function humanizeBoolean($boolean)
    {

        return $boolean ? 'Oui' : 'Non' ;
    }
}
