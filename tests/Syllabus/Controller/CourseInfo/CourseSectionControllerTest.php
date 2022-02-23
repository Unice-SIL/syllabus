<?php


namespace Tests\Syllabus\Controller\CourseInfo;

use App\Syllabus\Entity\CourseSection;
use App\Syllabus\Entity\CourseSectionActivity;
use App\Syllabus\Exception\CourseNotFoundException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CourseSectionControllerTest
 * @package Tests\Syllabus\Controller\CourseInfo
 */
class CourseSectionControllerTest extends AbstractCourseInfoControllerTest
{
    /**
     * @dataProvider editCourseSectionSuccessfulProvider
     * @param array $data
     * @throws CourseNotFoundException
     */
    public function testEditCourseSectionSuccessful(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourse();

        $courseSection = new CourseSection();
        $courseSection->setCourseInfo($course);

        $em->persist($courseSection);
        $em->flush();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_SECTION_EDIT, ['id' => $courseSection->getId()])
        );

        $data['_token'] = $this->getCsrfToken('create_edit_section');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_SECTION_EDIT, ['id' => $courseSection->getId()]),
            ['section' => $data]
        );

        /** @var CourseSection $updatedCourseSection */
        $updatedCourseSection = $em->getRepository(CourseSection::class)->find($courseSection->getId());

        $this->assertCheckEntityProps($updatedCourseSection, $data);
    }

    /**
     * @return array
     */
    public function editCourseSectionSuccessfulProvider(): array
    {
        return [
            [['title' => 'SectionTest', 'description' => 'CourseAchievementTest']],
            [['title' => 'SectionTest']]
        ];
    }

    /**
     * @dataProvider editCourseSectionCsrfNotValidProvider
     * @param array $data
     * @throws CourseNotFoundException
     */
    public function testEditCourseSectionCsrfNotValid(array $data)
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourse();

        $courseSection = new CourseSection();
        $courseSection->setCourseInfo($course);

        $em->persist($courseSection);
        $em->flush();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_SECTION_EDIT, ['id' => $courseSection->getId()])
        );

        $data['_token'] = $this->getCsrfToken('fake');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_SECTION_EDIT, ['id' => $courseSection->getId()]),
            ['section' => $data]
        );

        /** @var CourseSection $updatedCourseSection */
        $updatedCourseSection = $em->getRepository(CourseSection::class)->find($courseSection->getId());

        $this->assertCheckNotSameEntityProps($updatedCourseSection, $data);
    }

    /**
     * @return array
     */
    public function editCourseSectionCsrfNotValidProvider(): array
    {
        return [
            [['description' => 'CourseCourseSectionTest']]
        ];
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testDeleteCourseSectionSuccessful()
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourse();

        $courseSection = new CourseSection();
        $courseSection->setCourseInfo($course);

        $em->persist($courseSection);
        $em->flush();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_SECTION_DELETE, ['id' => $courseSection->getId()])
        );

        $courseSectionId = $courseSection->getId();
        $token = $this->getCsrfToken('delete_section');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_SECTION_DELETE, ['id' => $courseSection->getId()]),
            ['remove_section' => [
                '_token' => $token
            ]]
        );

        $this->assertNull($em->getRepository(CourseSection::class)->find($courseSectionId));
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testDeleteCourseSectionWrongCsrfToken()
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourse();

        $courseSection = new CourseSection();
        $courseSection->setCourseInfo($course);

        $em->persist($courseSection);
        $em->flush();

        $token = $this->getCsrfToken('fake');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_SECTION_DELETE, ['id' => $courseSection->getId()]),
            ['remove_course_courseSection' => [
                '_token' => $token
            ]]
        );

        /** @var CourseSection $checkCourseSection */
        $checkCourseSection = $em->getRepository(CourseSection::class)->find($courseSection->getId());

        $this->assertInstanceOf(CourseSection::class, $checkCourseSection);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * @throws CourseNotFoundException
     * @throws \App\Syllabus\Exception\CourseSectionNotFoundException
     * @throws \App\Syllabus\Exception\UserNotFoundException
     */
    public function testAddCourseToSectionSuccessful()
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourse();
        $section = $this->getCourseSection();
        $course->addCourseSection($section);

        /** @var CourseSectionActivity $courseSectionActivity */
        $courseSectionActivity = $section->getCourseSectionActivities()->first();

        $activity = $courseSectionActivity->getActivity();
        $activityType = $activity->getActivityTypes()->first();


        $courseSection = new CourseSection();
        $courseSection->setCourseInfo($course);

        $em->persist($courseSection);
        $em->flush();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_SECTION_ACTIVITY_ADD,
                [
                    'id' => $section->getId(),
                    'activityId' => $activity->getId(),
                    'activityTypeId' => $activityType->getId()
                ]
            )
        );

        $token = $this->getCsrfToken('course_section_activity');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_SECTION_ACTIVITY_ADD,
                [
                    'id' => $courseSection->getId(),
                    'activityId' => $activity->getId(),
                    'activityTypeId' => $activityType->getId()
                ]
            ),
            [
                'course_section_activity' => [
                    "description" => "myDescription",
                    "activityType" => $activityType->getId() ,
                    "activityMode" => "79ca9545-02ae-4eb1-9893-ac97a0ea9104",
                    "evaluationRate" => "",
                    "_token" => $token
                ]
            ]
        );
        $courseSectionActivity = $this->getEntityManager()->getRepository(CourseSectionActivity::class)->findOneBy(['description' => 'myDescription']) ;
        $this->assertNotNull($courseSectionActivity);
    }

    /**
     * @throws CourseNotFoundException
     * @throws \App\Syllabus\Exception\CourseSectionNotFoundException
     * @throws \App\Syllabus\Exception\UserNotFoundException
     */
    public function testAddCourseToSectionFailed()
    {
        $em = $this->getEntityManager();
        $this->login();
        $course = $this->getCourse();
        $section = $this->getCourseSection();
        $course->addCourseSection($section);

        /** @var CourseSectionActivity $courseSectionActivity */
        $courseSectionActivity = $section->getCourseSectionActivities()->first();

        $activity = $courseSectionActivity->getActivity();
        $activityType = $activity->getActivityTypes()->first();


        $courseSection = new CourseSection();
        $courseSection->setCourseInfo($course);

        $em->persist($courseSection);
        $em->flush();


        $token = $this->getCsrfToken('fake');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_SECTION_ACTIVITY_ADD,
                [
                    'id' => $courseSection->getId(),
                    'activityId' => $activity->getId(),
                    'activityTypeId' => $activityType->getId()
                ]
            ),
            [
                'course_section_activity' => [
                    "description" => "myDescription",
                    "activityType" => $activityType->getId() ,
                    "activityMode" => "79ca9545-02ae-4eb1-9893-ac97a0ea9104",
                    "evaluationRate" => "",
                    "_token" => $token
                ]
            ]
        );
        $courseSectionActivity = $this->getEntityManager()->getRepository(CourseSectionActivity::class)->findOneBy(['description' => 'myDescription']) ;
        $this->assertNull($courseSectionActivity);
    }

  /*  public function testSortCourseSectionActivities {

    }*/
}