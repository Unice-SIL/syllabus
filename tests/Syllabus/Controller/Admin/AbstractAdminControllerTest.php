<?php


namespace Tests\Syllabus\Controller\Admin;


use App\Syllabus\Entity\Activity;
use App\Syllabus\Entity\ActivityMode;
use App\Syllabus\Entity\ActivityType;
use App\Syllabus\Entity\Campus;
use App\Syllabus\Entity\CriticalAchievement;
use App\Syllabus\Entity\Domain;
use App\Syllabus\Entity\Equipment;
use App\Syllabus\Entity\Groups;
use App\Syllabus\Entity\Language;
use App\Syllabus\Entity\Level;
use App\Syllabus\Entity\Period;
use App\Syllabus\Entity\Structure;
use App\Syllabus\Entity\Year;
use App\Syllabus\Exception\ActivityModeNotFoundException;
use App\Syllabus\Exception\ActivityNotFoundException;
use App\Syllabus\Exception\ActivityTypeNotFoundException;
use App\Syllabus\Exception\CampusNotFoundException;
use App\Syllabus\Exception\CriticalAchievementNotFoundException;
use App\Syllabus\Exception\DomainNotFoundException;
use App\Syllabus\Exception\EquipmentNotFoundException;
use App\Syllabus\Exception\GroupsNotFoundException;
use App\Syllabus\Exception\LanguageNotFoundException;
use App\Syllabus\Exception\LevelNotFoundException;
use App\Syllabus\Exception\PeriodNotFoundException;
use App\Syllabus\Exception\StructureNotFoundException;
use App\Syllabus\Exception\UserNotFoundException;
use App\Syllabus\Exception\YearNotFoundException;
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

    /**
     * @return ActivityType
     * @throws ActivityTypeNotFoundException
     */
    public function getActivityType()
    {
        $activityType = null;
        if (!$activityType instanceof ActivityType)
        {
            $activityType = current($this->getEntityManager()->getRepository(ActivityType::class)->findAll());
        }

        if (!$activityType instanceof ActivityType)
        {
            throw new ActivityTypeNotFoundException();
        }

        return $activityType;
    }

    /**
     * @return Year
     * @throws YearNotFoundException
     */
    public function getYear()
    {
        $year = null;
        if (!$year instanceof Year)
        {
            $year = current($this->getEntityManager()->getRepository(Year::class)->findAll());
        }

        if (!$year instanceof Year)
        {
            throw new YearNotFoundException();
        }

        return $year;
    }

    /**
     * @return Campus
     * @throws CampusNotFoundException
     */
    public function getCampus()
    {
        $campus = null;
        if (!$campus instanceof Campus)
        {
            $campus = current($this->getEntityManager()->getRepository(Campus::class)->findAll());
        }

        if (!$campus instanceof Campus)
        {
            throw new CampusNotFoundException();
        }

        return $campus;
    }

    /**
     * @return CriticalAchievement
     * @throws CriticalAchievementNotFoundException
     */
    public function getCriticalAchievement()
    {
        $campus = null;
        if (!$campus instanceof CriticalAchievement)
        {
            $campus = current($this->getEntityManager()->getRepository(CriticalAchievement::class)->findAll());
        }

        if (!$campus instanceof CriticalAchievement)
        {
            throw new CriticalAchievementNotFoundException();
        }

        return $campus;
    }

    /**
     * @return Domain
     * @throws DomainNotFoundException
     */
    public function getDomain()
    {
        $domain = null;
        if (!$domain instanceof Domain)
        {
            $domain = current($this->getEntityManager()->getRepository(Domain::class)->findAll());
        }

        if (!$domain instanceof Domain)
        {
            throw new DomainNotFoundException();
        }

        return $domain;
    }

    /**
     * @return Equipment
     * @throws EquipmentNotFoundException
     */
    public function getEquipment()
    {
        $equipment = null;
        if (!$equipment instanceof Equipment)
        {
            $equipment = current($this->getEntityManager()->getRepository(Equipment::class)->findAll());
        }

        if (!$equipment instanceof Equipment)
        {
            throw new EquipmentNotFoundException();
        }

        return $equipment;
    }

    /**
     * @return Groups
     * @throws GroupsNotFoundException
     */
    public function getGroupsUser(): Groups
    {
        $groups = null;
        if (!$groups instanceof Groups)
        {
            $groups = current($this->getEntityManager()->getRepository(Groups::class)->findAll());
        }

        if (!$groups instanceof Groups)
        {
            throw new GroupsNotFoundException();
        }

        return $groups;
    }

    /**
     * @return Language
     * @throws LanguageNotFoundException
     */
    public function getLanguage()
    {
        $language = null;
        if (!$language instanceof Language)
        {
            $language = current($this->getEntityManager()->getRepository(Language::class)->findAll());
        }

        if (!$language instanceof Language)
        {
            throw new LanguageNotFoundException();
        }

        return $language;
    }

    /**
     * @return Period|object
     * @throws PeriodNotFoundException
     */
    public function getPeriod()
    {
        $period = null;
        if (!$period instanceof Period)
        {
            $period = current($this->getEntityManager()->getRepository(Period::class)->findAll());
        }

        if (!$period instanceof Period)
        {
            throw new PeriodNotFoundException();
        }

        return $period;
    }

    /**
     * @return Structure
     * @throws StructureNotFoundException
     */
    public function getStructure()
    {
        $structure = null;
        if (!$structure instanceof Structure)
        {
            $structure = current($this->getEntityManager()->getRepository(Structure::class)->findAll());
        }

        if (!$structure instanceof Structure)
        {
            throw new StructureNotFoundException();
        }

        return $structure;
    }

    /**
     * @param $url
     * @param array $query
     * @return mixed
     * @throws UserNotFoundException
     */
    public function getAutocompleteJson($url, array $query)
    {
        $this->login();
        $this->client()->request(
            Request::METHOD_GET,
            $url,
            $query
        );
        $response = $this->client()->getResponse();
        $this->assertResponseIsSuccessful();
        return json_decode($response->getContent(), true);
    }
}