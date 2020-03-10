<?php


namespace AppBundle\Controller\Common;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

        $entities = array_map(function($entity) use($propertyAccessor, $property){
            return $propertyAccessor->getValue($entity, $property);
        }, $entities);

        $entities = array_unique($entities);
        $entities = array_values($entities);

        return $this->json(['query' =>  $query, 'suggestions' => $entities, 'data' => $entities]);
    }
}