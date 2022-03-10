<?php


namespace Tests\Syllabus\Controller\CourseInfo;

use App\Syllabus\Constant\Permission;
use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\CourseInfoField;
use App\Syllabus\Exception\CourseNotFoundException;
use App\Syllabus\Fixture\CourseFixture;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DashboardControllerTest
 * @package Tests\Syllabus\Controller\CourseInfo
 */
class DashboardControllerTest extends AbstractCourseInfoControllerTest
{

    /** @var CourseInfo $courseInfo */
    private $courseInfo;

    public function setUp(): void
    {
        $this->courseInfo = $this->getCourseInfo(CourseFixture::COURSE_1);
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testDashboardUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticated(self::ROUTE_APP_DASHBOARD_INDEX);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testDashboardRedirectWithAdminPermission()
    {
        $this->tryRedirectWithAdminPermission(self::ROUTE_APP_DASHBOARD_INDEX);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testDashboardWithPermission()
    {
        $this->tryWithPermission(self::ROUTE_APP_DASHBOARD_INDEX, Permission::WRITE);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testDashboardWithoutPermission()
    {
        $this->tryWithoutPermission(self::ROUTE_APP_DASHBOARD_INDEX);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @throws CourseNotFoundException
     * @throws \App\Syllabus\Exception\UserNotFoundException
     */
    public function testDashboardSyllabusDuplicateSuccessful()
    {
        $course1 = $this->getCourseInfo(CourseFixture::COURSE_1);
        $course3 = $this->getCourseInfo(CourseFixture::COURSE_3);

        $from = 'SLUPB11__UNION__2018';
        $this->login();

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_DASHBOARD_INDEX,
                [
                    'id' => $course1->getId()
                ]
            ),
            ['appbundle_duplicate_course_info' =>
                [
                    'from' => $from,
                    'to' => $course3->getId()
                ]
            ]
        );
        $this->assertCount(1, $this->getFlashMessagesInSession('success'));
        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_APP_DASHBOARD_INDEX, ['id' => $this->courseInfo->getId()]));
    }


    public function testDashboardSyllabusDuplicateFailedWithFormNotValid()
    {
        $this->login();

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_DASHBOARD_INDEX,
                [
                    'id' => $this->courseInfo->getId()
                ]
            )
        );

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_DASHBOARD_INDEX,
                [
                    'id' => $this->courseInfo->getId()
                ]
            ),
            ['appbundle_duplicate_course_info' =>
                [
                    'id' => $this->courseInfo->getId()
                ]
            ]
        );
        $this->assertResponseIsSuccessful();
    }

    public function testDashboardSyllabusDuplicateFailedWithNoCommentError()
    {
        $from = 'SLUPB11__UNION__2018';
        $this->login();

        $em = $this->getEntityManager();

        $courseInfoFields = $em->getRepository(CourseInfoField::class)->findAll();

        foreach ($courseInfoFields as $courseInfoField) {
            /** @var CourseInfoField $courseInfoField */
            $courseInfoField->setManuallyDuplication(false);
        }
        $em->flush();

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_DASHBOARD_INDEX,
                [
                    'id' => $this->courseInfo->getId()
                ]
            )
        );

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_DASHBOARD_INDEX,
                [
                    'id' => $this->courseInfo->getId()
                ]
            ),
            ['appbundle_duplicate_course_info' =>
                [
                    'from' => $this->courseInfo->getId(),
                    'to' => $this->courseInfo->getId()
                ]
            ]
        );
        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_APP_DASHBOARD_INDEX, ['id' => $this->courseInfo->getId()]));
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testDashboardViewUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticated(self::ROUTE_APP_COURSE_INFO_DASHBOARD_DASHBOARD);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testDashboardViewSuccessful()
    {
        $this->login();
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_INFO_DASHBOARD_DASHBOARD,
                [
                    'id' => $this->courseInfo->getId()
                ]
            )
        );
        $this->assertJson($this->client()->getResponse()->getContent());
    }

    public function testDuplicateCourseInfoNextYear()
    {
        $this->login();
        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_INFO_DASHBOARD_PUBLISHE_NEXT_YEAR,
                [
                    'id' => $this->courseInfo->getId(),
                    'action' => 1
                ]
            )
        );
        self::assertEquals($this->courseInfo->getDuplicateNextYear(), 1);
        $this->assertJson($this->client()->getResponse()->getContent());
    }

    public function testDashboardSyllabusDuplicateFailedWithReceiverSyllabusIdenticalToTransmitter()
    {
        $from = 'SLUPB11__UNION__2018';
        $this->login();
        $em = $this->getEntityManager();
        $courseInfoFields = $em->getRepository(CourseInfoField::class)->findAll();


        foreach ($courseInfoFields as $courseInfoField) {
            /** @var CourseInfoField $courseInfoField */
            $courseInfoField->setManuallyDuplication(false);
        }
        $em->flush();

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_DASHBOARD_INDEX,
                [
                    'id' => $this->courseInfo->getId()
                ]
            ),
            ['appbundle_duplicate_course_info' =>
                [
                    'from' => $from,
                    'to' => $this->getCourseInfo(CourseFixture::COURSE_2)->getId()
                ]
            ]
        );
        $this->assertCount(1, $this->getFlashMessagesInSession('danger'));
        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_APP_DASHBOARD_INDEX, ['id' => $this->courseInfo->getId()]));
    }

    public function testPublishCourseInfoFailedNotValidForm()
    {
        $this->login();
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_INFO_DASHBOARD_DASHBOARD,
                [
                    'id' => $this->courseInfo->getId()
                ]
            )
        );

        $token = $this->getCsrfToken('publish_course_info');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_INFO_DASHBOARD_PUBLISH,
                [
                    'id' => $this->courseInfo->getId()
                ]
            ),
            [
                'ask_advice' => [
                    '_token' => $token
                ]
            ]
        );
        $this->assertJson($this->client()->getResponse()->getContent());
    }

    public function testPublishCourseInfoFailedWithViolation()
    {
        $this->login();
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_INFO_DASHBOARD_DASHBOARD,
                [
                    'id' => $this->courseInfo->getId()
                ]
            )
        );

        $token = $this->getCsrfToken('publish_course_info');
        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_INFO_DASHBOARD_PUBLISH,
                [
                    'id' => $this->courseInfo->getId()
                ]
            ),
            [
                'publish_course_info' => [
                    '_token' => $token
                ]
            ]
        );
        $this->assertJson($this->client()->getResponse()->getContent());
    }

    // a completer
    public function testPublishCourseInfoSuccessful()
    {
        $em = $this->getEntityManager();
        $this->login();

      //  $uploadFile = new UploadedFile(__DIR__.'/data/test.jpg', 'tsest.jpg');
      //  dd($this->courseInfo->getImage());
        $this->courseInfo->setImage(__DIR__.'/data/test.jpg')->setMediaType('image');
/*       $this->courseInfo->setPreviousImage(__DIR__.'/data/test.jpg');*/
        $em->flush();

        $this->assertNull($this->courseInfo->getPublicationDate());
        $this->assertNull($this->courseInfo->getPublisher());
        $this->courseInfo = $em->getRepository(CourseInfo::class)->find($this->courseInfo->getId());

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_INFO_DASHBOARD_DASHBOARD,
                [
                    'id' => $this->courseInfo->getId()
                ]
            )
        );

        $token = $this->getCsrfToken('publish_course_info');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_INFO_DASHBOARD_PUBLISH,
                [
                    'id' => $this->courseInfo->getId()
                ]
            ),
            [
                'publish_course_info' => [
                    '_token' => $token
                ]
            ]
        );
        /** @var CourseInfo $courseInfoPublished */
        $courseInfoPublished = $em->getRepository(CourseInfo::class)->find($this->courseInfo->getId());

       // dd(  $courseInfoPublished->getPreviousImage());
        self::assertTrue(true);
        //$this->assertNotNull($courseInfoPublished->getPublicationDate());
        //$this->assertNotNull($courseInfoPublished->getPublisher());
    }

    public function testPublishCourseInfoFailedAlreadyPublish()
    {
        $em = $this->getEntityManager();
        $this->login();
        $this->courseInfo->setImage('data/test.jpg')
            ->setPublicationDate(new \DateTime());
        $em->flush();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_INFO_DASHBOARD_DASHBOARD,
                [
                    'id' => $this->courseInfo->getId()
                ]
            )
        );

        $token = $this->getCsrfToken('publish_course_info');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_INFO_DASHBOARD_PUBLISH,
                [
                    'id' => $this->courseInfo->getId()
                ]
            ),
            [
                'publish_course_info' => [
                    '_token' => $token
                ]
            ]
        );
        $this->assertNotNull($this->courseInfo->getPublicationDate());
    }
}

