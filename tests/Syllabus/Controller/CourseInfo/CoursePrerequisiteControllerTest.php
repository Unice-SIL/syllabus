<?php


namespace Tests\Syllabus\Controller\CourseInfo;

use App\Syllabus\Exception\CourseNotFoundException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CoursePrerequisiteControllerTest
 * @package Tests\Syllabus\Controller\CourseInfo
 */
class CoursePrerequisiteControllerTest extends AbstractCourseInfoControllerTest
{
    /**
     * @throws CourseNotFoundException
     */
    public function testCoursePrerequisiteUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticated(self::ROUTE_APP_COURSE_PREREQUISITE_INDEX);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testCoursePrerequisiteRedirectWithAdminPermission()
    {
        $this->tryRedirectWithAdminPermission(self::ROUTE_APP_COURSE_PREREQUISITE_INDEX);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testCoursePrerequisiteRedirectWithPermission()
    {
        $this->tryRedirectWithPermission(self::ROUTE_APP_COURSE_PREREQUISITE_INDEX);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testCoursePrerequisiteWithoutPermission()
    {
        $this->tryWithoutPermission(self::ROUTE_APP_COURSE_PREREQUISITE_INDEX);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }
}