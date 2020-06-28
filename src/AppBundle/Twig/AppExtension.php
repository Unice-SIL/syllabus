<?php


namespace AppBundle\Twig;

use AppBundle\Entity\CourseInfo;
use AppBundle\Twig\Runtime\LanguageRuntime;
use AppBundle\Twig\Runtime\ReportRuntime;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
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
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var ValidatorInterface
     *
     */
    private $validator;

    /**
     * AppExtension constructor.
     * @param TranslatorInterface $translator
     * @param ValidatorInterface $validator
     */
    public function __construct(TranslatorInterface $translator, ValidatorInterface $validator)
    {
        $this->translator = $translator;
        $this->validator = $validator;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new TwigFilter('humanizeBoolean', [$this, 'humanizeBoolean']),
            new TwigFilter('humanizeEmptyData', [$this, 'humanizeEmptyData']),
            new TwigFilter('displayValidator', [$this, 'displayValidator']),
            new TwigFilter('humanizeBytes', [$this, 'humanizeBytes']),
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
            new TwigFunction('getMemoryLimit', [AppRuntime::class, 'getMemoryLimit']),
            new TwigFunction('report_render', [ReportRuntime::class, 'reportRender']),
        ];
    }

    /**
     * @param $boolean
     * @return string
     */
    public function humanizeBoolean($boolean)
    {
        return $boolean ? $this->translator->trans('yes') : $this->translator->trans('no');
    }

    /**
     * @param $data
     * @param null $class
     * @param null $prefix
     * @return string
     */
    public function humanizeEmptyData($data, $class = null, $prefix = null)
    {
        $class = empty($class) ? 'empty-data' : $class;
        return empty($data) ? new Markup('<span class="' . $class . '">' . $this->translator->trans('empty_data') . '</span>',
            'UTF-8') : $this->translator->trans($prefix . $data);
    }

    /**
     * @param CourseInfo $courseInfo
     * @param $group
     * @return bool
     */
    public function displayValidator(CourseInfo $courseInfo, $group)
    {
        $groupTab = ['equipments_empty', 'info_empty', 'closing_remarks_empty', 'evaluation_empty'];
        return (
            in_array($group, $groupTab) &&
            $this->validator->validate($courseInfo, null, [$group])->count() >= 1
        );
    }

    /**
     * @param int $value
     * @return string
     */
    public function humanizeBytes(int $value)
    {
        $sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = 1;
        while ($value/pow(1024, $i) >= 1)
        {
            $i++;
        }
        $i--;
        return round($value/pow(1024, $i), 2).$sizes[$i];
    }

}
