<?php


namespace AppBundle\Twig\Runtime;


use AppBundle\Helper\Report\Report;
use Twig\Environment;
use Twig\Extension\RuntimeExtensionInterface;

class ReportRuntime implements RuntimeExtensionInterface
{

    /**
     * @var EngineInterface
     */
    private $twigEnvironment;

    /**
     * ReportRuntime constructor.
     * @param Environment $twigEnvironment
     */
    public function __construct(Environment $twigEnvironment)
    {
        $this->twigEnvironment = $twigEnvironment;
    }

    public function reportRender(?Report $report, array $options = [])
    {
        $defaultOptions = [
            'template' => 'partial/default_report.html.twig',
        ];


        $options = array_merge($defaultOptions, $options);

        return $this->twigEnvironment->display($options['template'], ['report' => $report]);
    }
}