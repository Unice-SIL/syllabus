<?php


namespace Tests;

use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\User;
use App\Syllabus\Exception\CourseNotFoundException;
use App\Syllabus\Fixture\CourseFixture;
use App\Syllabus\Fixture\YearFixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Guard\Token\PostAuthenticationGuardToken;

/**
 * Class WebTestCase
 * @package Tests
 */
class WebTestCase extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    public const AUTH_FIREWALL_NAME                                 = 'main';
    public const AUTH_FIREWALL_CONTEXT                              = 'main';

    public const ROUTE_APP_LOGIN                                    = '/login';
    public const ROUTE_APP_LOGIN_BASIC                              = '/login/basic';
    public const ROUTE_APP_LOGIN_SHIBBOLETH                         = '/login/shibboleth';
    public const ROUTE_APP_LOGOUT                                   = '/logout';

    public const ROUTE_APP_HOMEPAGE                                 = 'app_index';
    public const ROUTE_APP_ROUTER                                   = 'app_router';
    public const ROUTE_APP_ROUTER_LIGHT                             = 'app_router_anon';

    public const ROUTE_ADMIN_ACTIVITY_LIST                          = 'app.admin.activity.index';
    public const ROUTE_ADMIN_ACTIVITY_NEW                           = 'app.admin.activity.new';
    public const ROUTE_ADMIN_ACTIVITY_EDIT                          = 'app.admin.activity.edit';
    public const ROUTE_ADMIN_ACTIVITY_MODE_LIST                     = 'app.admin.activity_mode.index';
    public const ROUTE_ADMIN_ACTIVITY_TYPE_LIST                     = 'app.admin.activity_type.index';
    public const ROUTE_ADMIN_ASK_ADVICE_LIST                        = 'app.admin.ask_advice.index';
    public const ROUTE_ADMIN_CAMPUS_LIST                            = 'app.admin.campus.index';
    public const ROUTE_ADMIN_COURSE_LIST                            = 'app.admin.course.index';
    public const ROUTE_ADMIN_COURSE_INFO_LIST                       = 'app.admin.course_info.index';
    public const ROUTE_ADMIN_COURSE_INFO_FIELD_LIST                 = 'app.admin.course_info_field.index';
    public const ROUTE_ADMIN_CRITICAL_ACHIEVEMENT_LIST              = 'app.admin.critical_achievement.index';
    public const ROUTE_ADMIN_DASHBOARD                              = 'app.admin.dashboard.index';
    public const ROUTE_ADMIN_DOMAIN_LIST                            = 'app.admin.domain.index';
    public const ROUTE_ADMIN_EQUIPMENT_LIST                         = 'app.admin.equipment.index';
    public const ROUTE_ADMIN_GROUPS_LIST                            = 'app.admin.groups.index';
    public const ROUTE_ADMIN_IMPORT_COURSE_INFO                     = 'app.admin.import_csv.course_info';
    public const ROUTE_ADMIN_IMPORT_PERMISSION                      = 'app.admin.import_csv.permission';
    public const ROUTE_ADMIN_IMPORT_USER                            = 'app.admin.import_csv.user';
    public const ROUTE_ADMIN_JOB_LIST                               = 'app.admin.job.index';
    public const ROUTE_ADMIN_LANGUAGE_LIST                          = 'app.admin.language.index';
    public const ROUTE_ADMIN_LEVEL_LIST                             = 'app.admin.level.index';
    public const ROUTE_ADMIN_NOTIFICATION_LIST                      = 'app.admin.notification.index';
    public const ROUTE_ADMIN_PERIOD_LIST                            = 'app.admin.period.index';
    public const ROUTE_ADMIN_STRUCTURE_LIST                         = 'app.admin.structure.index';
    public const ROUTE_ADMIN_SYLLABUS_LIST                          = 'app.admin.syllabus.index';
    public const ROUTE_ADMIN_USER_LIST                              = 'app.admin.user.index';
    public const ROUTE_ADMIN_YEAR_LIST                              = 'app.admin.year.index';

    public const ROUTE_APP_COURSE_INFO_DASHBOARD                    = 'app.course_info.dashboard.index';
    public const ROUTE_APP_COURSE_STUDENT_VIEW                      = 'app.course_info.view.student';
    public const ROUTE_APP_COURSE_LIGHT_VIEW                        = 'app.course_info.view.light_version';
    public const ROUTE_APP_ACTIVITIES_INDEX                         = 'app.course_info.activities.index';
    public const ROUTE_APP_CLOSING_REMARKS_INDEX                    = 'app.course_info.closing_remarks.index';
    public const ROUTE_APP_COURSE_PERMISSION_INDEX                  = 'app.course_info.permission.index';
    public const ROUTE_APP_COURSE_PREREQUISITE_INDEX                = 'app.course_info.prerequisite.index';
    public const ROUTE_APP_DASHBOARD_INDEX                          = 'app.course_info.dashboard.index';
    public const ROUTE_APP_EVALUATION_INDEX                         = 'app.course_info.evaluation.index';
    public const ROUTE_APP_INFO_INDEX                               = 'app.course_info.info.index';
    public const ROUTE_APP_OBJECTIVES_INDEX                         = 'app.course_info.objectives.index';
    public const ROUTE_APP_PRESENTATION_INDEX                       = 'app.course_info.presentation.index';
    public const ROUTE_APP_RESOURCE_EQUIPMENT_INDEX                 = 'app.course_info.resource_equipment.index';

    public const ROUTE_APP_MAINTENANCE                              = 'app.maintenance.index';

    public const DEFAULT_USER_USERNAME                              = 'user1';
    public const COURSE_ALLOWED_CODE                                = CourseFixture::COURSE_2;
    public const COURSE_ALLOWED_YEAR                                = YearFixture::YEAR_2018;
    public const COURSE_NOT_ALLOWED_CODE                            = CourseFixture::COURSE_3;
    public const COURSE_NOT_ALLOWED_YEAR                            = YearFixture::YEAR_2018;

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
     */
    public function getUser($username = self::DEFAULT_USER_USERNAME, bool $refresh = false): User
    {
        if (!$this->user instanceof User || $this->user->getUsername() !== $username || !$refresh) {
            $this->user = $this->getEntityManager()->getRepository(User::class)->findOneBy(['username' => $username]);
        }

        if (!$this->user instanceof User) {
            throw new UsernameNotFoundException();
        }

        return $this->user;
    }

    /**
     * @param $code
     * @param $year
     * @return CourseInfo
     * @throws CourseNotFoundException
     */
    public function getCourse($code, $year)
    {
        $course = null;
        if (!$course instanceof CourseInfo)
        {
            $course = $this->getEntityManager()->getRepository(CourseInfo::class)->findByCodeAndYear($code, $year);
        }

        if (!$course instanceof CourseInfo)
        {
            throw new CourseNotFoundException();
        }

        return $course;
    }

    /**
     * @param string $username
     * @return User
     */
    public function refreshUser($username = self::DEFAULT_USER_USERNAME): User
    {
        return $this->getUser($username, true);
    }

    /**
     * @param User|null $user
     */
    public function login(?User $user = null)
    {
        if (!$user instanceof User) {
            $user = $this->getUser();
        }

        $token = new PostAuthenticationGuardToken($user, self::AUTH_FIREWALL_NAME, $user->getRoles());

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

    /**
     * @param Crawler $node
     * @param string|null $formName
     * @param array $data
     * @return Crawler|null
     */
    public function submitForm(Crawler $node, string $formName = null, array $data = []): ?Crawler
    {
        $form = $node->form();
        foreach ($data as $field => $value) {
            $fieldName = $formName ? $formName . '[' . $field . ']' : $field;
            $form[$fieldName]->setValue($value);
        }
        return $this->client()->submit($form);
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

}