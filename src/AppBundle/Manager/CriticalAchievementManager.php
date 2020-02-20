<?php


namespace AppBundle\Manager;


use AppBundle\Entity\CriticalAchievement;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

class CriticalAchievementManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * CriticalAchievementManager constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return CriticalAchievement
     */
    public function create()
    {
        return new CriticalAchievement();
    }
}