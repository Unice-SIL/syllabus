<?php


namespace App\Syllabus\Repository\Doctrine;


use App\Syllabus\Entity\CourseInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class StatisticSyllabusDoctrineRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CourseInfo::class);
    }

    public function getSyllabusPublished(string $year){
        //date de publication
        return $this->_em->getRepository(CourseInfo::class)
            ->createQueryBuilder('ci')
            ->where('ci.publicationDate IS NOT NULL')
            ->andWhere('ci.year = ?1')
            ->setParameter(1, $year)
            ->getQuery()
            ->getResult();
    }

    public function getSyllabusBeingFilled(string $year){
        // si pas de date de publication et que le resumé est rempli
        return $this->_em->getRepository(CourseInfo::class)
            ->createQueryBuilder('ci')
            ->where('ci.publicationDate IS NULL')
            ->andWhere('ci.summary IS NOT NULL')
            ->andWhere('ci.year = ?1')
            ->setParameter(1, $year)
            ->getQuery()
            ->getResult();
    }

}