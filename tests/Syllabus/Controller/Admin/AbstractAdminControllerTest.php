<?php


namespace Tests\Syllabus\Controller\Admin;


use Symfony\Component\HttpFoundation\Request;
use Tests\WebTestCase;

/**
 * Class AbstractAdminControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
abstract class AbstractAdminControllerTest extends WebTestCase
{
    /**
     * @param $route
     * @param array $parameters
     */
    public function tryUserNotAuthenticate($route, array $parameters = [], string $method = Request::METHOD_GET)
    {
        $this->client()->request($method, $this->generateUrl($route, $parameters));
    }

    /**
     * @param $route
     * @param array $parameters
     */
    public function tryWithAdminPermission($route, array $parameters = [], string $method = Request::METHOD_GET)
    {
        $this->login();
        $this->client()->request($method, $this->generateUrl($route, $parameters));
    }
}