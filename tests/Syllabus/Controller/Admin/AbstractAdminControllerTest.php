<?php


namespace Tests\Syllabus\Controller\Admin;


use Tests\WebTestCase;

/**
 * Class AbstractAdminControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
abstract class AbstractAdminControllerTest extends WebTestCase
{
    /**
     * @param $route
     */
    public function tryUserNotAuthenticate($route)
    {
        $this->client()->request('GET', $this->generateUrl($route));
    }

    /**
     * @param $route
     */
    public function tryWithAdminPermission($route)
    {
        $this->login();
        $this->client()->request('GET', $this->generateUrl($route));
    }
}