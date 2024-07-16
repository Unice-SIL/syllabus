<?php


namespace App\Syllabus\Twig;

use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Twig\Runtime\ReportRuntime;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\Markup;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class AppExtension
 * @package App\Syllabus\Twig
 */
class AppExtension extends AbstractExtension
{
    /**
     * @var TranslatorInterface
     */
    private TranslatorInterface $translator;

    /**
     * @var ValidatorInterface
     *
     */
    private ValidatorInterface $validator;

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
    public function getFilters(): array
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
    public function getFunctions(): array
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
    public function humanizeBoolean($boolean): string
    {
        return $boolean ? $this->translator->trans('yes') : $this->translator->trans('no');
    }

    /**
     * @param $data
     * @param $class
     * @param $prefix
     * @return string|Markup
     */
    public function humanizeEmptyData($data, $class = null, $prefix = null): string|Markup
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
    public function displayValidator(CourseInfo $courseInfo, $group): bool
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
    public function humanizeBytes(int $value): string
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
