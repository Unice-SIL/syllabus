<?php


namespace Tests\Syllabus\Controller\CourseInfo;

use App\Syllabus\Constant\Permission;
use App\Syllabus\Entity\CoursePrerequisite;
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
    public function testCoursePrerequisiteWithPermission()
    {
        $this->tryWithPermission(self::ROUTE_APP_COURSE_PREREQUISITE_INDEX, Permission::WRITE);
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

    /**
     * @dataProvider addCoursePrerequisiteSuccessfulProvider
     * @param array $data
     * @throws CourseNotFoundException
     */
    public function testAddCoursePrerequisiteSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourse();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_PREREQUISITE_ADD, ['id' => $course->getId()])
        );

        $data['_token'] = $this->getCsrfToken('create_edit_prerequisite');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_PREREQUISITE_ADD, ['id' => $course->getId()]),
            ['course_prerequisite' => $data]
        );

        $coursePrerequisite = $em->getRepository(CoursePrerequisite::class)->findOneBy(['description' => $data['description'] ?? '']);

        $this->assertInstanceOf(CoursePrerequisite::class, $coursePrerequisite);

        $this->assertCheckEntityProps($coursePrerequisite, $data);
    }

    /**
     * @return array
     */
    public function addCoursePrerequisiteSuccessfulProvider(): array
    {
        return [
            [['description' => 'CoursePrerequisiteTest']]
        ];
    }

    /**
     * @dataProvider addCoursePrerequisiteCsrfNotValidProvider
     * @param array $data
     * @throws CourseNotFoundException
     */
    public function testAddCoursePrerequisiteCsrfNotValid(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourse();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_PREREQUISITE_ADD, ['id' => $course->getId()])
        );

        $data['_token'] = $this->getCsrfToken('fake');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_PREREQUISITE_ADD, ['id' => $course->getId()]),
            ['course_prerequisite' => $data]
        );

        $coursePrerequisite = $em->getRepository(CoursePrerequisite::class)->findOneBy(['description' => $data['description'] ?? '']);

        $this->assertNull($coursePrerequisite);
    }

    /**
     * @return array
     */
    public function addCoursePrerequisiteCsrfNotValidProvider(): array
    {
        return [
            [['description' => 'CoursePrerequisiteTest']]
        ];
    }
}