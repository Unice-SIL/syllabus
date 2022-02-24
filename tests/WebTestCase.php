<?php


namespace Tests;

use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\User;
use App\Syllabus\Exception\CourseNotFoundException;
use App\Syllabus\Exception\UserNotFoundException;
use App\Syllabus\Fixture\CourseFixture;
use App\Syllabus\Fixture\UserFixture;
use App\Syllabus\Fixture\YearFixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\Field\ChoiceFormField;
use Symfony\Component\DomCrawler\Form;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Guard\Token\PostAuthenticationGuardToken;
use Symfony\Component\Security\Http\Authenticator\Token\PostAuthenticationToken;

/**
 * Class WebTestCase
 * @package Tests
 */
class WebTestCase extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    public const AUTH_FIREWALL_NAME = 'main';
    public const AUTH_FIREWALL_CONTEXT = 'main';

    public const URL_APP_LOGIN = '/Shibboleth.sso/Login';
    public const ROUTE_APP_LOGIN_BASIC = '/login/basic';
    public const ROUTE_APP_LOGIN_SHIBBOLETH = '/login/shibboleth';
    public const ROUTE_APP_LOGOUT = '/logout';

    public const ROUTE_APP_HOMEPAGE = 'app_index';
    public const ROUTE_APP_ROUTER = 'app_router';
    public const ROUTE_APP_ROUTER_LIGHT = 'app_router_anon';

    /*
     *  Admin
     */

    public const ROUTE_ADMIN_ACTIVITY_LIST = 'app.admin.activity.index';
    public const ROUTE_ADMIN_ACTIVITY_NEW = 'app.admin.activity.new';
    public const ROUTE_ADMIN_ACTIVITY_EDIT = 'app.admin.activity.edit';

    public const ROUTE_ADMIN_ACTIVITY_MODE_LIST = 'app.admin.activity_mode.index';
    public const ROUTE_ADMIN_ACTIVITY_MODE_NEW = 'app.admin.activity_mode.new';
    public const ROUTE_ADMIN_ACTIVITY_MODE_EDIT = 'app.admin.activity_mode.edit';

    public const ROUTE_ADMIN_ACTIVITY_TYPE_LIST = 'app.admin.activity_type.index';
    public const ROUTE_ADMIN_ACTIVITY_TYPE_NEW = 'app.admin.activity_type.new';
    public const ROUTE_ADMIN_ACTIVITY_TYPE_EDIT = 'app.admin.activity_type.edit';

    public const ROUTE_ADMIN_ASK_ADVICE_LIST = 'app.admin.ask_advice.index';

    public const ROUTE_ADMIN_CAMPUS_LIST = 'app.admin.campus.index';
    public const ROUTE_ADMIN_CAMPUS_NEW = 'app.admin.campus.new';
    public const ROUTE_ADMIN_CAMPUS_EDIT = 'app.admin.campus.edit';

    public const ROUTE_ADMIN_COURSE_LIST = 'app.admin.course.index';

    public const ROUTE_ADMIN_COURSE_INFO_LIST = 'app.admin.course_info.index';

    public const ROUTE_ADMIN_COURSE_INFO_FIELD_LIST = 'app.admin.course_info_field.index';

    public const ROUTE_ADMIN_CRITICAL_ACHIEVEMENT_LIST = 'app.admin.critical_achievement.index';
    public const ROUTE_ADMIN_CRITICAL_ACHIEVEMENT_NEW = 'app.admin.critical_achievement.new';
    public const ROUTE_ADMIN_CRITICAL_ACHIEVEMENT_EDIT = 'app.admin.critical_achievement.edit';

    public const ROUTE_ADMIN_DASHBOARD = 'app.admin.dashboard.index';

    public const ROUTE_ADMIN_DOMAIN_LIST = 'app.admin.domain.index';
    public const ROUTE_ADMIN_DOMAIN_NEW = 'app.admin.domain.new';
    public const ROUTE_ADMIN_DOMAIN_EDIT = 'app.admin.domain.edit';

    public const ROUTE_ADMIN_EQUIPMENT_LIST = 'app.admin.equipment.index';
    public const ROUTE_ADMIN_EQUIPMENT_NEW = 'app.admin.equipment.new';
    public const ROUTE_ADMIN_EQUIPMENT_EDIT = 'app.admin.equipment.edit';

    public const ROUTE_ADMIN_GROUPS_LIST = 'app.admin.groups.index';
    public const ROUTE_ADMIN_GROUPS_NEW = 'app.admin.groups.new';
    public const ROUTE_ADMIN_GROUPS_EDIT = 'app.admin.groups.edit';
    public const ROUTE_ADMIN_GROUPS_DELETE = 'app.admin.groups.delete';

    public const ROUTE_ADMIN_IMPORT_COURSE_INFO = 'app.admin.import_csv.course_info';
    public const ROUTE_ADMIN_IMPORT_PERMISSION = 'app.admin.import_csv.permission';

    public const ROUTE_ADMIN_IMPORT_USER = 'app.admin.import_csv.user';

    public const ROUTE_ADMIN_JOB_LIST = 'app.admin.job.index';

    public const ROUTE_ADMIN_LANGUAGE_LIST = 'app.admin.language.index';
    public const ROUTE_ADMIN_LANGUAGE_NEW = 'app.admin.language.new';
    public const ROUTE_ADMIN_LANGUAGE_EDIT = 'app.admin.language.edit';

    public const ROUTE_ADMIN_LEVEL_LIST = 'app.admin.level.index';
    public const ROUTE_ADMIN_LEVEL_NEW = 'app.admin.level.new';
    public const ROUTE_ADMIN_LEVEL_EDIT = 'app.admin.level.edit';

    public const ROUTE_ADMIN_NOTIFICATION_LIST = 'app.admin.notification.index';

    public const ROUTE_ADMIN_PERIOD_LIST = 'app.admin.period.index';
    public const ROUTE_ADMIN_PERIOD_NEW = 'app.admin.period.new';
    public const ROUTE_ADMIN_PERIOD_EDIT = 'app.admin.period.edit';

    public const ROUTE_ADMIN_STRUCTURE_LIST = 'app.admin.structure.index';
    public const ROUTE_ADMIN_STRUCTURE_NEW = 'app.admin.structure.new';
    public const ROUTE_ADMIN_STRUCTURE_EDIT = 'app.admin.structure.edit';

    public const ROUTE_ADMIN_SYLLABUS_LIST = 'app.admin.syllabus.index';

    public const ROUTE_ADMIN_USER_LIST = 'app.admin.user.index';

    public const ROUTE_ADMIN_YEAR_LIST = 'app.admin.year.index';
    public const ROUTE_ADMIN_YEAR_NEW = 'app.admin.year.new';
    public const ROUTE_ADMIN_YEAR_EDIT = 'app.admin.year.edit';

    /*
     *  Course Info
     */
    public const ROUTE_APP_COURSE_ACHIEVEMENT_EDIT = 'app.course_info.achievement.edit';
    public const ROUTE_APP_COURSE_ACHIEVEMENT_DELETE = 'app.course_info.achievement.delete';

    public const ROUTE_APP_COURSE_INFO_DASHBOARD = 'app.course_info.dashboard.index';

    public const ROUTE_APP_COURSE_STUDENT_VIEW = 'app.course_info.view.student';

    public const ROUTE_APP_COURSE_LIGHT_VIEW = 'app.course_info.view.light_version';

    public const ROUTE_APP_ACTIVITIES_INDEX = 'app.course_info.activities.index';
    public const ROUTE_APP_ACTIVITIES_ADD_SECTION = 'app.course_info.activities.section.add';
    public const ROUTE_APP_ACTIVITIES_DUPLICATE_SECTION = 'app.course_info.activities.section.duplicate';
    public const ROUTE_APP_ACTIVITIES_SORT_SECTION = 'app.course_info.activities.sections.sort';

    public const ROUTE_APP_CLOSING_REMARKS_INDEX = 'app.course_info.closing_remarks.index';

    public const ROUTE_APP_COURSE_PERMISSION_INDEX = 'app.course_info.permission.index';

    public const ROUTE_APP_COURSE_PREREQUISITE_INDEX = 'app.course_info.prerequisite.index';
    public const ROUTE_APP_COURSE_PREREQUISITE_ADD = 'app.course_info.prerequisite.add';
    public const ROUTE_APP_COURSE_PREREQUISITE_EDIT = 'app.course_info.prerequisite.edit';
    public const ROUTE_APP_COURSE_PREREQUISITE_DELETE = 'app.course_info.prerequisite.delete';

    public const ROUTE_APP_COURSE_SECTION_EDIT = 'app.course_info.section.edit';
    public const ROUTE_APP_COURSE_SECTION_DELETE = 'app.course_info.section.delete';
    public const ROUTE_APP_COURSE_SECTION_ACTIVITY_ADD = 'app.course_info.section.activity.add';
    public const ROUTE_APP_COURSE_SECTION_ACTIVITIES_SORT = 'app.course_info.section.activities.sort';

    public const ROUTE_APP_COURSE_SECTION_ACTIVITY_EDIT = 'app.course_info.section_activity.edit';
    public const ROUTE_APP_COURSE_SECTION_ACTIVITY_DELETE = 'app.course_info.section_activity.delete';

    public const ROUTE_APP_DASHBOARD_INDEX = 'app.course_info.dashboard.index';

    public const ROUTE_APP_EQUIPMENT_EDIT = 'app.course_info.equipment.edit';
    public const ROUTE_APP_EQUIPMENT_DELETE = 'app.course_info.equipment.delete';

    public const ROUTE_APP_EVALUATION_INDEX = 'app.course_info.evaluation.index';
    public const ROUTE_APP_EVALUATION_SPECIFICATIONS_EDIT = 'app.course_info.evaluation.specifications.edit';

    public const ROUTE_APP_INFO_INDEX = 'app.course_info.info.index';

    public const ROUTE_APP_LEARNING_ACHIEVEMENT_EDIT = 'app.course_info.equipment.edit';
    public const ROUTE_APP_LEARNING_ACHIEVEMENT_DELETE = 'app.course_info.equipment.delete';

    public const ROUTE_APP_OBJECTIVES_INDEX = 'app.course_info.objectives.index';
    public const ROUTE_APP_OBJECTIVES_ADD_ACHIEVEMENT = 'app.course_info.objectives.achievement.add';

    public const ROUTE_APP_PRESENTATION_INDEX = 'app.course_info.presentation.index';

    public const ROUTE_APP_RESOURCE_EQUIPMENT_INDEX = 'app.course_info.resource_equipment.index';

    public const ROUTE_APP_COURSE_TEACHER_EDIT = 'app.course_info.teacher.edit';
    public const ROUTE_APP_COURSE_TEACHER_DELETE = 'app.course_info.teacher.delete';

    public const ROUTE_APP_COURSE_TUTORING_CREATE = 'app.course_info.tutoring.create';
    public const ROUTE_APP_COURSE_TUTORING_ACTIVE = 'app.course_info.tutoring.active';

    public const ROUTE_APP_COURSE_TUTORING_RESOURCE_EDIT = 'app.course_info.tutoring_resource.edit';
    public const ROUTE_APP_COURSE_TUTORING_RESOURCE_DELETE = 'app.course_info.tutoring_resource.delete';

    public const ROUTE_APP_MAINTENANCE = 'app.maintenance.index';

    public const DEFAULT_USER_USERNAME = 'user1';
    public const COURSE_ALLOWED_CODE = CourseFixture::COURSE_2;
    public const COURSE_ALLOWED_YEAR = YearFixture::YEAR_2018;
    public const COURSE_NOT_ALLOWED_CODE = CourseFixture::COURSE_3;
    public const COURSE_NOT_ALLOWED_YEAR = YearFixture::YEAR_2018;

    /**
     * @var KernelBrowser|null
     */
    private $client = null;

    /**
     * @var User|null
     */
    private $user = null;

    /**
     * @return KernelBrowser|null
     */
    public function client()
    {
        if ($this->client === null) {
            self::ensureKernelShutdown();
            $this->client = self::createClient();
        }

        return $this->client;
    }

    /**
     * @param string|null $name
     * @return ObjectManager
     */
    protected function getEntityManager(string $name = null): ObjectManager
    {
        return $this->client()->getContainer()->get('doctrine')->getManager($name);
    }

    /**
     * @param string $route
     * @param array $parameters
     * @return mixed
     */
    protected function generateUrl(string $route, array $parameters = [])
    {
        return $this->client()->getContainer()->get('router')->generate($route, $parameters);
    }

    /**
     * @param string $username
     * @param bool $refresh
     * @return User
     * @throws UserNotFoundException
     */
    public function getUser(string $username = UserFixture::USER_1, bool $refresh = false): User
    {
        if (!$this->user instanceof User || $this->user->getUsername() !== $username || !$refresh) {
            $this->user = $this->getEntityManager()->getRepository(User::class)->findOneBy(['username' => $username]);
        }

        if (!$this->user instanceof User) {
            throw new UserNotFoundException();
        }

        return $this->user;
    }

    /**
     * @param string $code
     * @param string $year
     * @return CourseInfo
     * @throws CourseNotFoundException
     */
    public function getCourse(string $code = self::COURSE_ALLOWED_CODE, string $year = self::COURSE_ALLOWED_YEAR): CourseInfo
    {
        $course = $this->getEntityManager()->getRepository(CourseInfo::class)->findByCodeAndYear($code, $year);

        if (!$course instanceof CourseInfo) {
            throw new CourseNotFoundException();
        }

        return $course;
    }

    /**
     * @param string $username
     * @return User
     * @throws UserNotFoundException
     */
    public function refreshUser(string $username = self::DEFAULT_USER_USERNAME): User
    {
        return $this->getUser($username, true);
    }

    /**
     * @param User|string|null $user
     * @throws UserNotFoundException
     */
    public function login($user = UserFixture::USER_1)
    {
        if ($user instanceof User) {
            $user = $user->getUsername();
        }

        $user = $this->getUser($user);

        $token = new PostAuthenticationToken($user, self::AUTH_FIREWALL_NAME, $user->getRoles());

        $session = $this->client()->getContainer()->get('session');
        $session->set('_security_' . self::AUTH_FIREWALL_CONTEXT, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    /**
     * @param string|null $type
     * @return array
     */
    public function getFlashMessagesInSession(string $type = null): array
    {
        /** @var SessionInterface $session */
        $session = $this->client->getContainer()->get('session');
        return $type ? $session->getFlashBag()->get($type) : $session->getFlashBag()->all();
    }

/*    public function submitForm(Crawler $node, string $formName = null, array $data = []): ?Crawler
    {
        $form = $node->form();
        foreach ($data as $field => $value) {
            $fieldName = $formName ? $formName . '[' . $field . ']' : $field;
            if ($form[$fieldName] instanceof ChoiceFormField)
            {
                $form[$fieldName]->disableValidation();
            }
            $form[$fieldName]->setValue($value);
        }
        return $this->client()->submit($form);
    }*/

    /**
     * @param Crawler $node
     * @param string|null $formName
     * @param array $data
     * @param array $options
     * @return Crawler|null
     */
    public function submitForm(Crawler $node, string $formName = null, array $data = [], array $options = []): ?Crawler
    {
        $form = $node->form();

        $this->populateFormFields($form, $data, $options);
        return $this->client()->submit($form);
    }

    /**
     * @param Form $form
     * @param array $data
     * @param array $options
     * @return Form
     */
    protected function populateFormFields(Form $form, array $data = [], array $options = []): Form
    {
        $formName = $form->getName();
        foreach ($data as $field => $value) {
            if (preg_match('/^\[.*\]$/' ,$field) !== 1) {
                $field = '[' . $field . ']';
            }
            $fieldName = $formName ? $formName . $field : $field;
            if (array_key_exists('disable_validation', $options)) {
                $this->disableValidationField($form[$fieldName], $field, $options['disable_validation']);
            }
            if (is_array($form[$fieldName])) {
                $this->handleCompoundField($form[$fieldName], $value);
            } else {
                $form[$fieldName] = $value;
            }
        }
        return $form;
    }

    /**
     * @param $formField
     * @param $field
     * @param $disableValidation
     */
    protected function disableValidationField($formField, $field, $disableValidation)
    {
        $disableValidation = is_array($disableValidation) ? $disableValidation : [$disableValidation];
        if (in_array($field, $disableValidation)) {
            $formField->disableValidation()->setValue(1);
        }
    }

    /**
     * @param array $fields
     * @param $value
     */
    protected function handleCompoundField(array $fields, $value)
    {
        foreach ($fields as $field) {
            switch ($field->getType()) {
                case 'checkbox':
                    $this->handleCheckboxField($field, $value);
            }
        }
    }

    /**
     * @param ChoiceFormField $field
     * @param $value
     */
    private function handleCheckboxField(ChoiceFormField $field, $value)
    {
        $value = is_array($value) ? $value : [$value];
        $fieldValue = $field->availableOptionValues()[0];
        if (in_array($fieldValue, $value)) {
            $field->tick();
        }
    }

    public function assertCheckEntityProps($entity, array $data, array $callables = [])
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        foreach ($data as $field => $value) {
            if ($field !== '_token') {
                if (array_key_exists($field, $callables)) {
                    $callables[$field]($entity, $value);
                } else {
                    $this->assertSame($value, $propertyAccessor->getValue($entity, $field));
                }
            }
        }
    }

    public function assertCheckNotSameEntityProps($entity, array $data, array $callables = [])
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        foreach ($data as $field => $value) {
            if ($field !== '_token') {
                if (array_key_exists($field, $callables)) {
                    $callables[$field]($entity, $value);
                } else {
                    $this->assertNotSame($value, $propertyAccessor->getValue($entity, $field));
                }
            }
        }
    }

    /**
     * @param Crawler $crawler
     * @param string $field
     * @param string $tagName
     */
    public function assertInvalidFormField(Crawler $crawler, string $field, $tagName = "input")
    {
        $this->assertEquals(1, $crawler->filter($tagName . '[name="' . $field . '"].is-invalid')->count());
    }

    public function assertRedirectToLogin()
    {
        $this->assertResponseRedirects();
        $this->assertStringContainsString(self::URL_APP_LOGIN, $this->client()->getResponse()->getContent());
    }

    /**
     * @param $id
     * @param $token
     * @return string
     */
    protected function setCsrfToken($id, $token)
    {
        $session = $this->client()->getContainer()->get('session');
        $session->set('_csrf/' . $id, $token);
        $session->save();

        return $token;
    }

    /**
     * @param string $tokenName
     * @return mixed
     */
    public function getCsrfToken(string $tokenName)
    {
        $session = $this->client()->getContainer()->get('session');
        return $session->get('_csrf/' . $tokenName);
    }
}