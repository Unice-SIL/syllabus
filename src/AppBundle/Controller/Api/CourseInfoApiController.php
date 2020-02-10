<?php

namespace AppBundle\Controller\Api;

use AppBundle\Decorator\Validator;
use AppBundle\Entity\CourseInfo;
use AppBundle\Exception\ResourceValidationException;
use AppBundle\Form\Api\CourseInfoType;
use AppBundle\Helper\ApiHelper;
use AppBundle\Repository\Doctrine\CourseInfoDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Ramsey\Uuid\Uuid;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CourseInfoApiController
 * @package AppBundle\Controller\Api
 * @Route("/api/course-info", name="app.course_info.")
 */
class CourseInfoApiController extends Controller
{
    /**
     * @param Request $request
     * @param ApiHelper $apiHelper
     * @param CourseInfoDoctrineRepository $courseInfoDoctrineRepository
     * @return JsonResponse
     *
     * @Route("", name="index", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of syllabus records"
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="query",
     *     type="string",
     *     description="A field used to filter syllabus"
     * )
     * @SWG\Parameter(
     *     name="etbId",
     *     in="query",
     *     type="string",
     *     description="A field used to filter syllabus"
     * )
     * @SWG\Parameter(
     *     name="yearId",
     *     in="query",
     *     type="string",
     *     description="A field used to filter syllabus"
     * )
     * @SWG\Parameter(
     *     name="structureId",
     *     in="query",
     *     type="string",
     *     description="A field used to filter syllabus"
     * )
     * @SWG\Parameter(
     *     name="title",
     *     in="query",
     *     type="string",
     *     description="A field used to filter syllabus"
     * )
     * @SWG\Parameter(
     *     name="published",
     *     in="query",
     *     type="boolean",
     *     description="A field used to filter syllabus"
     * )
     */
    public function indexAction(Request $request, ApiHelper $apiHelper, CourseInfoDoctrineRepository $courseInfoDoctrineRepository)
    {
        $config = $apiHelper->createConfigFromRequest($request, [
            'validFilterKeys' => ['id' => 'text', 'etbId' => 'text', 'yearId' => 'text', 'structureId' => 'text', 'title' => 'text', 'published' => 'boolean']
        ]);

        $qb = $courseInfoDoctrineRepository->findQueryBuilderForApi($config);

        $response = $apiHelper->setDataAndGetResponse($qb, $config);

        return $this->json($response);
    }

    /**
     * @Route("", name="post", methods={"POST"})
     */
    public function postAction(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator)
    {
        $courseInfo = $serializer->deserialize($request->getContent(), CourseInfo::class, 'json');

        if (count($violations = $validator->validate($courseInfo))) {
            $message = "Data sent are invalid: [";
            foreach ($violations as $violation){
                $message.= "{$violation->getPropertyPath()}: {$violation->getMessage()}, ";
            }
            $message = rtrim($message, ', ');
            $message.= "]";
            throw new ResourceValidationException($message);
        }

        $em->persist($courseInfo);
        $em->flush();

        $response = new Response($serializer->serialize($courseInfo, 'json', SerializationContext::create()->setGroups('api')), Response::HTTP_CREATED);
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    /**
     * @Route("/{id}", name="put", methods={"PUT"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Validator $validator
     * @param string $id
     * @return JsonResponse
     * @throws ResourceValidationException
     */
    public function putAction(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, Validator $validator, CourseInfo $ci)
    {
        $courseInfo = $serializer->deserialize($request->getContent(), CourseInfo::class, 'json');
        $courseInfo->setId($ci->getId());

        if (count($violations = $validator->validateOnPut($courseInfo))) {
            $message = "Data sent are invalid: [";
            foreach ($violations as $violation) {
                $message .= "{$violation->getPropertyPath()}: {$violation->getMessage()}, ";
            }
            $message = rtrim($message, ', ');
            $message .= "]";
            throw new ResourceValidationException($message);
        }

        $em->merge($courseInfo);
        $em->flush();

        $response = new Response($serializer->serialize($courseInfo, 'json', SerializationContext::create()->setGroups('api')), Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}