<?php


namespace Tests\Syllabus\Controller\CourseInfo;

use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Exception\CourseNotFoundException;
use App\Syllabus\Exception\UserNotFoundException;
use App\Syllabus\Fixture\UserFixture;
use Symfony\Component\HttpFoundation\Response;

class TutoringControllerTest extends AbstractCourseInfoControllerTest
{
    /**
     * @var CourseInfo
     */
    private $course;

    /**
     * @throws CourseNotFoundException
     */
    protected function setUp(): void
    {
        $this->course = $this->getCourse();
    }

    public function testAddTutoringUserNotAuthenticated()
    {
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_TUTORING_CREATE, ['id' => $this->course->getId()])
        );
        $this->assertRedirectToLogin();
    }

    /**
     * @throws CourseNotFoundException
     * @throws UserNotFoundException
     */
    public function testAddTutoringForbidden()
    {
        $this->login(UserFixture::USER_2);
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_TUTORING_CREATE, [
                'id' => $this->getCourse(self::COURSE_NOT_ALLOWED_CODE)->getId()
            ])
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @dataProvider addTutoringSuccessfulProvider
     * @throws CourseNotFoundException
     * @throws UserNotFoundException
     */
    public function testAddTutoringSuccessful($data)
    {
        $this->login();
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_TUTORING_CREATE, [
                'id' => $this->getCourse(self::COURSE_NOT_ALLOWED_CODE)->getId()
            ])
        );

        $data['_token'] = $this->getCsrfToken('course_assist_tutoring');

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_TUTORING_CREATE, ['id' => $this->course->getId()]),
            ['course_assist_tutoring' => $data]
        );

        $this->assertResponseIsSuccessful();
        $this->getEntityManager()->clear();
        $this->assertCheckEntityProps($this->getCourse(), $data);
    }

    /**
     * @return array
     */
    public function addTutoringSuccessfulProvider(): array
    {
        return [
            [
                [
                    'tutoringTeacher' => true,
                    'tutoringStudent' => true,
                    'tutoringDescription' => 'test'
                ]
            ],
            [
                [
                    'tutoringTeacher' => true,
                    'tutoringDescription' => null
                ]
            ]
        ];
    }

    /**
     * @throws CourseNotFoundException
     * @throws UserNotFoundException
     */
    public function testAddTutoringInvalidToken()
    {
        $this->login();
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_TUTORING_CREATE, [
                'id' => $this->getCourse(self::COURSE_NOT_ALLOWED_CODE)->getId()
            ])
        );

        $data = [
            'tutoringDescription' => 'invalidToken',
            '_token' => 'invalidToken',
        ];

        if (!$this->course->isTutoringTeacher()) {
            $data['tutoringTeacher'] = true;
        }

        if (!$this->course->isTutoringStudent()) {
            $data['tutoringStudent'] = true;
        }

        $this->client()->request(
            'POST',
            $this->generateUrl(self::ROUTE_APP_COURSE_TUTORING_CREATE, ['id' => $this->course->getId()]),
            ['course_assist_tutoring' => $data]
        );

        $this->assertResponseIsSuccessful();
        $this->getEntityManager()->clear();
        $this->assertCheckNotSameEntityProps($this->getCourse(), $data);
    }


    public function testActiveTutoringUserNotAuthenticated()
    {
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_TUTORING_ACTIVE, [
                'id' => $this->course->getId(),
                'action' => 1
            ])
        );
        $this->assertRedirectToLogin();
    }

    /**
     * @throws UserNotFoundException
     */
    public function testActiveTutoringForbidden()
    {
        $this->login(UserFixture::USER_2);
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_TUTORING_ACTIVE, [
                'id' => $this->course->getId(),
                'action' => 1
            ])
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @dataProvider activeTutoringSuccessfulProvider
     * @param $active
     * @throws CourseNotFoundException|UserNotFoundException
     */
    public function testActiveTutoringUserSuccessful($active)
    {
        $this->login();
        $this->client()->request(
            'GET',
            $this->generateUrl(self::ROUTE_APP_COURSE_TUTORING_ACTIVE, [
                'id' => $this->course->getId(),
                'action' => $active
            ])
        );
        $this->assertResponseIsSuccessful();
        $this->assertEquals($active, $this->getCourse()->isTutoring());
    }
    /**
     * @return array
     */
    public function activeTutoringSuccessfulProvider(): array
    {
        return [
            [1],
            [0]
        ];
    }

}