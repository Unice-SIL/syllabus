<?php


namespace Tests\Syllabus\Controller\CourseInfo;

use App\Syllabus\Exception\CourseNotFoundException;
use Tests\WebTestCase;

/**
 * Class StudentControllerTest
 * @package Tests\Syllabus\Controller\CourseInfo
 */
class StudentControllerTest extends WebTestCase
{
    /**
     * @throws CourseNotFoundException
     */
    public function testStudentViewUserNotAuthenticated()
    {
        $course = $this->getCourse(self::COURSE_ALLOWED_CODE, self::COURSE_ALLOWED_YEAR);
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_APP_COURSE_STUDENT_VIEW, ['id' => $course->getId()]));
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testStudentViewUserAuthenticate()
    {
        $this->login();
        $course = $this->getCourse(self::COURSE_ALLOWED_CODE, self::COURSE_ALLOWED_YEAR);
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_APP_COURSE_STUDENT_VIEW, ['id' => $course->getId()]));
        $this->assertResponseIsSuccessful();
    }
}