<?php


namespace Tests\Syllabus\Controller\Admin;

/**
 * Class CourseInfoFieldControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class CourseInfoFieldControllerTest extends AbstractAdminControllerTest
{
    public function testCourseInfoFieldListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_COURSE_INFO_FIELD_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testCourseInfoFieldListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_COURSE_INFO_FIELD_LIST);
        $this->assertResponseIsSuccessful();
    }
}