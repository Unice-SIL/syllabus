<?php

namespace App\Syllabus\Factory;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\OpenApi;
use ApiPlatform\Core\OpenApi\Model;

/**
 *
 */
class OpenApiFactory implements OpenApiFactoryInterface
{
    private $decorated;

    public function __construct(OpenApiFactoryInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = $this->decorated->__invoke($context);
        $pathItem = $openApi->getPaths()->getPath('/api/course_infos/duplicate/{code1}/{year1}/{code2}/{year2}');
        $operation = $pathItem->getGet();
        dump($operation);
        $openApi->getPaths()->addPath('/api/course_infos/duplicate/{code1}/{year1}/{code2}/{year2}', $pathItem->withGet(
            $operation->withParameters(
                [
                    new Model\Parameter('code1', 'query', 'Code of the syllabus to duplicate'),
                    new Model\Parameter('year1', 'query', 'Year of the syllabus to duplicate'),
                    new Model\Parameter('code2', 'query', 'Code of the new syllabus'),
                    new Model\Parameter('year2', 'query', 'Year of the new syllabus')
                ]
            )
        ));

        return $openApi;
    }
}