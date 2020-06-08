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
     * @param $courseInfo
     * @param $groupe
     * @return bool
     */
    public function displayValidator($courseInfo, $group)
    {
        $groupTab = ['equipments_empty', 'info_empty', 'closing_remarks_empty', 'evaluation_empty'];
        if (in_array($group, $groupTab)) {
            if ($this->validator->validate($courseInfo, null, [$group])->count() >= 1) {
                return true;
            };
            return false;
        }
        return false;
    }

}
