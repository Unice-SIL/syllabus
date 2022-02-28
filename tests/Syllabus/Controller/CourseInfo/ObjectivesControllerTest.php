<?php


namespace Tests\Syllabus\Controller\CourseInfo;


use App\Syllabus\Constant\Permission;
use App\Syllabus\Entity\CourseAchievement;
use App\Syllabus\Exception\CourseNotFoundException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ObjectivesControllerTest
 * @package Tests\Syllabus\Controller\CourseInfo
 */
class ObjectivesControllerTest extends AbstractCourseInfoControllerTest
{
    /**
     * @throws CourseNotFoundException
     */
    public function testObjectivesUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticated(self::ROUTE_APP_OBJECTIVES_INDEX);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testObjectivesRedirectWithAdminPermission()
    {
        $this->tryRedirectWithAdminPermission(self::ROUTE_APP_OBJECTIVES_INDEX);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testObjectivesWithPermission()
    {
        $this->tryWithPermission(self::ROUTE_APP_OBJECTIVES_INDEX, Permission::WRITE);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testObjectivesWithoutPermission()
    {
        $this->tryWithoutPermission(self::ROUTE_APP_OBJECTIVES_INDEX);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @dataProvider addAchievementSuccessfulProvider
     * @param array $data
     * @throws CourseNotFoundException
     */
    public function testAddAchievementSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourseInfo();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_OBJECTIVES_ADD_ACHIEVEMENT, ['id' => $course->getId()])
        );

        $data['_token'] = $this->getCsrfToken('create_edit_achievement');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_OBJECTIVES_ADD_ACHIEVEMENT, ['id' => $course->getId()]),
            ['course_achievement' => $data]
        );

        $achievement = $em->getRepository(CourseAchievement::class)->findOneBy(['description' => $data['description'] ?? '']);

        $this->assertInstanceOf(CourseAchievement::class, $achievement);

        $this->assertCheckEntityProps($achievement, $data);
    }

    /**
     * @return array
     */
    public function addAchievementSuccessfulProvider(): array
    {
        return [
            [['description' => 'CourseAchievementTest']]
        ];
    }


    /**
     * @dataProvider addAchievementCsrfNotValidProvider
     * @param array $data
     * @throws CourseNotFoundException
     */
    public function testAddAchievementCsrfNotValid(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourseInfo();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_OBJECTIVES_ADD_ACHIEVEMENT, ['id' => $course->getId()])
        );

        $data['_token'] = $this->getCsrfToken('fake');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_OBJECTIVES_ADD_ACHIEVEMENT, ['id' => $course->getId()]),
            ['course_achievement' => $data]
        );

        $achievement = $em->getRepository(CourseAchievement::class)->findOneBy(['description' => $data['description'] ?? '']);

        $this->assertNull($achievement);
    }

    /**
     * @return array
     */
    public function addAchievementCsrfNotValidProvider(): array
    {
        return [
            [['description' => 'CourseAchievementTest']]
        ];
    }
}