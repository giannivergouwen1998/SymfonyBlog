<?php

namespace App\Message\UI\Controller;

use App\Message\Application\DTO\Message as MessageDto;
use App\Message\Application\UpdateMessage;
use App\Message\Domain\MessageId;
use App\Message\Domain\MessageRepository;
use App\Message\UI\Form\IndexForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Throwable;

#[Route(path: '/message/{messageId}/update', name: 'update_controller')]
final class UpdatePost extends AbstractController
{
    public function __construct(
        private readonly MessageRepository $repository,
        private readonly MessageBusInterface $messageBus,
        private readonly UrlGeneratorInterface $generator,
    )
    {
    }

    public function __invoke(string $messageId, Request $request): Response
    {
        $message = $this->repository->find(MessageId::fromString($messageId));

        $dto = MessageDto::fromDomain($message);

        $form = $this->createForm(IndexForm::class, data: $dto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            try {
                $this->messageBus->dispatch(
                    new UpdateMessage(
                        $dto->messageId,
                        $dto->title,
                        $dto->text,
                    )
                );

                return $this->redirect(
                    $this->generator->generate('posts_controller')
                );

            }catch(Throwable $exception)
            {
                return new Response($exception->getMessage());
            }
        }

        return $this->render(
            'index.html.twig',
            [
                'form' => $form->createView(),
                'messageId' => $messageId
            ]
        );
    }
}