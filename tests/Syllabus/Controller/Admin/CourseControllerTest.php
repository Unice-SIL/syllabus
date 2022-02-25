<?php


namespace Tests\Syllabus\Controller\Admin;

use App\Syllabus\Constant\UserRole;
use App\Syllabus\Entity\Course;
use App\Syllabus\Exception\CourseNotFoundException;
use App\Syllabus\Exception\UserNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CourseControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class CourseControllerTest extends AbstractAdminControllerTest
{
    public function testCourseListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_COURSE_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testCourseListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_COURSE_LIST);
        $this->assertResponseIsSuccessful();
    }


    /**
     * @dataProvider courseListWithMissingRoleProvider
     * @param array $data
     * @throws UserNotFoundException
     */
    public function testCourseListWithMissingRole(array $data)
    {
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_COURSE_LIST));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function courseListWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_COURSE']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_COURSE_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN_COURSE', 'ROLE_ADMIN_COURSE_LIST']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_COURSE']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_COURSE_LIST']],
        ];
    }


    /**
     * @dataProvider courseFilterProvider
     *
     * @param array $filter
     */
    public function testCourseFilter(array $filter)
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_COURSE_LIST, [
            'course_filter' => $filter
        ]);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @return array
     * @throws CourseNotFoundException
     */
    public function courseFilterProvider(): array
    {
        return [
            [
                [
                    'label' => $this->getCourse()->getCourse()->getTitle()
                ]
            ],
            [
                [
                    'code' => $this->getCourse()->getCourse()->getCode()
                ]
            ]
        ];
    }


    public function testCourseNewUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_COURSE_NEW);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testCourseNewWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_COURSE_NEW);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider courseNewWithMissingRoleProvider
     * @param array $data
     * @throws UserNotFoundException
     */
    public function testCourseNewWithMissingRole(array $data)
    {
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_COURSE_NEW));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function courseNewWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_COURSE']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_COURSE_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN_COURSE', 'ROLE_ADMIN_COURSE_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_COURSE']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_COURSE_CREATE']],
        ];
    }

    /**
     * @dataProvider newCourseSuccessfulProvider
     * @param array $data
     * @throws UserNotFoundException
     */
    public function testNewCourseSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_COURSE_NEW));

        $this->submitForm($crawler->filter('button[type="submit"]'), 'course', $data);

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_ADMIN_COURSE_LIST));

        $course = $em->getRepository(Course::class)->findOneBy(['title' => $data['title'] ?? '']);

        $this->assertInstanceOf(Course::class, $course);

        $this->assertCheckEntityProps($course, $data);
    }

    /**
     * @return array
     */
    public function newCourseSuccessfulProvider(): array
    {
        return [
            [
                [
                    'title' => 'GroupTest42',
                    'type' => 'ECUE'
                ]
            ]
        ];
    }
    /**
     * @dataProvider newCourseFailedProvider
     * @param array $data
     * @throws UserNotFoundException
     */
    public function testNewCourseFailed(array $data, $fieldName)
    {
        $em = $this->getEntityManager();
        $this->login();
        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_COURSE_NEW));

        $this->submitForm($crawler->filter('button[type="submit"]'), 'course', $data);

        //$this->assertInvalidFormField($crawler, 'appbundle_course' . $fieldName);

        $course = $em->getRepository(Course::class)->findOneBy(['title' => $data['title'] ?? '']);
        $this->assertNull($course);
    }

    /**
     * @return array
     */
    public function newCourseFailedProvider(): array
    {
        return [
            [
                [
                    'title' => 'More than 5 characters for type',
                    'type' => '123456'
                ],
                '[type]'
            ]
        ];
    }

}