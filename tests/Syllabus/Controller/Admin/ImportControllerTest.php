<?php


namespace Tests\Syllabus\Controller\Admin;

use App\Syllabus\Exception\CourseNotFoundException;
use App\Syllabus\Exception\UserNotFoundException;
use App\Syllabus\Fixture\CourseFixture;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ImportControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class ImportControllerTest extends AbstractAdminControllerTest
{
    public static function saveToCsv(array $data)
    {
        $file = fopen(__DIR__ . '/data.csv', 'w');
        foreach ($data as $row) {
            fputcsv($file, $row, ';');
        }
        fclose($file);
    }

    public function testImportCourseInfoUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_IMPORT_COURSE_INFO);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testImportCourseInfoWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_IMPORT_COURSE_INFO);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider importCourseInfoSuccessfulProvider
     * @param array $data
     * @return void
     * @throws UserNotFoundException
     */
    public function testImportCourseInfoSuccessful(array $data)
    {
        self::saveToCsv($data);
        $file = new UploadedFile(__DIR__ . '/data.csv', 'data.csv');
        $user = $this->getUser();
        $this->login($user);
        $crawler = $this->client()->request(
            Request::METHOD_GET,
            $this->generateUrl(self::ROUTE_ADMIN_IMPORT_COURSE_INFO)
        );
        $this->assertResponseIsSuccessful();
        $this->submitForm(
            $crawler->filter('button[type="submit"]'),
            'import',
            [
                'file' => $file,
            ]
        );
        unlink($file);
        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_ADMIN_IMPORT_COURSE_INFO));
    }

    /**
     * @return \array[][]
     * @throws CourseNotFoundException
     */
    public function importCourseInfoSuccessfulProvider(): array
    {
        $courseInfo = $this->getCourseInfo(CourseFixture::COURSE_1);
        return [
            [
                [
                    ['code', 'year'],
                    [$courseInfo->getCourse()->getCode(), $courseInfo->getYear()->getId()]
                ]
            ],
            [
                [
                    [
                        'code', 'year', 'structure', 'title', 'ects', 'summary', 'teachingMode', 'teachingCmClass',
                        'teachingTdClass', 'teachingTpClass', 'teachingOtherClass', 'teachingOtherTypeClass',
                        'teachingCmHybridClass', 'teachingTdHybridClass', 'teachingTpHybridClass', 'teachingOtherHybridClass',
                        'teachingOtherTypeHybridClass', 'teachingCmHybridDist', 'teachingTdHybridDist', 'teachingOtherHybridDist',
                        'teachingOtherTypeHybridDistant', 'teachingCmDist', 'teachingTdDist', 'teachingOtherDist', 'teachingOtherTypeDist',
                        'mccWeight', 'mccCapitalizable', 'mccCompensable', 'evaluationType', 'mccCtCoeffSession1', 'mccCcNbEvalSession1',
                        'mccCtNatSession1', 'mccCtDurationSession1', 'mccAdvice', 'tutoring', 'tutoringTeacher', 'tutoringStudent',
                        'tutoringDescription', 'educationalResources', 'bibliographicResources', 'agenda', 'organization', 'closingRemarks'
                    ],
                    [
                        $courseInfo->getCourse()->getCode(),
                        $courseInfo->getYear()->getId(),
                        $courseInfo->getStructure()->getCode(),
                        '',
                        '',
                        '',
                        $courseInfo->getTeachingMode(),
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        $courseInfo->isMccCapitalizable(),
                        $courseInfo->isMccCompensable(),
                        'CC',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        ''
                    ]
                ]
            ],
            [
                [
                    [
                        'code', 'year', 'structure', 'title', 'ects', 'summary', 'teachingMode', 'teachingCmClass',
                        'teachingTdClass', 'teachingTpClass', 'teachingOtherClass', 'teachingOtherTypeClass',
                        'teachingCmHybridClass', 'teachingTdHybridClass', 'teachingTpHybridClass', 'teachingOtherHybridClass',
                        'teachingOtherTypeHybridClass', 'teachingCmHybridDist', 'teachingTdHybridDist', 'teachingOtherHybridDist',
                        'teachingOtherTypeHybridDistant', 'teachingCmDist', 'teachingTdDist', 'teachingOtherDist', 'teachingOtherTypeDist',
                        'mccWeight', 'mccCapitalizable', 'mccCompensable', 'evaluationType', 'mccCtCoeffSession1', 'mccCcNbEvalSession1',
                        'mccCtNatSession1', 'mccCtDurationSession1', 'mccAdvice', 'tutoring', 'tutoringTeacher', 'tutoringStudent',
                        'tutoringDescription', 'educationalResources', 'bibliographicResources', 'agenda', 'organization', 'closingRemarks'
                    ],
                    [
                        $courseInfo->getCourse()->getCode(),
                        $courseInfo->getYear()->getId(),
                        $courseInfo->getStructure()->getCode(),
                        $courseInfo->getTitle(),
                        $courseInfo->getEcts(),
                        $courseInfo->getSummary(),
                        $courseInfo->getTeachingMode(),
                        $courseInfo->getTeachingCmClass(),
                        $courseInfo->getTeachingTdClass(),
                        $courseInfo->getTeachingTpClass(),
                        $courseInfo->getTeachingOtherClass(),
                        $courseInfo->getTeachingOtherTypeClass(),
                        $courseInfo->getTeachingCmHybridClass(),
                        $courseInfo->getTeachingTdHybridClass(),
                        $courseInfo->getTeachingTpHybridClass(),
                        $courseInfo->getTeachingOtherHybridClass(),
                        $courseInfo->getTeachingOtherTypeHybridClass(),
                        $courseInfo->getTeachingCmHybridDist(),
                        $courseInfo->getTeachingTdHybridDist(),
                        $courseInfo->getTeachingOtherHybridDist(),
                        $courseInfo->getTeachingOtherTypeHybridDistant(),
                        $courseInfo->getTeachingCmDist(),
                        $courseInfo->getTeachingTdDist(),
                        $courseInfo->getTeachingOtherDist(),
                        $courseInfo->getTeachingOtherTypeDist(),
                        $courseInfo->getMccWeight(),
                        $courseInfo->isMccCapitalizable(),
                        $courseInfo->isMccCompensable(),
                        'CC',
                        $courseInfo->getMccCtCoeffSession1(),
                        $courseInfo->getMccCtNatSession1(),
                        $courseInfo->getMccCtDurationSession1(),
                        $courseInfo->getMccAdvice(),
                        $courseInfo->isTutoring(),
                        $courseInfo->isTutoringStudent(),
                        $courseInfo->isTutoringTeacher(),
                        $courseInfo->getTutoringDescription(),
                        $courseInfo->getEducationalResources(),
                        $courseInfo->getBibliographicResources(),
                        $courseInfo->getAgenda(),
                        $courseInfo->getOrganization(),
                        $courseInfo->getClosingRemarks()
                    ]
                ]
            ],
        ];
    }

    public function testImportPermissionUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_IMPORT_PERMISSION);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testImportPermissionWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_IMPORT_PERMISSION);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider importPermissionSuccessfulProvider
     * @param array $data
     * @return void
     * @throws UserNotFoundException
     */
    public function testImportPermissionSuccessful(array $data)
    {
        self::saveToCsv($data);
        $file = new UploadedFile(__DIR__ . '/data.csv', 'data.csv');
        $user = $this->getUser();
        $this->login($user);
        $crawler = $this->client()->request(
            Request::METHOD_GET,
            $this->generateUrl(self::ROUTE_ADMIN_IMPORT_PERMISSION)
        );
        $this->assertResponseIsSuccessful();
        $this->submitForm(
            $crawler->filter('button[type="submit"]'),
            'import',
            [
                'file' => $file,
            ]
        );
        unlink($file);
        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_ADMIN_IMPORT_PERMISSION));
    }

    /**
     * @return \array[][]
     * @throws CourseNotFoundException
     * @throws UserNotFoundException
     */
    public function importPermissionSuccessfulProvider(): array
    {
        $courseInfo = $this->getCourseInfo();
        return [
            [
                [
                    ['code', 'year', 'username', 'permission'],
                    [
                        $courseInfo->getCourse()->getCode(),
                        $courseInfo->getYear()->getId(),
                        $this->getUser()->getUsername(),
                        'READ'
                    ]
                ]
            ],
        ];
    }

    public function testImportUserUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_IMPORT_USER);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testImportUserWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_IMPORT_USER);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider importUserSuccessfulProvider
     * @param array $data
     * @return void
     * @throws UserNotFoundException
     */
    public function testImportUserSuccessful(array $data)
    {
        self::saveToCsv($data);
        $file = new UploadedFile(__DIR__ . '/data.csv', 'data.csv');
        $user = $this->getUser();
        $this->login($user);
        $crawler = $this->client()->request(
            Request::METHOD_GET,
            $this->generateUrl(self::ROUTE_ADMIN_IMPORT_USER)
        );
        $this->assertResponseIsSuccessful();
        $this->submitForm(
            $crawler->filter('button[type="submit"]'),
            'import',
            [
                'file' => $file,
            ]
        );
        unlink($file);
        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_ADMIN_IMPORT_USER));
    }

    public function importUserSuccessfulProvider()
    {
        return [
            [
                [
                    ['username', 'firstname', 'lastname', 'email'],
                    ['scurry', 'Stephen', 'Curry', 'scurry@warriors.com']
                ]
            ],
        ];
    }
}