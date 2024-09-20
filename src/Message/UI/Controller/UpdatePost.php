<?php

namespace App\Message\UI\Controller;

use App\Message\Application\DTO\Message as MessageDto;
use App\Message\Domain\MessageId;
use App\Message\Domain\MessageRepository;
use App\Message\UI\Form\IndexForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/post/{messageId}/update', name: 'update_controller')]
final class UpdatePost extends AbstractController
{
    public function __construct(
        private readonly MessageRepository $repository,
    )
    {
    }

    public function __invoke(string $messageId, Request $request): Response
    {
        $message = $this->repository->find(MessageId::fromString($messageId));

        $dto = MessageDto::fromDomain($message);

        $form = $this->createForm(IndexForm::class, data: $dto);

        return $this->render(
            'index.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}