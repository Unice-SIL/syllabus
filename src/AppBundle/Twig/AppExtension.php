<?php


namespace AppBundle\Twig;

use AppBundle\Twig\Runtime\ReportRuntime;
use Twig\Extension\AbstractExtension;
use Twig\Markup;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class AppExtension
 * @package AppBundle\Twig
 */
class AppExtension extends AbstractExtension
{
    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new TwigFilter('humanizeBoolean', [$this, 'humanizeBoolean']),
            new TwigFilter('humanizeEmptyData', [$this, 'humanizeEmptyData']),
        ];
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('printActiveAdminSidebarLink', [AppRuntime::class, 'printActiveAdminSidebarLink']),
            new TwigFunction('findChoiceIdByLabel', [AppRuntime::class, 'findChoiceIdByLabel']),
            new TwigFunction('report_render', [ReportRuntime::class, 'reportRender']),
        ];
    }

    /**
     * @param $boolean
     * @return string
     */
    public function humanizeBoolean($boolean)
    {
        return $boolean ? 'Oui' : 'Non' ;
    }

    /**
     * @param $data
     * @param null $class
     * @return string
     */
    public function humanizeEmptyData($data, $class = null)
    {
        $class = $class ?? 'empty-data';
        return $data ?? new Markup('<span class="'. $class .'">Information non renseignée.</span>', 'UTF-8');
    }



}
