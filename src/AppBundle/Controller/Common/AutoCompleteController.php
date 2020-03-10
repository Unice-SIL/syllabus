<?php


namespace AppBundle\Controller\Common;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AutoCompleteController
 * @package AppBundle\Controller\Common
 *
 * @Route("common/autocomplete", name="app.common.")
 */
class AutoCompleteController extends AbstractController
{
    /**
     * @Route("/autocomplete", name="autocomplete")
     *
     * @param $object
     * @param Request $request
     * @return JsonResponse
     */
    public function autoComplete(Request $request)
    {
        $query = $request->query->get('query', '');
        $object = $request->query->get('object', '');
        $repository = $this->getDoctrine()->getRepository("AppBundle\Entity\\".$object);

        if(!is_null($request->query->get('field')))
        {
            $objects = $repository->findLikeQuery($query, $request->query->get('field', ''));
        }else{
            $objects = $repository->findLikeQuery($query);
        }

        $objects = array_map(function($object){
            return $object->getLabel();
        }, $objects);

        $objects = array_unique($objects);
        $objects = array_values($objects);

        return $this->json(['query' =>  $query, 'suggestions' => $objects, 'data' => $objects]);
    }
}