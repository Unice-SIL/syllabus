<?php


namespace Tests\Syllabus\Controller\CourseInfo;

use App\Syllabus\Constant\Permission;
use App\Syllabus\Entity\CoursePermission;
use App\Syllabus\Exception\CourseNotFoundException;
use App\Syllabus\Fixture\CourseFixture;
use App\Syllabus\Fixture\CoursePermissionFixture;
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

    public function testAddPermissionSectionSuccessful()
    {
        $this->login();
        $course = $this->getCourse(CourseFixture::COURSE_3);
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_PERMISSION_INDEX,
                [
                    'id' => $course->getId(),
                ]
            )
        );

        $token = $this->getCsrfToken('appbundle_add_course_info_permission');
        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_PERMISSION_INDEX,
                [
                    'id' => $course->getId(),
                ]
            ),
            [
                'appbundle_add_course_info_permission' => [
                    "user" => $this->getUser()->getId(),
                    "permission" => Permission::WRITE,
                    "_token" => $token
                ]
            ]
        );
        /** @var CoursePermission $coursePermission */
        $coursePermission = $this->getEntityManager()->getRepository(CoursePermission::class)->findOneBy(
            [
                'user' => $this->getUser(),
                'permission' => Permission::WRITE,
                'courseInfo' => $course
            ]
        );
        $this->assertNotNull($coursePermission);
    }

    /**
     *   The test failed because the permission adready exists
     */
    public function testAddPermissionSectionFailed()
    {
        $this->login();
        $course = $this->getCourse();
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_PERMISSION_INDEX,
                [
                    'id' => $course->getId(),
                ]
            )
        );

        $token = $this->getCsrfToken('appbundle_add_course_info_permission');
        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_PERMISSION_INDEX,
                [
                    'id' => $course->getId(),
                ]
            ),
            [
                'appbundle_add_course_info_permission' => [
                    "user" => $this->getUser()->getId(),
                    "permission" => Permission::WRITE,
                    "_token" => $token
                ]
            ]
        );
        $coursePermissions = $this->getEntityManager()->getRepository(CoursePermission::class)->findBy(
            [
                'user' => $this->getUser(),
                'permission' => Permission::WRITE,
                'courseInfo' => $course
            ]
        );
        self::assertEquals($this->count($coursePermissions), 1);
    }
}