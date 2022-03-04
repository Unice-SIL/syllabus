<?php


namespace Tests\Syllabus\Controller\CourseInfo;


use App\Syllabus\Constant\Permission;
use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Exception\CourseNotFoundException;
use App\Syllabus\Fixture\CourseFixture;
use App\Syllabus\Fixture\UserFixture;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PresentationControllerTest
 * @package Tests\Syllabus\Controller\CourseInfo
 */
class PresentationControllerTest extends AbstractCourseInfoControllerTest
{

    /** @var CourseInfo $course */
    private $course;

    public function setUp(): void
    {
        $this->course = $this->getCourseInfo(CourseFixture::COURSE_1);
    }

    //  index

    /**
     * @throws CourseNotFoundException
     */
    public function testPresentationUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticated(self::ROUTE_APP_PRESENTATION_INDEX);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testPresentationRedirectWithAdminPermission()
    {
        $this->tryRedirectWithAdminPermission(self::ROUTE_APP_PRESENTATION_INDEX);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testPresentationWithPermission()
    {
        $this->tryWithPermission(self::ROUTE_APP_PRESENTATION_INDEX, Permission::WRITE);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testPresentationWithoutPermission()
    {
        $this->tryWithoutPermission(self::ROUTE_APP_PRESENTATION_INDEX);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    // generalView

    /**
     * @throws CourseNotFoundException
     */
    public function testPresentationGeneralUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticated(self::ROUTE_APP_PRESENTATION_GENERALE);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testPresentationGeneralRedirectWithAdminPermission()
    {
        $this->tryRedirectWithAdminPermission(self::ROUTE_APP_PRESENTATION_GENERALE);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testPresentationGeneralWithPermission()
    {
        $this->tryWithPermission(self::ROUTE_APP_PRESENTATION_GENERALE, Permission::WRITE);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testPresentationGeneralWithoutPermission()
    {
        $this->tryWithoutPermission(self::ROUTE_APP_PRESENTATION_GENERALE);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    //generalForm = edit

    // generalView
    /**
     * @throws CourseNotFoundException
     */
    public function testPresentationGeneraEditUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticated(self::ROUTE_APP_PRESENTATION_GENERALE_EDIT);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testPresentationGeneralEditRedirectWithAdminPermission()
    {
        $this->tryRedirectWithAdminPermission(self::ROUTE_APP_PRESENTATION_GENERALE_EDIT);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testPresentationGeneralEditWithPermission()
    {
        $this->tryWithPermission(self::ROUTE_APP_PRESENTATION_GENERALE_EDIT, Permission::WRITE);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testPresentationGeneralEditWithoutPermission()
    {
        $this->tryWithoutPermission(self::ROUTE_APP_PRESENTATION_GENERALE_EDIT);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }


    public function testEditPresentationGeneralSuccessful()
    {
        $em = $this->getEntityManager();
        $this->login();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_PRESENTATION_GENERALE_EDIT, ['id' => $this->course->getId()])
        );
        $data = [
            'campuses' => [
                $this->getCampus()->getId()
            ]
        ];

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_PRESENTATION_GENERALE_EDIT, ['id' => $this->course->getId()]),
            ['general' => $data]
        );

        /** @var CourseInfo $updatedCourseInfo */
        $updatedCourseInfo = $em->getRepository(CourseInfo::class)->findOneBy(['id' => $this->course->getId()]);
        self::assertEquals($updatedCourseInfo->getCampuses()->first()->getLabel(), $this->getCampus()->getLabel());
    }

    // teachers

    /**
     * @throws CourseNotFoundException
     */
    public function testPresentationTeachersUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticated(self::ROUTE_APP_PRESENTATION_TEACHERS);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testPresentationTeachersRedirectWithAdminPermission()
    {
        $this->tryRedirectWithAdminPermission(self::ROUTE_APP_PRESENTATION_TEACHERS);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testPresentationTeachersWithPermission()
    {
        $this->tryWithPermission(self::ROUTE_APP_PRESENTATION_TEACHERS, Permission::WRITE);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testPresentationTeachersWithoutPermission()
    {
        $this->tryWithoutPermission(self::ROUTE_APP_PRESENTATION_TEACHERS);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testPresentationTeachersSuccessful()
    {
        $this->login();
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_PRESENTATION_TEACHERS, ['id' => $this->course->getId()])
        );
        $this->assertResponseIsSuccessful();
    }

    // addTeachers

    /**
     * @throws CourseNotFoundException
     */
    public function testPresentationTeachersAddUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticated(self::ROUTE_APP_PRESENTATION_TEACHERS_ADD);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testPresentationTeachersAddRedirectWithAdminPermission()
    {
        $this->tryRedirectWithAdminPermission(self::ROUTE_APP_PRESENTATION_TEACHERS_ADD);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testPresentationTeachersAddWithPermission()
    {
        $this->tryWithPermission(self::ROUTE_APP_PRESENTATION_TEACHERS_ADD, Permission::WRITE);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testPresentationTeachersAddWithoutPermission()
    {
        $this->tryWithoutPermission(self::ROUTE_APP_PRESENTATION_TEACHERS_ADD);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    // a compléter
    public function testPresentationTeachersAddSuccessful()
    {
        $this->login();
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_PRESENTATION_TEACHERS_ADD,
                [
                    'id' => $this->course->getId()
                ]
            )
        );
        $token = $this->getCsrfToken('teachers');
        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_PRESENTATION_TEACHERS_ADD,
                [
                    'id' => $this->course->getId(),
                    '_token' => $token

                ]
            ),
            [
                'teachers' => [
                    'username' => $this->getUser(UserFixture::USER_3)->getId()
                ]
            ]
        );

        $this->assertTrue(true);
    }

    // teachingMode
    /**
     * @throws CourseNotFoundException
     */
    public function testPresentationTeachingModeViewUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticated(self::ROUTE_APP_PRESENTATION_TEACHING_MODE);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testPresentationTeachingModeViewRedirectWithAdminPermission()
    {
        $this->tryRedirectWithAdminPermission(self::ROUTE_APP_PRESENTATION_TEACHING_MODE);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testPresentationTeachingModeViewWithPermission()
    {
        $this->tryWithPermission(self::ROUTE_APP_PRESENTATION_TEACHING_MODE, Permission::WRITE);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testPresentationTeachingModeViewWithoutPermission()
    {
        $this->tryWithoutPermission(self::ROUTE_APP_PRESENTATION_TEACHING_MODE);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    // teachingModeEdit

    /**
     * @throws CourseNotFoundException
     */
  /*  public function testPresentationTeachingModeEditUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticated(self::ROUTE_APP_PRESENTATION_TEACHING_MODE_EDIT);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }*/

    /**
     * @throws CourseNotFoundException
     */
/*    public function testPresentationTeachingModeEditRedirectWithAdminPermission()
    {
        $this->tryRedirectWithAdminPermission(self::ROUTE_APP_PRESENTATION_TEACHING_MODE_EDIT);
        $this->assertResponseIsSuccessful();
    }*/

    /**
     * @throws CourseNotFoundException
     */
/*    public function testPresentationTeachingModeEditWithPermission()
    {
        $this->tryWithPermission(self::ROUTE_APP_PRESENTATION_TEACHING_MODE_EDIT, Permission::WRITE);
        $this->assertResponseIsSuccessful();
    }*/

    /**
     * @throws CourseNotFoundException
     *//*
    public function testPresentationTeachingModeEditWithoutPermission()
    {
        $this->tryWithoutPermission(self::ROUTE_APP_PRESENTATION_TEACHING_MODE_EDIT);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }*/
}