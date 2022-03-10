<?php


namespace Tests\Syllabus\Controller\Admin;

use App\Syllabus\Exception\UserNotFoundException;
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

    public function importCourseInfoSuccessfulProvider()
    {
        return [
            [
                [
                    ['code', 'year'],
                    ['TEST', '2022']
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

    public function importPermissionSuccessfulProvider()
    {
        $courseInfo = $this->getCourseInfo();
        return [
            [
                [
                    ['code', 'year', 'username', 'permission'],
                    ['CODE', '2022', 'scurry', 'READ']
                ]
            ],
            [
                [
                    ['code', 'year', 'username', 'permission'],
                    [
                        $courseInfo->getCourse()->getCode(),
                        $courseInfo->getYear(),
                        'scurry',
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