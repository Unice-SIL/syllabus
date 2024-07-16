<?php

namespace App\Syllabus\Controller\Common;

use App\Syllabus\Constant\Permission;
use App\Syllabus\Constant\UserRole;
use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\Structure;
use App\Syllabus\Repository\Doctrine\UserDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Twig\Environment;
use function Symfony\Component\DependencyInjection\Loader\Configurator\expr;

/**
 * Class AutoCompleteController
 * @package App\Syllabus\Controller\Common
 *
 * @Route("common/autocomplete", name="app.common.autocomplete.")
 */
class AutoCompleteController extends AbstractController
{
    /**
     * @Route("/generic/{entityName}", name="generic")
     *
     * @param string $entityName
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function autoComplete(string $entityName, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $namespace = 'App\Syllabus\\Entity\\';
        $entityName = "{$namespace}{$entityName}";

        $parameters = $request->query->all();

        $query = $parameters['query'] ?? '' ;
        $findBy = $parameters['findBy'] ?? 'label' ;
        $property = $parameters['property'] ?? 'label' ;

        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $repository = $em->getRepository($entityName);
        $entities = $repository->findLikeQuery($query, $findBy);

        $entities = array_map(function ($entity) use ($propertyAccessor, $property) {
            return $propertyAccessor->getValue($entity, $property);
        }, $entities);

        $entities = array_unique($entities);
        $entities = array_values($entities);

        return $this->json(['query' => $query, 'suggestions' => $entities, 'data' => $entities]);
    }

    /**
     * @Route("/generic-s2/{entityName}", name="generic_s2")
     *
     * @param string $entityName
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function autoCompleteS2(string $entityName, Request $request, EntityManagerInterface $em): JsonResponse
    {


        $namespace = 'App\Syllabus\\Entity\\';
        $entityName = "{$namespace}{$entityName}";

        $allParameters = $request->query->all();

        $query = $allParameters['q'] ?? '';

        $findBy = $allParameters['findBy'] ?? 'label';

        $findByOther = $allParameters['findByOther'] ?? [];
        $property = $allParameters['property'] ?? 'label';
        $groupProperty = $allParameters['groupProperty'] ?? null;

        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $repository = $em->getRepository($entityName);
        $entities = $repository->findByFilters(array_merge($findByOther, [$findBy => $query]));

        $data = [];
        foreach ($entities as $entity) {
            $d = ['id' => $entity->getId(), 'text' => $propertyAccessor->getValue($entity, $property)];
            if (!empty($groupProperty)) {
                $group = $propertyAccessor->getValue($entity, $groupProperty) ?? 0;
                if (!array_key_exists($group, $data)) {
                    $data[$group] = ['text' => $propertyAccessor->getValue($entity, $groupProperty), 'children' => []];
                }
                $data[$group]['children'][] = $d;
            } else {
                $data[] = $d;
            }
        }
        //dd($data);
        ksort($data);

        return $this->json(array_values($data));
    }

    /**
     * @Route("/generic-s2-courses/{entityName}", name="generic_s2_courses")
     *
     * @param string $entityName
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function autoCompleteS2Courses(string $entityName, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $namespace = 'App\Syllabus\\Entity\\';
        $entityName = "{$namespace}{$entityName}";

        $parameters = $request->query->all();

        $query = $parameters['q'] ?? '';
        $property = $parameters['property'] ?? 'label';
        $propertyOptional = $parameters['property_optional'] ?? null;
        $groupProperty = $parameters['groupProperty'] ?? null;

        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $repository = $em->getRepository($entityName);
        $entities = $repository->findByTitleOrCode($query);

        $data = [];
        foreach ($entities as $entity) {
            $text = $propertyAccessor->getValue($entity, $property);
            if ($propertyOptional !== null) {
                $text .= ' (' . $propertyAccessor->getValue($entity, $propertyOptional) . ')';
            }
            $d = ['id' => $entity->getId(), 'text' => $text];
            if (!empty($groupProperty)) {
                $group = $propertyAccessor->getValue($entity, $groupProperty) ?? 0;
                if (!array_key_exists($group, $data)) {
                    $data[$group] = ['text' => $propertyAccessor->getValue($entity, $groupProperty), 'children' => []];
                }
                $data[$group]['children'][] = $d;
            } else {
                $data[] = $d;
            }
        }
        ksort($data);

        return $this->json(array_values($data));
    }

    /**
     * @Route("/s2-courseinfo-with-write-permission", name="s2_courseinfo_with_write_permission")
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function autoCompleteS2CourseInfoWithWritePermission(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $parameters = $request->query->all();
        $search = $parameters['q'] ?? null;
        $currentCourseInfo = $parameters['currentCourseInfo'] ?? null;

        $qb = $em->getRepository(CourseInfo::class)->createQueryBuilder('ci')
            ->innerJoin('ci.course', 'c')
            ->addSelect('c')
            ->where('ci.title LIKE :search OR c.code LIKE :search')
            ->setParameter('search', "%{$search}%");

        if (!$this->isGranted(UserRole::ROLE_ADMIN_COURSE_INFO_UPDATE)) {
            $qb
                ->innerJoin('ci.coursePermissions', 'cp')
                ->addSelect('cp')
                ->andWhere($qb->expr()->eq('cp.user', ':user'))
                ->andWhere($qb->expr()->eq('cp.permission', ':permission'))
                ->setParameter('user', $this->getUser())
                ->setParameter('permission', Permission::WRITE);
        }

        if (!empty($currentCourseInfo)) {
            $qb->andWhere($qb->expr()->neq('ci.id', ':currentCourseInfo'))
                ->setParameter('currentCourseInfo', $currentCourseInfo);
        }

        $coursesInfo = $qb->getQuery()->getResult();

        $data = array_map(function (CourseInfo $courseInfo) {
            return ['id' => $courseInfo->getId(), 'text' => "{$courseInfo->getCourse()->getCode()} - {$courseInfo->getYear()}"];
        }, $coursesInfo);


        return $this->json($data);
    }

    /**
     * @Route("/generic-s2-structure/{structure}/{entityName}", name="generic_s2_structure")
     *
     * @param Structure $structure
     * @param string $entityName
     * @param Request $request
     * @return JsonResponse
     */
    /*
     * TO REMOVE
     *
    public function autocompleteS2Structure(Structure $structure, string $entityName, Request $request)
    {
        $namespace = 'App\Syllabus\\Entity\\';
        $entityName = "{$namespace}{$entityName}";
        $query = $request->query->all('q', '');
        $findBy = $request->query->all('findBy', 'label');
        $property = $request->query->all('property', 'label');
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $repository = $this->getDoctrine()->getRepository($entityName);

        $entities = $repository->findLikeWithStructureQuery($query, $structure, $findBy);

        $data = array_map(function ($e) use ($propertyAccessor, $property) {
            return ['id' => $e->getId(), 'text' => $propertyAccessor->getValue($e, $property)];
        }, $entities);

        return $this->json($data);
    }
    */


    /**
     * @Route("/generic-s2-user", name="generic_s2_user")
     *
     * @param UserDoctrineRepository $userDoctrineRepository
     * @param Request $request
     * @return JsonResponse
     */
    public function autocompleteS2User(UserDoctrineRepository $userDoctrineRepository, Request $request): JsonResponse
    {

        $allParameters = $request->query->all();
        $query = $allParameters['q'] ?? '';
        $field = $allParameters['field_name'];

        switch ($field) {
            default:
                $searchFields = ['u.firstname', 'u.lastname'];
                break;
        }

        $users = $userDoctrineRepository->findLikeQuery($query, $searchFields);

        $data = array_map(function ($u) use ($request) {
            return ['id' => $u->getId(), 'text' => $u->getSelect2Name()];
        }, $users);

        return $this->json($data);
    }
}