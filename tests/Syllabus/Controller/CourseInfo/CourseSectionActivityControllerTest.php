<?php


namespace Tests\Syllabus\Controller\CourseInfo;

use App\Syllabus\Entity\Activity;
use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\CourseSection;
use App\Syllabus\Entity\CourseSectionActivity;
use App\Syllabus\Exception\CourseNotFoundException;
use App\Syllabus\Fixture\CourseFixture;

/**
 * Class CourseSectionActivityControllerTest
 * @package Tests\Syllabus\Controller\CourseInfo
 */
class CourseSectionActivityControllerTest extends AbstractCourseInfoControllerTest
{
    /**
     * @dataProvider editCourseSectionActivitySuccessfulProvider
     * @param array $data
     */
    public function testEditCourseSectionActivitySuccessful(array $data)
    {
        $this->login();
        $em = $this->getEntityManager();
        /** @var CourseInfo $courseInfo */
        $courseInfo = $this->getCourseInfo(CourseFixture::COURSE_1);

        /** @var CourseSection $section */
        $section = $courseInfo->getCourseSections()->first();

        /** @var CourseSectionActivity $courseSectionActivity */
        $courseSectionActivity = $section->getCourseSectionActivities()->first();

        /** @var Activity $activity */
        $activity = $courseSectionActivity->getActivity();

        $this->client()->request(
            'GET',   $this->generateUrl(self::ROUTE_APP_COURSE_SECTION_ACTIVITY_EDIT,
             [
                 'id' => $courseSectionActivity->getId(),
                 'activityId' => $activity->getId()
             ]
        )
        );
        $data['_token'] = $this->getCsrfToken('course_section_activity');
        $data['activityType'] = $courseSectionActivity->getActivityType()->getId();
        $data['activityMode'] = $courseSectionActivity->getActivityMode()->getId();

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_SECTION_ACTIVITY_EDIT,
                [
                    'id' => $courseSectionActivity->getId(),
                    'activityId' => $activity->getId()
                ]),
            ['course_section_activity' => $data]
        );

        self::assertTrue(true);

        /** @var CourseSectionActivity $updatedCourseSectionActivity */
        $updatedCourseSectionActivity = $em->getRepository(CourseSectionActivity::class)->findOneBy(
            [
                'id' => $courseSectionActivity->getId()
            ]
        );
        $this->assertEquals($updatedCourseSectionActivity->getDescription(), $data['description']);
    }

    /**
     * @return array
     */
    public function editCourseSectionActivitySuccessfulProvider(): array
    {
        return [
            [
                [
                    'description' => 'CoursSectionActivityTest',
                    "evaluationRate" => ""
                ]
            ],
            [
                [
                    'description' => null,
                    "evaluationRate" => ""
                ]
            ]
        ];
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testDeleteCourseSectionActivitySuccessful()
    {
        $em = $this->getEntityManager();
        $this->login();

        $section = $this->getCourseSection();
        /** @var CourseSectionActivity $courseSectionActivity */
        $courseSectionActivity = $section->getCourseSectionActivities()->first();
        $courseSectionActivity->setDescription('tata');
        /** @var Activity $activity */
        $activity = $courseSectionActivity->getActivity();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_SECTION_ACTIVITY_DELETE,
                [
                    'id' => $courseSectionActivity->getId(),
                    'activityId' => $activity->getId()
                ]
            )
        );

        $token = $this->getCsrfToken('remove_course_section_activity');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_SECTION_ACTIVITY_DELETE, ['id' => $courseSectionActivity->getId()]),
            ['remove_course_section_activity' => [
                '_token' => $token
            ]]
        );
        $this->assertNull($em->getRepository(CourseSectionActivity::class)->find(['id' => $courseSectionActivity->getId()]));
    }

    public function testDeleteCourseSectionActivityFailedWithCsrfNotValid()
    {
        $em = $this->getEntityManager();
        $this->login();

        $section = $this->getCourseSection();
        /** @var CourseSectionActivity $courseSectionActivity */
        $courseSectionActivity = $section->getCourseSectionActivities()->first();
        $courseSectionActivity->setDescription('tata');
        /** @var Activity $activity */
        $activity = $courseSectionActivity->getActivity();

        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_SECTION_ACTIVITY_DELETE,
                [
                    'id' => $courseSectionActivity->getId(),
                    'activityId' => $activity->getId()
                ]
            )
        );

        $token = $this->getCsrfToken('fake');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_SECTION_ACTIVITY_DELETE, ['id' => $courseSectionActivity->getId()]),
            ['remove_course_section_activity' => [
                '_token' => $token
            ]]
        );
        $this->assertNotNull($em->getRepository(CourseSectionActivity::class)->find(['id' => $courseSectionActivity->getId()]));
    }
}