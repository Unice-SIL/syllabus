<?php


namespace Tests\Syllabus\Controller\Admin;


use App\Syllabus\Entity\Activity;
use App\Syllabus\Entity\ActivityMode;
use App\Syllabus\Exception\ActivityModeNotFoundException;
use App\Syllabus\Exception\ActivityNotFoundException;
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
    public function tryUserNotAuthenticate($route, array $parameters = [])
    {
        $this->client()->request('GET', $this->generateUrl($route, $parameters));
    }

    /**
     * @param $route
     * @param array $parameters
     */
    public function tryWithAdminPermission($route, array $parameters = [])
    {
        $this->login();
        $this->client()->request('GET', $this->generateUrl($route, $parameters));
    }

    /**
     * @return Activity
     * @throws ActivityNotFoundException
     */
    public function getActivity()
    {
        $activity = null;
        if (!$activity instanceof Activity)
        {
            $activity = current($this->getEntityManager()->getRepository(Activity::class)->findAll());
        }

        if (!$activity instanceof Activity)
        {
            throw new ActivityNotFoundException();
        }

        return $activity;
    }

    /**
     * @return ActivityMode
     * @throws ActivityModeNotFoundException
     */
    public function getActivityMode()
    {
        $activityMode = null;
        if (!$activityMode instanceof ActivityMode)
        {
            $activityMode = current($this->getEntityManager()->getRepository(ActivityMode::class)->findAll());
        }

        if (!$activityMode instanceof ActivityMode)
        {
            throw new ActivityModeNotFoundException();
        }

        return $activityMode;
    }
}