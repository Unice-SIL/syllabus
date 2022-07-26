<?php


namespace Tests\Syllabus\Controller\Admin;

use App\Syllabus\Exception\CourseNotFoundException;
use App\Syllabus\Exception\GroupsNotFoundException;

/**
 * Class GroupsControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class SyllabusControllerTest extends AbstractAdminControllerTest
{
    public function testSyllabusListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_SYLLABUS_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testSyllabusListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_SYLLABUS_LIST);
        $this->assertResponseIsSuccessful();
    }

    public function testSyllabusExportWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_SYLLABUS_LIST, ['isExport' => true]);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider providerSyllabusFilter
     * @param array $filter
     * @return void
     */
    public function testSyllabusFilter(array $filter)
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_SYLLABUS_LIST, [
            'course_info_filter' => $filter
        ]);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @return array
     * @throws GroupsNotFoundException
     * @throws CourseNotFoundException
     */
    public function providerSyllabusFilter()
    {
        return [
            [
                [
                    'title' => $this->getGroupsUser()->getLabel()
                ]
            ],
            [
                [
                    'publicationDate' => false
                ]
            ],
            [
                [
                    'structure' =>
                        [
                            'label' => $this->getCourseInfo()->getStructure()->getLabel()
                        ]
                ]
            ],
            [
                [
                    'year' =>
                        [
                            'label' => $this->getCourseInfo()->getYear()->getLabel()
                        ]
                ]
            ]
        ];
    }
}