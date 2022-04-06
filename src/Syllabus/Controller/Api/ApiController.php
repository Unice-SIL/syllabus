<?php

namespace App\Syllabus\Controller\Api;

use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\Year;
use App\Syllabus\Manager\CourseInfoManager;
use App\Syllabus\Repository\Doctrine\CourseInfoDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * Class CourseController
 * @package App\Syllabus\Controller
 *
 * @Route(name="app.api.")
 * @Security("is_granted('ROLE_API')")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/{code1}/{year1}/{code2}/{year2}", name="duplicate", methods={"GET"})
     * @Security("is_granted('ROLE_API_DUPLICATE_SYLLABUS')")
     * @throws Exception
     */
    public function duplicationSyllabusAction(
        $code1, $year1, $code2, $year2,
        EntityManagerInterface $em,
        CourseInfoManager $courseInfoManager,
        CourseInfoDoctrineRepository $courseInfoDoctrineRepository
    ) {
        if(!$em->getRepository(Year::class)->find($year1) instanceof Year)
        {
            return $this->json(
                'L\'année ' . $year1 . ' n\'a pas été trouvée',
                Response::HTTP_NOT_FOUND
            );
        }

        if(!$em->getRepository(Year::class)->find($year2) instanceof Year)
        {
            return $this->json(
                'L\'année ' . $year2 . ' n\'a pas été trouvée',
                Response::HTTP_NOT_FOUND
            );
        }

        $courseInfo = $courseInfoDoctrineRepository->findByCodeAndYear($code1, $year1);
        // 'duplicateNextYear' => true

        if (!$courseInfo instanceof CourseInfo)
        {
            return $this->json(
                'Le syllabus pour ' . $code1 . ' - ' . $year1 . ' n\'a pas été trouvé',
                Response::HTTP_NOT_FOUND
            );
        }

        $nextCourseInfo = $courseInfoDoctrineRepository->findByCodeAndYear($code2, $year2);

        if (is_null($nextCourseInfo))
        {
            return $this->json(
                'Le syllabus pour ' . $code2 . ' - ' . $year2 . ' n\'a pas été trouvé',
                Response::HTTP_NOT_FOUND
            );
        }

        $courseInfoManager->duplicate(
            "{$code1}__UNION__{$year1}",
            "{$code2}__UNION__{$year2}",
            CourseInfoManager::DUPLICATION_CONTEXTE_MANUALLY
        );

        $em->flush();

        return $this->json('');
    }
}
