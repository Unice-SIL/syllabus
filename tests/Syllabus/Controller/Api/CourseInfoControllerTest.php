<?php

namespace Tests\Syllabus\Controller\Api;

class CourseInfoControllerTest extends AbstractApiTest
{
    public function testDuplicationCourseInfo()
    {
        $url = $this->generateUrl(self::API_DUPLICATION_COURSE_INFO, [
            'code1' => self::COURSE_CODE1,
            'year1' => self::COURSE_YEAR,
            'code2' => self::COURSE_CODE2,
            'year2' => self::COURSE_YEAR,
        ]);
        $this->requestApiUrl($url);
        $this->assertResponseIsSuccessful();
    }
}