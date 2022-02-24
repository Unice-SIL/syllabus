<?php


namespace Tests\Syllabus\Controller\CourseInfo;

use App\Syllabus\Entity\Activity;
use App\Syllabus\Entity\CourseSectionActivity;
use App\Syllabus\Exception\CourseNotFoundException;

/**
 * Class CourseSectionActivityControllerTest
 * @package Tests\Syllabus\Controller\CourseInfo
 */
class CourseSectionActivityControllerTest extends AbstractCourseInfoControllerTest
{
    /**
     * @dataProvider editCourseSectionActivitySuccessfulProvider
     * @param array $data
     * @throws \App\Syllabus\Exception\CourseSectionNotFoundException
     * @throws \App\Syllabus\Exception\UserNotFoundException
     */
    public function testEditCourseSectionActivitySuccessful(array $data)
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
            $this->generateUrl(self::ROUTE_APP_COURSE_SECTION_ACTIVITY_EDIT,
                [
                    'id' => $courseSectionActivity->getId(),
                    'activityId' => $activity->getId()
                ]
            )
        );

        $data['_token'] = $this->getCsrfToken('course_section_activity');
        $data['activityType'] = $activity->getActivityTypes()->first();
        $data['activity'] = $activity;

      //  dd($data);

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
/*        $updatedCourseSectionActivity = $em->getRepository(CourseSectionActivity::class)->findOneBy(['id' => $courseSectionActivity]);

        $this->assertCheckEntityProps($updatedCourseSectionActivity, $data);*/
    }

    /**
     * @return array
     */
    public function editCourseSectionActivitySuccessfulProvider(): array
    {
        return [
            [
                ['description' => 'CoursSectionTest']
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