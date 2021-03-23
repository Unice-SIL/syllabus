<?php


namespace Tests\Syllabus\Controller;

use Tests\WebTestCase;

/**
 * Class MaintenanceControllerTest
 * @package Tests\Syllabus\Controller
 */
class MaintenanceControllerTest extends WebTestCase
{
    public function testMaintenanceView()
    {
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_APP_MAINTENANCE));
        $this->assertResponseIsSuccessful();
    }
}