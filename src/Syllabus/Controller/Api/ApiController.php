<?php

namespace App\Syllabus\Controller\Api;

use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\Year;
use App\Syllabus\Exception\CourseInfoAlreadyExistException;
use App\Syllabus\Exception\CourseInfoNotFoundException;
use App\Syllabus\Exception\YearNotFoundException;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * Class CourseController
 * @package App\Syllabus\Controller
 *
 * @Route("course", name="app.api.")
 * @Security("is_granted('ROLE_API')")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/{code1}/{year1}/{code2}/{year2}", name="duplicate", methods={"GET"})
     * @Security("is_granted('ROLE_API_DUPLICATE_SYLLABUS')")
     */
    public function duplicationSyllabusAction($code1, $year1, $code2, $year2, EntityManager $em)
    {
        $year = $em->getRepository(Year::class)->find($year1);
        $nextYear = $em->getRepository(Year::class)->find($year2);

        if(!$year instanceof Year || !$nextYear instanceof Year)
        {
            throw new YearNotFoundException();
        }

        $courseInfo = $em->getRepository(CourseInfo::class)->findOneBy([
            'year' => $year,
            'code' => $code1
            // 'duplicateNextYear' => true
        ]);

        if (!$courseInfo instanceof CourseInfo)
        {
            throw new CourseInfoNotFoundException();
        }

        $nextCourseInfo = $em->getRepository(CourseInfo::class)->findOneBy([
            'year' => $year2,
            'code' => $code2
        ]);

        if (!is_null($nextCourseInfo))
        {
            throw new CourseInfoAlreadyExistException();
        }

        return;
    }
}