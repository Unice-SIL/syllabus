<?php


namespace Tests\Syllabus\Controller\CourseInfo;


use App\Syllabus\Exception\CourseNotFoundException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ActivitiesControllerTest
 * @package Tests\Syllabus\Controller\CourseInfo
 */
class ActivitiesControllerTest extends AbstractCourseInfoControllerTest
{
    /**
     * @throws CourseNotFoundException
     */
    public function testActivitiesUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticated(self::ROUTE_APP_ACTIVITIES_INDEX);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testActivitiesRedirectWithAdminPermission()
    {
        $this->tryRedirectWithAdminPermission(self::ROUTE_APP_ACTIVITIES_INDEX);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testActivitiesRedirectWithPermission()
    {
        $this->tryRedirectWithPermission(self::ROUTE_APP_ACTIVITIES_INDEX);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testActivitiesWithoutPermission()
    {
        $this->tryWithoutPermission(self::ROUTE_APP_ACTIVITIES_INDEX);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }
}