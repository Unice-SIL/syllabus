<?php


namespace Tests\Syllabus\Controller;


use App\Syllabus\Exception\CourseNotFoundException;
use Tests\WebTestCase;

class LightControllerTest extends WebTestCase
{
    /**
     * @throws CourseNotFoundException
     */
    public function testLightView()
    {
        $course = $this->getCourse(self::COURSE_ALLOWED_CODE, self::COURSE_ALLOWED_YEAR);
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_APP_COURSE_LIGHT_VIEW, ['id' => $course->getId()]));
        $this->assertResponseIsSuccessful();
    }
}