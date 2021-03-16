<?php


namespace Tests\Syllabus\Controller\Admin;


use App\Syllabus\Entity\Activity;
use App\Syllabus\Entity\ActivityMode;
use App\Syllabus\Entity\ActivityType;
use App\Syllabus\Entity\Campus;
use App\Syllabus\Entity\Domain;
use App\Syllabus\Entity\Equipment;
use App\Syllabus\Entity\Language;
use App\Syllabus\Entity\Level;
use App\Syllabus\Entity\Period;
use App\Syllabus\Entity\Structure;
use App\Syllabus\Entity\Year;
use App\Syllabus\Exception\ActivityModeNotFoundException;
use App\Syllabus\Exception\ActivityNotFoundException;
use App\Syllabus\Exception\ActivityTypeNotFoundException;
use App\Syllabus\Exception\CampusNotFoundException;
use App\Syllabus\Exception\DomainNotFoundException;
use App\Syllabus\Exception\EquipmentNotFoundException;
use App\Syllabus\Exception\LanguageNotFoundException;
use App\Syllabus\Exception\LevelNotFoundException;
use App\Syllabus\Exception\PeriodNotFoundException;
use App\Syllabus\Exception\StructureNotFoundException;
use App\Syllabus\Exception\YearNotFoundException;
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
     * @return Level
     * @throws LevelNotFoundException
     */
    public function getLevel()
    {
        $level = null;
        if (!$level instanceof Level)
        {
            $level = current($this->getEntityManager()->getRepository(Level::class)->findAll());
        }

        if (!$level instanceof Level)
        {
            throw new LevelNotFoundException();
        }

        return $level;
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
}