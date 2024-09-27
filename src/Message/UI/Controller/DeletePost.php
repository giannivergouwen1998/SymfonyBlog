<?php

namespace App\Message\UI\Controller;

use App\Message\Application\DeleteMessage;
use App\Message\Application\DTO\Message as MessageDto;
use App\Message\Application\UpdateMessage;
use App\Message\Domain\MessageId;
use App\Message\Domain\MessageRepository;
use App\Message\UI\Form\IndexForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Throwable;

#[Route(path: '/message/{messageId}/delete', name: 'delete_controller')]
final class DeletePost extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
    )
    {
    }

    public function __invoke(string $messageId, Request $request): Response
    {
        if (!$request->isXmlHttpRequest())
        {
            throw BadRequestHttpException::fromStatusCode(400);
        }

       try {
           $this->messageBus->dispatch(
             new DeleteMessage(
                 MessageId::fromString($messageId)
             )
           );

           return new JsonResponse(
               [
                   "status" => 'ok',
                   "statusCode" => 200,
                   'message' => 'Post deleted'
               ]
           );

       }catch(Throwable $exception)
       {
           return new JsonResponse(
               [
                   "status" => 'error',
                   "statusCode" => 500,
                   'message' => $exception->getMessage()
               ]
           );
       }
   }
}