<?php

namespace AppBundle\Listener;

use AppBundle\Exception\ResourceValidationException;
use JMS\Serializer\Exception\ObjectConstructionException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        //test if the current uri belongs to api uri's
        if (strpos($event->getRequest()->server->get('REQUEST_URI'), '/api') === 0) {

            // You get the exception object from the received event
            $exception = $event->getException();

            $response = new Response();

            if ($exception instanceof ObjectConstructionException) {
                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
                $message = 'One of the relation id\'s doesn\'t exist';
            } elseif ($exception instanceof ResourceValidationException) {
                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
                $message = $exception->getMessage();
            }
            elseif ($exception instanceof NotFoundHttpException) {
                $response->setStatusCode($exception->getStatusCode());
                $message = 'Page not fount';
            }
            else {
                $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
                $message = "Internal Error Server";
            }

            $response->setContent($message);

            $event->setResponse($response);
        }
    }
}
