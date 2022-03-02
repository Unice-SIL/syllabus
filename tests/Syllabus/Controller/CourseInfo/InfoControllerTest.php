<?php


namespace Tests\Syllabus\Controller\CourseInfo;


use App\Syllabus\Constant\Permission;
use App\Syllabus\Exception\CourseNotFoundException;
use App\Syllabus\Fixture\UserFixture;
use Proxies\__CG__\App\Syllabus\Entity\CourseInfo;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class InfoControllerTest
 * @package Tests\Syllabus\Controller\CourseInfo
 */
class InfoControllerTest extends AbstractCourseInfoControllerTest
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
        $this->course = $this->getCourseInfo();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testInfoUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticated(self::ROUTE_APP_INFO_INDEX);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testInfoRedirectWithAdminPermission()
    {
        $this->tryRedirectWithAdminPermission(self::ROUTE_APP_INFO_INDEX);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testInfoWithPermission()
    {
        $this->tryWithPermission(self::ROUTE_APP_INFO_INDEX, Permission::WRITE);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testInfoWithoutPermission()
    {
        $this->tryWithoutPermission(self::ROUTE_APP_INFO_INDEX);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testInfoInfoUserNotAuthenticated()
    {
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_INFO_INFO, ['id' => $this->course->getId()])
        );
        $this->assertRedirectToLogin();
    }

    /**
     * @throws UserNotFoundException
     */
    public function testInfoInfoForbidden()
    {
        $this->login(UserFixture::USER_3);
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_INFO_INFO, ['id' => $this->course->getId()])
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @throws \App\Syllabus\Exception\UserNotFoundException
     */
    public function testInfoInfoSuccessful()
    {
        $this->login();
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_INFO_INFO, ['id' => $this->course->getId()])
        );
        $this->assertResponseIsSuccessful();
    }

    public function testInfoEditUserNotAuthenticated()
    {
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_INFO_EDIT, ['id' => $this->course->getId()])
        );
        $this->assertRedirectToLogin();
    }

    /**
     * @throws \App\Syllabus\Exception\UserNotFoundException
     */
    public function testInfoEditForbidden()
    {
        $this->login(UserFixture::USER_3);
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_INFO_EDIT, ['id' => $this->course->getId()])
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @throws \App\Syllabus\Exception\UserNotFoundException
     */
    public function testInfoEditSuccessful()
    {
        $this->login();
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_INFO_EDIT, ['id' => $this->course->getId()])
        );
        $data = [
            'agenda' => 'Mon agenda',
            '_token' => $this->getCsrfToken('info')
        ];
        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_INFO_EDIT,
                [
                    'id' => $this->course->getId()
                ]
            ),
            ['info' =>
                $data
            ]
        );
        $this->assertResponseIsSuccessful();
        /** @var CourseInfo $courseInfoUpdated */
        $courseInfoUpdated = $this->getEntityManager()->getRepository(CourseInfo::class)->findOneBy(['id' => $this->course->getId()]);
        self::assertEquals($courseInfoUpdated->getAgenda(), $data['agenda']);
    }

    /**
     * @throws \App\Syllabus\Exception\UserNotFoundException
     */
    public function testInfoEditSuccessfulWihPermission()
    {
        $this->tryWithPermission(self::ROUTE_APP_INFO_EDIT, Permission::WRITE);
        $data = [
            'agenda' => 'Mon agenda',
            '_token' => $this->getCsrfToken('info')
        ];
        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_INFO_EDIT,
                [
                    'id' => $this->course->getId()
                ]
            ),
            ['info' => $data]
        );
        $this->assertResponseIsSuccessful();
        /** @var CourseInfo $courseInfoUpdated */
        $courseInfoUpdated = $this->getEntityManager()->getRepository(CourseInfo::class)->findOneBy(['id' => $this->course->getId()]);
        self::assertEquals($courseInfoUpdated->getAgenda(), $data['agenda']);
    }
}
