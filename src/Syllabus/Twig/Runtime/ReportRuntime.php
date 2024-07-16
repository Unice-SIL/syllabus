<?php


namespace App\Syllabus\Twig\Runtime;


use App\Syllabus\Helper\Report\Report;
use Twig\Environment;
use Twig\Extension\RuntimeExtensionInterface;

class ReportRuntime implements RuntimeExtensionInterface
{

    /**
     * @var Environment
     */
    private Environment $twigEnvironment;

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