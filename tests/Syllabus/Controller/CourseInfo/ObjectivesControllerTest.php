<?php


namespace Tests\Syllabus\Controller\CourseInfo;


use App\Syllabus\Constant\Permission;
use App\Syllabus\Entity\CourseAchievement;
use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Exception\CourseNotFoundException;
use App\Syllabus\Fixture\CourseFixture;
use App\Syllabus\Fixture\UserFixture;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ObjectivesControllerTest
 * @package Tests\Syllabus\Controller\CourseInfo
 */
class ObjectivesControllerTest extends AbstractCourseInfoControllerTest
{
    /**
     * @var CourseInfo
     */
    private $course;

    /**
     * @throws CourseNotFoundException
     */
    protected function setUp(): void
    {
        $this->course = $this->getCourseInfo(CourseFixture::COURSE_1);
    }
    /**
     * @throws CourseNotFoundException
     */
    public function testObjectivesUserNotAuthenticated()
    {
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_OBJECTIVES_INDEX, ['id' => $this->course->getId()])
        );
        $this->assertRedirectToLogin();
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
     * @throws UserNotFoundException
     */
    public function testObjectivesForbidden()
    {
        $this->login(UserFixture::USER_3);
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_OBJECTIVES_INDEX, ['id' => $this->course->getId()])
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }
    /**
     *
     */
    public function testObjectivesAchievementUserNotAuthenticated()
    {
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_OBJECTIVES_ACHIEVEMENT, ['id' => $this->course->getId()])
        );
        $this->assertRedirectToLogin();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testObjectivesAchievementRedirectWithAdminPermission()
    {
        $this->tryRedirectWithAdminPermission(self::ROUTE_APP_OBJECTIVES_ACHIEVEMENT);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testObjectivesAchievementWithPermission()
    {
        $this->tryWithPermission(self::ROUTE_APP_OBJECTIVES_ACHIEVEMENT, Permission::WRITE);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws UserNotFoundException
     */
    public function testObjectivesAchievementForbidden()
    {
        $this->login(UserFixture::USER_3);
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_OBJECTIVES_ACHIEVEMENT, ['id' => $this->course->getId()])
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testObjectivesAchievementAddUserNotAuthenticated()
    {
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_OBJECTIVES_INDEX, ['id' => $this->course->getId()])
        );
        $this->assertRedirectToLogin();
    }

    public function testObjectivesAchievementAddForbidden()
    {
        $this->login(UserFixture::USER_3);
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_OBJECTIVES_ADD_ACHIEVEMENT, ['id' => $this->course->getId()])
        );
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

    public function testSortAchievementUserNotAuthenticated()
    {
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_OBJECTIVES_SORT_ACHIEVEMENT, ['id' => $this->course->getId()])
        );
        $this->assertRedirectToLogin();
    }

    public function testSortAchievementForbidden()
    {
        $this->login(UserFixture::USER_3);
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_OBJECTIVES_SORT_ACHIEVEMENT, ['id' => $this->course->getId()])
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testSortAchievementSuccessful(){

        $em = $this->getEntityManager();
        $this->login();

        /** @var CourseAchievement $achievement_1 */
        $achievement_1 = $this->course->getCourseAchievements()->first();
        // position 0

        /** @var CourseAchievement $achievement_2 */
 /*       $achievement_2 = new CourseAchievement();
        $achievement_2->setDescription('Achievement n°2');

        $this->course->addCourseAchievement($achievement_2);

        $em->flush();

        dd($achievement_2->getPosition());
        dd($this->course->getCourseAchievements()->first()->getPosition());*/


        /** @var CourseAchievement $achievement_2 */
        $achievement_2 = clone $achievement_1;

        $achievement_2->setDescription('achievement_2')->setId(null)->setPosition(1);
        $this->course->addCourseAchievement($achievement_2);

        $em->persist($achievement_2);
        $em->flush();

        self::assertEquals($achievement_1->getPosition(), 0);
        self::assertEquals($achievement_2->getPosition(), 1);

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_OBJECTIVES_SORT_ACHIEVEMENT,
                [
                    'id' => $this->course->getId()
                ]),
            ['data' =>
                [
                    $achievement_2->getId(),
                    $achievement_1->getId()
                ]
            ]
        );

        $achievement_1_sorted = $em->getRepository(CourseAchievement::class)->findOneBy(['id'=> $achievement_1->getId()]);
        $achievement_2_sorted = $em->getRepository(CourseAchievement::class)->findOneBy(['id'=> $achievement_2->getId()]);

        // After sorting
        self::assertEquals($achievement_1_sorted->getPosition(), 1);
        self::assertEquals($achievement_2_sorted->getPosition(), 0);
    }
}