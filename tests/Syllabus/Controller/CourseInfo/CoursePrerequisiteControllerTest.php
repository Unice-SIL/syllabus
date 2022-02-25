<?php


namespace Tests\Syllabus\Controller\CourseInfo;

use App\Syllabus\Constant\Permission;
use App\Syllabus\Entity\CoursePrerequisite;
use App\Syllabus\Entity\CourseTutoringResource;
use App\Syllabus\Exception\CourseNotFoundException;
use App\Syllabus\Fixture\CourseFixture;
use App\Syllabus\Fixture\YearFixture;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CoursePrerequisiteControllerTest
 * @package Tests\Syllabus\Controller\CourseInfo
 */
class CoursePrerequisiteControllerTest extends AbstractCourseInfoControllerTest
{
    /**
     * @throws CourseNotFoundException
     */
    public function testCoursePrerequisiteUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticated(self::ROUTE_APP_COURSE_PREREQUISITE_INDEX);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testCoursePrerequisiteRedirectWithAdminPermission()
    {
        $this->tryRedirectWithAdminPermission(self::ROUTE_APP_COURSE_PREREQUISITE_INDEX);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testCoursePrerequisitePrerequisitesWithAdminPermission()
    {
        $this->tryRedirectWithAdminPermission(self::ROUTE_APP_COURSE_PREREQUISITE_PREREQUISITES);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testCoursePrerequisiteWithPermission()
    {
        $this->tryWithPermission(self::ROUTE_APP_COURSE_PREREQUISITE_INDEX, Permission::WRITE);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testCoursePrerequisiteWithoutPermission()
    {
        $this->tryWithoutPermission(self::ROUTE_APP_COURSE_PREREQUISITE_INDEX);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @dataProvider addCoursePrerequisiteSuccessfulProvider
     * @param array $data
     * @throws CourseNotFoundException
     */
    public function testAddCoursePrerequisiteSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourse();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_PREREQUISITE_ADD, ['id' => $course->getId()])
        );

        $data['_token'] = $this->getCsrfToken('create_edit_prerequisite');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_PREREQUISITE_ADD, ['id' => $course->getId()]),
            ['course_prerequisite' => $data]
        );

        $coursePrerequisite = $em->getRepository(CoursePrerequisite::class)->findOneBy(['description' => $data['description'] ?? '']);

        $this->assertInstanceOf(CoursePrerequisite::class, $coursePrerequisite);

        $this->assertCheckEntityProps($coursePrerequisite, $data);
    }

    /**
     * @return array
     */
    public function addCoursePrerequisiteSuccessfulProvider(): array
    {
        return [
            [['description' => 'CoursePrerequisiteTest']]
        ];
    }

    /**
     * @dataProvider addCoursePrerequisiteCsrfNotValidProvider
     * @param array $data
     * @throws CourseNotFoundException
     */
    public function testAddCoursePrerequisiteCsrfNotValid(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourse();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_PREREQUISITE_ADD, ['id' => $course->getId()])
        );

        $data['_token'] = $this->getCsrfToken('fake');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_PREREQUISITE_ADD, ['id' => $course->getId()]),
            ['course_prerequisite' => $data]
        );

        $coursePrerequisite = $em->getRepository(CoursePrerequisite::class)->findOneBy(['description' => $data['description'] ?? '']);

        $this->assertNull($coursePrerequisite);
    }

    /**
     * @return array
     */
    public function addCoursePrerequisiteCsrfNotValidProvider(): array
    {
        return [
            [['description' => 'CoursePrerequisiteTest']]
        ];
    }

    public function testSortCoursePrerequisite()
    {

        $em = $this->getEntityManager();

        $this->login();
        $course = $this->getCourse(CourseFixture::COURSE_1, YearFixture::YEAR_2018);

        $prerequisite1 = $course->getCoursePrerequisites()->first();
        $prerequisite2 = clone $prerequisite1;

        $prerequisite2->setDescription('prerequisite2')
            ->setId('1b8f9be2-96c6-4496-9efb-51f98fecf90b')
            ->setPosition(1);

        $em->persist($prerequisite2);
        $em->flush();

        $course->setCoursePrerequisites(new ArrayCollection([$prerequisite1, $prerequisite2]));

        // Before sorting
        self::assertEquals($prerequisite1->getPosition(), 0);
        self::assertEquals($prerequisite2->getPosition(), 1);

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_PREREQUISITE_PREREQUISITE_SORT,
                [
                    'id' => $course->getId()
                ]),
            ['data' =>
                [
                    $prerequisite2->getId(),
                    $prerequisite1->getId()
                ]
            ]
        );
        // After sorting
        self::assertEquals($prerequisite1->getPosition(), 1);
        self::assertEquals($prerequisite2->getPosition(), 0);
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testCoursePrerequisiteTutoringResourcesWithAdminPermission()
    {
        $this->tryRedirectWithAdminPermission(self::ROUTE_APP_COURSE_PREREQUISITE_TUTORING_RESSOURCES_VIEW);
        $this->assertResponseIsSuccessful();
    }

    public function testSortTutoringResourcesSuccessful()
    {

        $em = $this->getEntityManager();

        $this->login();
        $course = $this->getCourse(CourseFixture::COURSE_1, YearFixture::YEAR_2018);


        $tutoringResource1 = $course->getCourseTutoringResources()->first();
        $tutoringResource2 = clone $tutoringResource1;
        $tutoringResource2->setDescription('tutoringResource2')
            ->setId(null)
            ->setPosition(1);

        $em->persist($tutoringResource2);
        $em->flush();
        $course->setCourseTutoringResources(new ArrayCollection([$tutoringResource1, $tutoringResource2]));

        // Before sorting
        self::assertEquals($tutoringResource1->getPosition(), 0);
        self::assertEquals($tutoringResource2->getPosition(), 1);

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_PREREQUISITE_TUTORING_RESOURCE_SORT,
                [
                    'id' => $course->getId()
                ]),
            [
                'data' =>
                    [
                        $tutoringResource2->getId(),
                        $tutoringResource1->getId()
                    ]
            ]
        );

        // After sorting
        self::assertEquals($tutoringResource1->getPosition(), 1);
        self::assertEquals($tutoringResource2->getPosition(), 0);
    }

    /**
     * @throws CourseNotFoundException
     * @throws \App\Syllabus\Exception\UserNotFoundException
     */
    public function testAddCourseTutoringResourceSuccessful()
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourse();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_PREREQUISITE_TUTORING_RESOURCE_ADD, ['id' => $course->getId()])
        );

        $data['_token'] = $this->getCsrfToken('create_edit_tutoring_resources');

        $data['description'] = 'myDescription';

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_PREREQUISITE_TUTORING_RESOURCE_ADD, ['id' => $course->getId()]),
            ['course_tutoring_resources' => $data]
        );

        $courseTutoring = $em->getRepository(CourseTutoringResource::class)->findOneBy(['description' => $data['description'] ?? '']);
        $this->assertInstanceOf(CourseTutoringResource::class, $courseTutoring);
        $this->assertCheckEntityProps($courseTutoring, $data);
    }
}