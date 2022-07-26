<?php

namespace Tests\Syllabus\Controller\Api;

use App\Syllabus\Fixture\UserFixture;
use App\Syllabus\Fixture\YearFixture;
use Symfony\Component\HttpFoundation\Response;

class CourseInfoControllerTest extends AbstractApiTest
{
    public function getRoute()
    {
        return $this->generateUrl(self::API_DUPLICATION_COURSE_INFO, [
            'code1' => self::COURSE_CODE1,
            'year1' => self::COURSE_YEAR,
            'code2' => self::COURSE_CODE2,
            'year2' => self::COURSE_YEAR,
        ]);
    }

    public function testDuplicationCourseInfo()
    {
        $this->requestApiUrl($this->getRoute());
        $this->assertResponseIsSuccessful();
    }

    public function testLoginAsUserForDuplicationCourseInfos()
    {
        $this->getToken([
            'username' => UserFixture::USER_2,
            'password' => UserFixture::PASSWORD_TEST,
        ]);

        $this->requestApiUrl($this->getRoute());
        $this->assertResponseStatusCodeSame(403);
    }

    /**
     * @dataProvider duplicationCourseInfoNotFound
     * @param $data
     */
    public function testDuplicationCourseInfoNotFound($data)
    {
        $this->requestApiUrl($data);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function duplicationCourseInfoNotFound()
    {
        return [
            [
                $this->generateUrl(self::API_DUPLICATION_COURSE_INFO, [
                    'code1' => 'fake',
                    'year1' => self::COURSE_YEAR,
                    'code2' => self::COURSE_CODE2,
                    'year2' => self::COURSE_YEAR,
                ])
            ],
            [
                $this->generateUrl(self::API_DUPLICATION_COURSE_INFO, [
                    'code1' => self::COURSE_CODE1,
                    'year1' => 'fake',
                    'code2' => self::COURSE_CODE2,
                    'year2' => self::COURSE_YEAR,
                ])
            ],
            [
                $this->generateUrl(self::API_DUPLICATION_COURSE_INFO, [
                    'code1' => self::COURSE_CODE1,
                    'year1' => self::COURSE_YEAR,
                    'code2' => 'fake',
                    'year2' => self::COURSE_YEAR,
                ])
            ],
            [
                $this->generateUrl(self::API_DUPLICATION_COURSE_INFO, [
                    'code1' => self::COURSE_CODE1,
                    'year1' => self::COURSE_YEAR,
                    'code2' => self::COURSE_CODE2,
                    'year2' => 'fake',
                ])
            ],
            [
                $this->generateUrl(self::API_DUPLICATION_COURSE_INFO, [
                    'code1' => self::COURSE_CODE1,
                    'year1' => YearFixture::YEAR_2013,
                    'code2' => self::COURSE_CODE2,
                    'year2' => self::COURSE_YEAR,
                ])
            ],
            [
                $this->generateUrl(self::API_DUPLICATION_COURSE_INFO, [
                    'code1' => self::COURSE_CODE1,
                    'year1' => self::COURSE_YEAR,
                    'code2' => self::COURSE_CODE2,
                    'year2' => YearFixture::YEAR_2013,
                ])
            ],
        ];
    }
}