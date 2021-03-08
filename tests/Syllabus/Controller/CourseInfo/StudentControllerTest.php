<?php


namespace Tests\Syllabus\Controller\CourseInfo;

use App\Syllabus\Exception\CourseNotFoundException;

/**
 * Class StudentControllerTest
 * @package Tests\Syllabus\Controller\CourseInfo
 */
class StudentControllerTest extends AbstractCourseInfoControllerTest
{
    /**
     * @throws CourseNotFoundException
     */
    public function testStudentViewUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticated(self::ROUTE_APP_COURSE_STUDENT_VIEW);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testStudentViewUserAuthenticate()
    {
        $this->tryRedirectWithPermission(self::ROUTE_APP_COURSE_STUDENT_VIEW);
        $this->assertResponseIsSuccessful();
    }
}