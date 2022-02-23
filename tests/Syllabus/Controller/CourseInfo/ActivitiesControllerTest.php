<?php


namespace Tests\Syllabus\Controller\CourseInfo;


use App\Syllabus\Entity\CourseSection;
use App\Syllabus\Exception\CourseNotFoundException;
use App\Syllabus\Exception\CourseSectionNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ActivitiesControllerTest
 * @package Tests\Syllabus\Controller\CourseInfo
 */
class ActivitiesControllerTest extends AbstractCourseInfoControllerTest
{
    /**
     * @throws CourseNotFoundException
     */
    public function testActivitiesUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticated(self::ROUTE_APP_ACTIVITIES_INDEX);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testActivitiesWithAdminPermission()
    {
        $this->tryRedirectWithAdminPermission(self::ROUTE_APP_ACTIVITIES_INDEX);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     * @throws CourseSectionNotFoundException
     * @throws \App\Syllabus\Exception\UserNotFoundException
     */
    public function testActivitiesNotWithNotFoundSection()
    {
        $this->login();
        $course = $this->getCourse(self::COURSE_NOT_ALLOWED_CODE, self::COURSE_NOT_ALLOWED_YEAR);
        $course->addCourseSection($this->getCourseSection());
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_APP_ACTIVITIES_INDEX, ['id' => $course->getId(), 'sectionId' => 'NotFound']));
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testActivitiesWithPermission()
    {
        $this->tryWithPermission(self::ROUTE_APP_ACTIVITIES_INDEX, 'WRITE');
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testActivitiesWithoutPermission()
    {
        $this->tryWithoutPermission(self::ROUTE_APP_ACTIVITIES_INDEX);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @dataProvider addSectionSuccessfulProvider
     * @param array $data
     * @throws CourseNotFoundException
     */
    public function testAddSectionSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourse();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_ACTIVITIES_ADD_SECTION, ['id' => $course->getId()])
        );

        $data['_token'] = $this->getCsrfToken('create_edit_section');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_ACTIVITIES_ADD_SECTION, ['id' => $course->getId()]),
            ['section' => $data]
        );

        $section = $em->getRepository(CourseSection::class)->findOneBy(['title' => $data['title'] ?? '']);

        $this->assertInstanceOf(CourseSection::class, $section);

        $this->assertCheckEntityProps($section, $data);
    }

    /**
     * @return array
     */
    public function addSectionSuccessfulProvider(): array
    {
        return [
            [['title' => 'SectionTest', 'description' => 'CourseAchievementTest']],
            [['title' => 'SectionTest']]
        ];
    }

    /**
     * @dataProvider addSectionCsrfNotValidProvider
     * @param array $data
     * @throws CourseNotFoundException
     */
    public function testAddSectionCsrfNotValid(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourse();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_ACTIVITIES_ADD_SECTION, ['id' => $course->getId()])
        );

        $data['_token'] = $this->getCsrfToken('fake');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_ACTIVITIES_ADD_SECTION, ['id' => $course->getId()]),
            ['section' => $data]
        );

        $section = $em->getRepository(CourseSection::class)->findOneBy(['title' => $data['title'] ?? '']);

        $this->assertNull($section);
    }

    /**
     * @return array
     */
    public function addSectionCsrfNotValidProvider(): array
    {
        return [
            [['title' => 'SectionTest']]
        ];
    }

    /**
     * @throws CourseNotFoundException
     * @throws CourseSectionNotFoundException
     */
    public function testDuplicateSectionSuccessful()
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourse();
        $section = $this->getCourseSection();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_ACTIVITIES_DUPLICATE_SECTION,
                ['id' => $course->getId(), 'sectionId' => $section->getId()])
        );

        $data['_token'] = $this->getCsrfToken('duplicate_section');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_ACTIVITIES_DUPLICATE_SECTION,
                ['id' => $course->getId(), 'sectionId' => $section->getId()]),
            ['duplicate_course_section' => $data]
        );

        $duplicateSection = $em->getRepository(CourseSection::class)->findOneBy(['position' => $section->getPosition() + 1]);
        $this->assertInstanceOf(CourseSection::class, $duplicateSection);

        // second duplication
        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_ACTIVITIES_DUPLICATE_SECTION,
                ['id' => $course->getId(), 'sectionId' => $section->getId()]),
            ['duplicate_course_section' => $data]
        );

        $duplicateSection2 = $em->getRepository(CourseSection::class)->findOneBy(['position' => $section->getPosition() + 2]);
        $this->assertInstanceOf(CourseSection::class, $duplicateSection2);
    }

    /**
     * @throws CourseNotFoundException
     * @throws CourseSectionNotFoundException
     */
    public function testDuplicateSectionCsrfNotValid()
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourse();
        $section = $this->getCourseSection();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_ACTIVITIES_DUPLICATE_SECTION,
                ['id' => $course->getId(), 'sectionId' => $section->getId()])
        );

        $data['_token'] = $this->getCsrfToken('fake');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_ACTIVITIES_DUPLICATE_SECTION,
                ['id' => $course->getId(), 'sectionId' => $section->getId()]),
            ['duplicate_course_section' => $data]
        );

        $duplicateSection = $em->getRepository(CourseSection::class)->findOneBy(['position' => $section->getPosition() + 1]);

        $this->assertNull($duplicateSection);
    }

    /**
     * @throws CourseNotFoundException
     * @throws CourseSectionNotFoundException
     * @throws \App\Syllabus\Exception\UserNotFoundException
     */
    public function testSortSectionSuccessful()
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourse();

        $section = $this->getCourseSection();
        $course->addCourseSection($section);

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_ACTIVITIES_DUPLICATE_SECTION,
                ['id' => $course->getId(), 'sectionId' => $section->getId()])
        );

        $data['_token'] = $this->getCsrfToken('duplicate_section');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_ACTIVITIES_DUPLICATE_SECTION,
                ['id' => $course->getId(), 'sectionId' => $section->getId()]),
            ['duplicate_course_section' => $data]
        );

        /** @var CourseSection $duplicateSection */
        $duplicateSection = $em->getRepository(CourseSection::class)->findOneBy(['position' => $section->getPosition() + 1]);

        $this->assertInstanceOf(CourseSection::class, $duplicateSection);

        // Before sorting
        self::assertEquals($section->getPosition(),0);
        self::assertEquals($duplicateSection->getPosition(),1);

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_ACTIVITIES_SORT_SECTION,
                [
                    'id' => $course->getId()
                ]),
            ['data' =>
                [
                    $duplicateSection->getId(),
                    $section->getId()
                ]
            ]
        );
        // After sorting
        self::assertEquals($duplicateSection->getPosition(),1);
        self::assertEquals($section->getPosition(),0);
    }
}