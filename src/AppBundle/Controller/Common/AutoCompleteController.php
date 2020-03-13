<?php


namespace AppBundle\Controller\Common;


use AppBundle\Entity\Structure;
use AppBundle\Repository\Doctrine\UserDoctrineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AutoCompleteController
 * @package AppBundle\Controller\Common
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
     * @return JsonResponse
     */
    public function autoComplete(string $entityName, Request $request)
    {
        $namespace = 'AppBundle\\Entity\\';
        $entityName = "{$namespace}{$entityName}";
        $query = $request->query->get('query', '');
        $findBy = $request->query->get('findBy', 'label');
        $property = $request->query->get('property', 'label');

        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $repository = $this->getDoctrine()->getRepository($entityName);
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
     * @return JsonResponse
     */
    public function autoCompleteS2(string $entityName, Request $request)
    {
        $namespace = 'AppBundle\\Entity\\';
        $entityName = "{$namespace}{$entityName}";
        $query = $request->query->get('q', '');
        $findBy = $request->query->get('findBy', 'label');
        $property = $request->query->get('property', 'label');
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $repository = $this->getDoctrine()->getRepository($entityName);

        $entities = $repository->findLikeQuery($query, $findBy);

        $data = array_map(function ($e) use ($propertyAccessor, $property) {
            return ['id' => $e->getId(), 'text' => $propertyAccessor->getValue($e, $property)];
        }, $entities);

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
    public function autocompleteS2Structure(Structure $structure, string $entityName, Request $request)
    {
        $data = [];
        $query = $request->query->get('q');
        $entities = [];
        if ($entityName == "Domain") {
            $entities = $structure->getDomains();
        } elseif ($entityName == "Period") {
            $entities = $structure->getPeriods();
        }
        $input = preg_quote($query, '~');
        $result = preg_grep('~^' . $input . '~', $entities->toArray());
        if (!empty($result)) {
            foreach ($result as $e) {
                $data[] = ['id' => $e->getId(), 'text' => $e->getLabel()];
            }
        }
        return $this->json($data);
    }

    /**
     * @Route("/generic-s2-user/{entityName}", name="generic_s2_user")
     *
     * @param UserDoctrineRepository $userDoctrineRepository
     * @param Request $request
     * @return JsonResponse
     */
    public function autocompleteS2User(UserDoctrineRepository $userDoctrineRepository, Request $request)
    {
        $query = $request->query->get('q');

        $field = $request->query->get('field_name');
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