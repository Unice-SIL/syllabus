<?php


namespace Tests\Syllabus\Controller\CourseInfo;

use App\Syllabus\Entity\CourseAchievement;
use App\Syllabus\Exception\CourseNotFoundException;
use App\Syllabus\Exception\UserNotFoundException;
use App\Syllabus\Fixture\UserFixture;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AchievementControllerTest
 * @package Tests\Syllabus\Controller\CourseInfo
 */
class AchievementControllerTest extends AbstractCourseInfoControllerTest
{

    /**
     * @var CourseAchievement
     */
    private $achievement;

    /**
     * @throws CourseNotFoundException
     */
    protected function setUp(): void
    {
        $this->achievement = $this->getCourseAchievement();
    }

    public function testEditAchievementUserNotAuthenticated()
    {
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_ACHIEVEMENT_EDIT, ['id' => $this->achievement->getId()])
        );
        $this->assertRedirectToLogin();
    }

    /**
     * @throws UserNotFoundException
     */
    public function testEditAchievementForbidden()
    {
        $this->login(UserFixture::USER_3);
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_ACHIEVEMENT_EDIT, ['id' => $this->achievement->getId()])
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @dataProvider editAchievementSuccessfulProvider
     * @param array $data
     * @throws CourseNotFoundException
     */
    public function testEditAchievementSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourseInfo();

        $achievement = new CourseAchievement();
        $achievement->setCourseInfo($course);

        $em->persist($achievement);
        $em->flush();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_ACHIEVEMENT_EDIT, ['id' => $achievement->getId()])
        );
        $data['_token'] = $this->getCsrfToken('create_edit_achievement');

         $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_ACHIEVEMENT_EDIT, ['id' => $achievement->getId()]),
            ['course_achievement' => $data]
        );

        /** @var CourseAchievement $updatedCourseAchievement */
        $updatedCourseAchievement = $em->getRepository(CourseAchievement::class)->find($achievement->getId());

        $this->assertCheckEntityProps($updatedCourseAchievement, $data);
    }

    /**
     * @return array
     */
    public function editAchievementSuccessfulProvider(): array
    {
        return [
            [['description' => 'descriptionCourseAchievementTest']]
        ];
    }

    /**
     * @dataProvider editAchievementCsrfNotValidProvider
     * @param array $data
     * @throws CourseNotFoundException
     */
    public function testEditAchievementCsrfNotValid(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourseInfo();

        $achievement = new CourseAchievement();
        $achievement->setCourseInfo($course);

        $em->persist($achievement);
        $em->flush();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_ACHIEVEMENT_EDIT, ['id' => $achievement->getId()])
        );

        $data['_token'] = $this->getCsrfToken('fake');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_ACHIEVEMENT_EDIT, ['id' => $achievement->getId()]),
            ['course_achievement' => $data]
        );

        /** @var CourseAchievement $updatedCourseAchievement */
        $updatedCourseAchievement = $em->getRepository(CourseAchievement::class)->find($achievement->getId());

        $this->assertCheckNotSameEntityProps($updatedCourseAchievement, $data);
    }

    /**
     * @return array
     */
    public function editAchievementCsrfNotValidProvider(): array
    {
        return [
            [['description' => 'CourseAchievementTest']],
            [['description' => null]]
        ];
    }

    public function testDeleteAchievementUserNotAuthenticated()
    {
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_ACHIEVEMENT_DELETE, ['id' => $this->achievement->getId()])
        );
        $this->assertRedirectToLogin();
    }

    /**
     * @throws UserNotFoundException
     */
    public function testDeleteAchievementForbidden()
    {
        $this->login(UserFixture::USER_3);
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_ACHIEVEMENT_DELETE, ['id' => $this->achievement->getId()])
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testDeleteAchievementSuccessful()
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourseInfo();

        $achievement = new CourseAchievement();
        $achievement->setCourseInfo($course)->setDescription('testDescription');

        $em->persist($achievement);
        $em->flush();
        $achievementId = $achievement->getId();
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_ACHIEVEMENT_DELETE, ['id' => $achievement->getId()])
        );
        $token = $this->getCsrfToken('delete_achievement');
        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_ACHIEVEMENT_DELETE, ['id' => $achievement->getId()]),
            ['remove_course_achievement' => [
                '_token' => $token
            ]]
        );
        $this->assertNull($em->getRepository(CourseAchievement::class)->find($achievementId));
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testDeleteAchievementWrongCsrfToken()
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourseInfo();

        $achievement = new CourseAchievement();
        $achievement->setCourseInfo($course);

        $em->persist($achievement);
        $em->flush();

        $token = $this->getCsrfToken('fake');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_ACHIEVEMENT_DELETE, ['id' => $achievement->getId()]),
            ['remove_course_achievement' => [
                '_token' => $token
            ]]
        );

        /** @var CourseAchievement $checkAchievement */
        $checkAchievement = $em->getRepository(CourseAchievement::class)->find($achievement->getId());

        $this->assertInstanceOf(CourseAchievement::class, $checkAchievement);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}