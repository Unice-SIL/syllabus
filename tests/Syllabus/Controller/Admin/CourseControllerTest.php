<?php


namespace Tests\Syllabus\Controller\Admin;

use App\Syllabus\Constant\UserRole;
use App\Syllabus\Entity\Course;
use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Exception\CourseNotFoundException;
use App\Syllabus\Exception\StructureNotFoundException;
use App\Syllabus\Exception\UserNotFoundException;
use App\Syllabus\Exception\YearNotFoundException;
use App\Syllabus\Fixture\YearFixture;
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
                    'label' => $this->getCourseInfo()->getCourse()->getTitle()
                ]
            ],
            [
                [
                    'code' => $this->getCourseInfo()->getCourse()->getCode()
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
     * @param $fieldName
     * @throws UserNotFoundException
     */
    public function testNewCourseFailed(array $data, $fieldName)
    {
        $em = $this->getEntityManager();
        $this->login();
        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_COURSE_NEW));

        $crawler = $this->submitForm($crawler->filter('button[type="submit"]'), 'course', $data);

        $this->assertInvalidFormField($crawler, 'appbundle_course' . $fieldName, null);

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
            ],
            [
                [
                    'title' => 'Empty type',
                    'type' => ''
                ],
                '[type]'
            ],
            [
                [
                    'title' => 'Type Null',
                    'type' => null
                ],
                '[type]'
            ],
            [
                [
                    'title' => '',
                    'type' => '12345'
                ],
                '[title]'
            ],
            [
                [
                    'title' => null,
                    'type' => '12345'
                ],
                '[title]'
            ],
            [
                [
                    'title' => 'Exactly 150 characters, Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Nam ut sem sed mauris hendrerit fermentum a eget.',
                    'type' => '12345'
                ],
                '[title]'
            ],
        ];
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testCourseEditUserNotAuthenticated()
    {
        $course = $this->getCourseInfo()->getCourse();
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_COURSE_EDIT, ['id' => $course->getId()]);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testCourseEditWithAdminPermission()
    {
        $course = $this->getCourseInfo()->getCourse();
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_COURSE_EDIT, ['id' => $course->getId()]);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider courseEditWithMissingRoleProvider
     * @param array $data
     * @throws CourseNotFoundException
     * @throws UserNotFoundException
     */
    public function testCourseEditWithMissingRole(array $data)
    {
        $course = $this->getCourseInfo()->getCourse();
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_COURSE_EDIT, ['id' => $course->getId()]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function courseEditWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_COURSE']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_COURSE_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN_COURSE', 'ROLE_ADMIN_COURSE_UPDATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_COURSE']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_COURSE_UPDATE']],
        ];
    }

    /**
     * @dataProvider editCourseSuccessfulProvider
     * @param array $data
     * @throws UserNotFoundException
     */
    public function testEditCourseSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = new Course();
        $course
            ->setTitle('Fake')
            ->setType('Fake');

        $em->persist($course);
        $em->flush();

        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_COURSE_EDIT,
            ['id' => $course->getId()]));

        $this->submitForm($crawler->filter('button[type="submit"]'), 'course', $data);

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_ADMIN_COURSE_EDIT, ['id' => $course->getId()]));

        /** @var Course $updatedCourse */
        $updatedCourse = $em->getRepository(Course::class)->find($course->getId());

        $this->assertCheckEntityProps($updatedCourse, $data);
    }

    /**
     * @return array
     */
    public function editCourseSuccessfulProvider(): array
    {
        return [
            [
                [
                    'title' => 'CourseTest42',
                ]
            ],
            [
                [
                    'type' => 'Test'
                ]
            ]
        ];
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testCourseShowUserNotAuthenticated()
    {
        $course = $this->getCourseInfo()->getCourse();
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_COURSE_SHOW, ['id' => $course->getId()]);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testCourseShowWithAdminPermission()
    {
        $course = $this->getCourseInfo()->getCourse();
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_COURSE_SHOW, ['id' => $course->getId()]);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider courseShowWithMissingRoleProvider
     * @param array $data
     * @throws CourseNotFoundException
     * @throws UserNotFoundException
     */
    public function testCourseShowWithMissingRole(array $data)
    {
        $course = $this->getCourseInfo()->getCourse();
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_COURSE_SHOW, ['id' => $course->getId()]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function courseShowWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_COURSE']],
            [['ROLE_USER']],
        ];
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testNewCourseInfoUserNotAuthenticated()
    {
        $course = $this->getCourseInfo()->getCourse();
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_COURSE_NEW_COURSE_INFO, ['id' => $course->getId()]);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testNewCourseInfoWithAdminPermission()
    {
        $course = $this->getCourseInfo()->getCourse();
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_COURSE_NEW_COURSE_INFO, ['id' => $course->getId()]);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider newCourseInfoShowWithMissingRoleProvider
     * @param array $data
     * @throws CourseNotFoundException
     * @throws UserNotFoundException
     */
    public function testNewCourseInfoWithMissingRole(array $data)
    {
        $course = $this->getCourseInfo()->getCourse();
        $this->getUser()->setRoles($data)->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_COURSE_NEW_COURSE_INFO, ['id' => $course->getId()]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array[]
     */
    public function newCourseInfoShowWithMissingRoleProvider(): array
    {
        return [
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_COURSE']],
            [['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ADMIN_COURSE_INFO_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN_COURSE', 'ROLE_ADMIN_COURSE_INFO_CREATE']],
            [['ROLE_USER', 'ROLE_ADMIN']],
            [['ROLE_USER', 'ROLE_ADMIN_COURSE']],
            [['ROLE_USER']],
            [['ROLE_USER', 'ROLE_ADMIN_COURSE_INFO_CREATE']],
        ];
    }

    /**
     * @dataProvider newCourseInfoSuccessfulProvider
     * @param array $data
     * @throws CourseNotFoundException
     * @throws UserNotFoundException
     */
    public function testNewCourseInfoSuccessful(array $data)
    {
        $course = $this->getCourseInfo()->getCourse();
        $em = $this->getEntityManager();
        $this->login();
        $crawler = $this->client()->request('GET', $this->generateUrl(
            self::ROUTE_ADMIN_COURSE_NEW_COURSE_INFO,
            ['id' => $course->getId()]
        ));

        $this->submitForm($crawler->filter('button[type="submit"]'), 'course_info', $data);

        $this->assertCount(
            1,
            $this->getFlashMessagesInSession('success')
        );

        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_ADMIN_COURSE_SHOW, ['id' => $course->getId()]));

        $course = $em->getRepository(CourseInfo::class)->findOneBy(['title' => $data['title'] ?? '']);

        $this->assertInstanceOf(CourseInfo::class, $course);

        $this->assertEquals($course->getStructure()->getId(), $data['structure']);
        $this->assertEquals($course->getYear()->getId(), $data['year']);
    }

    /**
     * @return array
     * @throws StructureNotFoundException
     * @throws YearNotFoundException
     */
    public function newCourseInfoSuccessfulProvider(): array
    {
        return [
            [
                [
                    'title' => 'GroupTest42',
                    'structure' => $this->getStructure()->getId(),
                    'year' => $this->getYear(YearFixture::YEAR_2013)->getId()
                ]
            ]
        ];
    }

    /**
     * @dataProvider newCourseInfoFailedProvider
     * @param array $data
     * @param $fieldName
     * @throws CourseNotFoundException
     * @throws UserNotFoundException
     */
    public function testNewCourseInfoFailed(array $data, $fieldName)
    {
        $course = $this->getCourseInfo()->getCourse();
        $em = $this->getEntityManager();
        $this->login();
        $crawler = $this->client()->request('GET', $this->generateUrl(
            self::ROUTE_ADMIN_COURSE_NEW_COURSE_INFO,
            ['id' => $course->getId()]
        ));

        $crawler = $this->submitForm($crawler->filter('button[type="submit"]'), 'course_info', $data);

        $this->assertInvalidFormField($crawler, 'course_info' . $fieldName, null);

        $course = $em->getRepository(CourseInfo::class)->findOneBy(['title' => $data['title'] ?? '']);
        $this->assertNull($course);
    }

    /**
     * @return array
     * @throws StructureNotFoundException
     * @throws YearNotFoundException
     */
    public function newCourseInfoFailedProvider(): array
    {
        return [
            [
                [
                    'title' => null,
                    'structure' => $this->getStructure()->getId(),
                    'year' => $this->getYear(YearFixture::YEAR_2013)->getId()
                ],
                '[title]'
            ],
            [
                [
                    'title' => '',
                    'structure' => $this->getStructure()->getId(),
                    'year' => $this->getYear(YearFixture::YEAR_2013)->getId()
                ],
                '[title]'
            ],
            [
                [
                    'title' => 'Exactly 200 characters. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Morbi nibh dui, sollicitudin id lectus et, iaculis feugiat justo.
                    Nullam rutrum mauris a sagittis volutpat. Etiam quam.',
                    'structure' => $this->getStructure()->getId(),
                    'year' => $this->getYear(YearFixture::YEAR_2013)->getId()
                ],
                '[title]'
            ]
        ];
    }

    /**
     * @throws CourseNotFoundException
     * @throws UserNotFoundException
     */
    public function testAutocomplete()
    {
        $course = $this->getCourseInfo()->getCourse();
        $responseData = $this->getAutocompleteJson(
            $this->generateUrl(self::ROUTE_ADMIN_COURSE_AUTOCOMPLETE, ['field' => 'code']),
            ['query' => $course->getCode()]
        );
        $this->assertEquals($course->getCode(), current($responseData));
    }

    /**
     * @throws CourseNotFoundException
     * @throws UserNotFoundException
     */
    public function testAutocompleteS2()
    {
        $course = $this->getCourseInfo()->getCourse();
        $responseData = $this->getAutocompleteJson(
            $this->generateUrl(self::ROUTE_ADMIN_COURSE_AUTOCOMPLETES2),
            ['q' => $course->getCode()]
        );
        $this->assertEquals($course->getId(), current($responseData)['id']);
    }

    /**
     * @throws CourseNotFoundException
     * @throws UserNotFoundException
     */
    public function testAutocompleteS2ReturnFalse()
    {
        $course = $this->getCourseInfo()->getCourse();
        $responseData = $this->getAutocompleteJson(
            $this->generateUrl(self::ROUTE_ADMIN_COURSE_AUTOCOMPLETES2),
            [
                'q' => $course->getCode(),
                'code' => $course->getCode()
            ]
        );
        $this->assertFalse(current($responseData));
    }

    /**
     * @throws UserNotFoundException
     */
    public function testAutocompleteS3()
    {
        $courses = $this->getEntityManager()->getRepository(CourseInfo::class)->findAll();
        $responseData = $this->getAutocompleteJson(
            $this->generateUrl(self::ROUTE_ADMIN_COURSE_AUTOCOMPLETES3),
            []
        );
        $this->assertSameSize($courses, $responseData);
    }
}