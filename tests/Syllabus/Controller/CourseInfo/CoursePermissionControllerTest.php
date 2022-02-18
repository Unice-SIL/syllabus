<?php


namespace Tests\Syllabus\Controller\CourseInfo;

use App\Syllabus\Constant\Permission;
use App\Syllabus\Exception\CourseNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CoursePermissionControllerTest
 * @package Tests\Syllabus\Controller\CourseInfo
 */
class CoursePermissionControllerTest extends AbstractCourseInfoControllerTest
{
    /**
     * @throws CourseNotFoundException
     */
    public function testCoursePermissionUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticated(self::ROUTE_APP_COURSE_PERMISSION_INDEX);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testCoursePermissionRedirectWithAdminPermission()
    {
        $this->tryRedirectWithAdminPermission(self::ROUTE_APP_COURSE_PERMISSION_INDEX);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testCoursePermissionWithPermission()
    {
        $this->tryWithPermission(self::ROUTE_APP_COURSE_PERMISSION_INDEX, Permission::WRITE);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testCoursePermissionWithoutPermission()
    {
        $this->tryWithoutPermission(self::ROUTE_APP_COURSE_PERMISSION_INDEX);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }
}