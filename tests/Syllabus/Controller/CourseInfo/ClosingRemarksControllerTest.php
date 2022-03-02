<?php


namespace Tests\Syllabus\Controller\CourseInfo;


use App\Syllabus\Constant\Permission;
use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Exception\CourseNotFoundException;
use App\Syllabus\Fixture\UserFixture;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ClosingRemarksControllerTest
 * @package Tests\Syllabus\Controller\CourseInfo
 */
class ClosingRemarksControllerTest extends AbstractCourseInfoControllerTest
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
    public function testClosingRemarksIndexUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticated(self::ROUTE_APP_CLOSING_REMARKS_INDEX);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testClosingRemarksRedirectWithAdminPermission()
    {
        $this->tryRedirectWithAdminPermission(self::ROUTE_APP_CLOSING_REMARKS_INDEX);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testClosingRemarksWithPermission()
    {
        $this->tryWithPermission(self::ROUTE_APP_CLOSING_REMARKS_INDEX, Permission::WRITE);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testClosingRemarksWithoutPermission()
    {
        $this->tryWithoutPermission(self::ROUTE_APP_CLOSING_REMARKS_INDEX);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testClosingRemarksUserNotAuthenticated()
    {
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_CLOSING_REMARKS_CLOSING_REMARKS, ['id' => $this->course->getId()])
        );
        $this->assertRedirectToLogin();
    }

    /**
     * @throws UserNotFoundException
     */
    public function testClosingRemarksForbidden()
    {
        $this->login(UserFixture::USER_3);
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_CLOSING_REMARKS_CLOSING_REMARKS, ['id' => $this->course->getId()])
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @throws \App\Syllabus\Exception\UserNotFoundException
     */
    public function testClosingRemarqueSuccessful()
    {
        $this->login();
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_CLOSING_REMARKS_CLOSING_REMARKS, ['id' => $this->course->getId()])
        );
        $this->assertResponseIsSuccessful();
    }

    public function testClosingRemarksEditUserNotAuthenticated()
    {
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_CLOSING_REMARKS_CLOSING_REMARKS_EDIT, ['id' => $this->course->getId()])
        );
        $this->assertRedirectToLogin();
    }


    /**
     * @throws \App\Syllabus\Exception\UserNotFoundException
     */
    public function testClosingRemarksEditForbidden()
    {
        $this->login(UserFixture::USER_3);
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_CLOSING_REMARKS_CLOSING_REMARKS_EDIT, ['id' => $this->course->getId()])
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array
     */
    public function editClosingRemarksSuccessfulProvider(): array
    {
        return [
            [
                [
                    'closingRemarks' => 'remarque',
                    'closingVideo' => 'video'
                ]
            ],
            [
                [
                    'closingRemarks' => 'remarque',
                    'closingVideo' => null
                ]
            ],
            [
                [
                    'closingRemarks' => null,
                    'closingVideo' => 'video'
                ]
            ],
            [
                [
                    'closingRemarks' => null,
                    'closingVideo' => null
                ]
            ]
        ];
    }

    /**
     * @dataProvider editClosingRemarksSuccessfulProvider
     * @throws \App\Syllabus\Exception\UserNotFoundException
     */
    public function testClosingRemarksEditSuccessful($data)
    {
        $this->login();
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_CLOSING_REMARKS_CLOSING_REMARKS_EDIT, ['id' => $this->course->getId()])
        );
        $data['_token'] = $this->getCsrfToken('closing_remarks');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_CLOSING_REMARKS_CLOSING_REMARKS_EDIT,
                [
                    'id' => $this->course->getId()
                ]
            ),
            ['closing_remarks' =>
                $data
            ]
        );
        $this->assertResponseIsSuccessful();
        /** @var CourseInfo $courseInfoUpdated */
        $courseInfoUpdated = $this->getEntityManager()->getRepository(CourseInfo::class)->findOneBy(['id' => $this->course->getId()]);

        self::assertEquals($courseInfoUpdated->getClosingRemarks(), $data['closingRemarks']);
        self::assertEquals($courseInfoUpdated->getClosingVideo(), $data['closingVideo']);
    }

    /**
     * @dataProvider editClosingRemarksSuccessfulProvider
     * @throws \App\Syllabus\Eception\UserNotFoundException
     */
    public function testInfoEditSuccessfulWihPermission($data)
    {
        $this->tryWithPermission(self::ROUTE_APP_CLOSING_REMARKS_CLOSING_REMARKS_EDIT, Permission::WRITE);

        $data['_token'] = $this->getCsrfToken('closing_remarks');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_CLOSING_REMARKS_CLOSING_REMARKS_EDIT,
                [
                    'id' => $this->course->getId()
                ]
            ),
            ['closing_remarks' =>
                $data
            ]
        );
        $this->assertResponseIsSuccessful();
        /** @var CourseInfo $courseInfoUpdated */
        $courseInfoUpdated = $this->getEntityManager()->getRepository(CourseInfo::class)->findOneBy(['id' => $this->course->getId()]);

        self::assertEquals($courseInfoUpdated->getClosingRemarks(), $data['closingRemarks']);
        self::assertEquals($courseInfoUpdated->getClosingVideo(), $data['closingVideo']);
    }
}