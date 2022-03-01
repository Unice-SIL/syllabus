<?php


namespace Tests\Syllabus\Controller\CourseInfo;

use App\Syllabus\Constant\Permission;
use App\Syllabus\Entity\AskAdvice;
use App\Syllabus\Entity\CourseInfoField;
use App\Syllabus\Entity\Level;
use App\Syllabus\Exception\CourseNotFoundException;
use App\Syllabus\Fixture\CourseFixture;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DashboardControllerTest
 * @package Tests\Syllabus\Controller\CourseInfo
 */
class DashboardControllerTest extends AbstractCourseInfoControllerTest
{
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
        $from = 'SLUPB11__UNION__2018';
        $this->login();
        $courseInfo = $this->getCourse();

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
                    'id' => $courseInfo->getId()
                ]
            )
        );

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_DASHBOARD_INDEX,
                [
                    'id' => $courseInfo->getId()
                ]
            ),
            ['appbundle_duplicate_course_info' =>
                [
                    'from' => $from,
                    'to' => $this->getCourse(CourseFixture::COURSE_3)->getId()
                ]
            ]
        );
        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_APP_DASHBOARD_INDEX, ['id' => $courseInfo->getId()]));
        $em->clear();
    }

    public function testDashboardSyllabusDuplicateFailedWithFormNotValid()
    {
        $this->login();
        $courseInfo = $this->getCourse();

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_DASHBOARD_INDEX,
                [
                    'id' => $courseInfo->getId()
                ]
            )
        );

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_DASHBOARD_INDEX,
                [
                    'id' => $courseInfo->getId()
                ]
            ),
            ['appbundle_duplicate_course_info' =>
                [
                    'to' => $courseInfo->getId()
                ]
            ]
        );
        $this->assertResponseIsSuccessful();
    }

    public function testDashboardSyllabusDuplicateFailedWithNoFieldActive()
    {
        $from = 'SLUPB11__UNION__2018';
        $this->login();
        $courseInfo = $this->getCourse();

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
                    'id' => $courseInfo->getId()
                ]
            )
        );

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_DASHBOARD_INDEX,
                [
                    'id' => $courseInfo->getId()
                ]
            ),
            ['appbundle_duplicate_course_info' =>
                [
                    'from' => $from,
                    'to' => $this->getCourse(CourseFixture::COURSE_3)->getId()
                ]
            ]
        );
        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_APP_DASHBOARD_INDEX, ['id' => $courseInfo->getId()]));
    }

    public function testDashboardView()
    {
        $this->login();
        $courseInfo = $this->getCourse();
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_INFO_DASHBOARD_DASHBOARD,
                [
                    'id' => $courseInfo->getId()
                ]
            )
        );
        $this->assertJson($this->client()->getResponse()->getContent());
    }

    public function testDuplicateCourseInfoNextYear()
    {
        $this->login();
        $courseInfo = $this->getCourse();
        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_INFO_DASHBOARD_PUBLISHE_NEXT_YEAR,
                [
                    'id' => $courseInfo->getId()
                ]
            )
        );
        $this->assertJson($this->client()->getResponse()->getContent());
    }

    public function testDashboardaskAdvice()
    {
        $this->login();
        $courseInfo = $this->getCourse();
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_INFO_DASHBOARD_ASK_ADVICE,
                [
                    'id' => $courseInfo->getId()
                ]
            )
        );
        $this->assertJson($this->client()->getResponse()->getContent());

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_INFO_DASHBOARD_ASK_ADVICE,
                [
                    'id' => $courseInfo->getId()
                ]
            ),
            [
                'ask_advice' => [
                    'description' => 'myDescription',
                    '_token' => $this->getCsrfToken('ask_advice')
                ]
            ]
        );
    }

    // a compeleter
    public function testPublishCourseInfo()
    {
        $this->login();
        $courseInfo = $this->getCourse(CourseFixture::COURSE_1);
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_INFO_DASHBOARD_DASHBOARD,
                [
                    'id' => $courseInfo->getId()
                ]
            )
        );

        $token = $this->getCsrfToken('publish_course_info');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_INFO_DASHBOARD_PUBLISH,
                [
                    'id' => $courseInfo->getId()
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
}



