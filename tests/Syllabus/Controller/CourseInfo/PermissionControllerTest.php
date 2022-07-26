<?php


namespace Tests\Syllabus\Controller\CourseInfo;


use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\CoursePermission;
use App\Syllabus\Exception\CourseNotFoundException;
use App\Syllabus\Fixture\CourseFixture;

/**
 * @package Tests\Syllabus\Controller\CourseInfo
 */
class PermissionControllerTest extends AbstractCourseInfoControllerTest
{

    /** @var CourseInfo $course */
    private $course;

    public function setUp(): void
    {
        $this->course = $this->getCourseInfo(CourseFixture::COURSE_1);
    }
    /**
     * @throws CourseNotFoundException
     */
    public function testDeletePermissionUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticated(self::ROUTE_APP_COURSE_PERMISSION_DELETE);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testDeleteCourseSectionSuccessful()
    {
        $em = $this->getEntityManager();
        $this->login();

        $permission = $this->course->getCoursePermissions()->first();
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_PERMISSION_DELETE, ['id' => $permission->getId()])
        );

        $token = $this->getCsrfToken('remove_course_permission');
        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_PERMISSION_DELETE, ['id' => $permission->getId()]),
            ['remove_course_permission' => [
                '_token' => $token
            ]]
        );

        $deletedPermission = $em->getRepository(CoursePermission::class)->findOneBy(['id' => $permission->getId()]);
        $this->assertNull($deletedPermission);
    }
}