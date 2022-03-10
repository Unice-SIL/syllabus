<?php


namespace Tests\Syllabus\Controller\Common;

use App\Syllabus\Fixture\UserFixture;
use Symfony\Component\HttpFoundation\Request;
use Tests\WebTestCase;

/**
 * Class AutoCompleteControllerTest
 * @package Tests\Syllabus\Controller\Common
 */
class AutoCompleteControllerTest extends WebTestCase
{

    public function testAutoCompleteUserNotAuthenticated()
    {
        $this->client()->request(
            Request::METHOD_GET,
            $this->generateUrl(self::ROUTE_APP_AUTO_COMPLETE_GENERIC, [
                'entityName' => 'Activity'
            ]));
        $this->assertRedirectToLogin();
    }

    public function testAutoCompleteSuccessfull()
    {
        $this->login();
        $this->client()->request(Request::METHOD_POST, $this->generateUrl(self::ROUTE_APP_AUTO_COMPLETE_GENERIC, [
            'entityName' => 'Activity'
        ])
        );
        $this->assertJson($this->client()->getResponse()->getContent());
    }

    public function testAutoCompleteS2UserNotAuthenticated()
    {
        $this->client()->request(
            Request::METHOD_GET,
            $this->generateUrl(self::ROUTE_APP_AUTO_COMPLETE_S2_GENERIC, [
                'entityName' => 'Campus'
            ]));
        $this->assertRedirectToLogin();
    }

    public function testAutoCompleteS2Successfull()
    {
        $this->login();
        $this->client()->request(Request::METHOD_GET, $this->generateUrl(self::ROUTE_APP_AUTO_COMPLETE_S2_GENERIC, [
            'entityName' => 'Campus'
        ]),
            ['q' => 'Ca', 'groupProperty' => 'grp']
        );
        $this->assertJson($this->client()->getResponse()->getContent());

        // Without groupProperty
        $this->client()->request(Request::METHOD_GET, $this->generateUrl(self::ROUTE_APP_AUTO_COMPLETE_S2_GENERIC, [
            'entityName' => 'Campus'
        ]),
            ['q' => 'Ca']
        );
        $this->assertJson($this->client()->getResponse()->getContent());
    }

    public function testAutoCompleteS2UserWithUserNotAuthenticated()
    {
        $this->client()->request(
            Request::METHOD_GET,
            $this->generateUrl(self::ROUTE_APP_AUTO_COMPLETE_S2_GENERIC_USER)
        );
        $this->assertRedirectToLogin();
    }

    public function testAutoCompleteS2UserSuccessfull()
    {
        $this->login();
        $this->client()->request(Request::METHOD_GET, $this->generateUrl(self::ROUTE_APP_AUTO_COMPLETE_S2_GENERIC_USER),
            ['q' => 'user', 'field_name' => 'user']);
        $this->assertJson($this->client()->getResponse()->getContent());
    }

    public function testAutoCompleteS2CoursesUserNotAuthenticated()
    {
        $this->client()->request(Request::METHOD_GET, $this->generateUrl(self::ROUTE_APP_AUTO_COMPLETE_S2_GENERIC_COURSES,
            [
                'entityName' => 'Course'
            ])
        );
        $this->assertRedirectToLogin();
    }

    public function testAutoCompleteS2CoursesSuccessfull()
    {
        // Without groupProperty
        $this->login();
        $this->client()->request(Request::METHOD_GET, $this->generateUrl(self::ROUTE_APP_AUTO_COMPLETE_S2_GENERIC_COURSES,
            [
                'entityName' => 'Course'
            ]),
            ['findBy' => 'title', 'property' => 'title', 'query' => 'cour', 'property_optional' => 'source']);
        $this->assertJson($this->client()->getResponse()->getContent());

        // With groupProperty
        $this->client()->request(Request::METHOD_GET, $this->generateUrl(self::ROUTE_APP_AUTO_COMPLETE_S2_GENERIC_COURSES,
            [
                'entityName' => 'Course'
            ]),
            ['findBy' => 'title', 'property' => 'title', 'query' => 'cour', 'groupProperty' => 'title', 'property_optional' => 'source']);
        $this->assertJson($this->client()->getResponse()->getContent());
    }

    public function testAutoCompleteS2CourseInfoWithWritePermissionUserNotAuthenticated()
    {
        $this->client()->request(Request::METHOD_GET, $this->generateUrl(
            self::ROUTE_APP_AUTO_COMPLETE_S2_GENERIC_COURSES_INFO_WITH_WRITE_PERMISSION)
            ,
            ['currentCourseInfo' => $this->getCourseInfo()->getId()]
        );
        $this->assertRedirectToLogin();
    }

    public function testAutoCompleteS2CourseInfoWithWritePermission()
    {
        $this->login(UserFixture::USER_2);
        $this->client()->request(Request::METHOD_GET, $this->generateUrl(
            self::ROUTE_APP_AUTO_COMPLETE_S2_GENERIC_COURSES_INFO_WITH_WRITE_PERMISSION)
            ,
            ['currentCourseInfo' => $this->getCourseInfo()->getId()]
        );
        $this->assertJson($this->client()->getResponse()->getContent());
    }
}