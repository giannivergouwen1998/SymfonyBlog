<?php

namespace App\Message\UI\Controller;

use App\Message\Domain\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

#[Route(path: '/posts', name: 'posts_controller')]
final class Posts extends AbstractController
{
    public function __construct(
        private MessageRepository $messageRepository,

    )
    {
    }

    public function __invoke(Request $request): Response
    {
        $messages = $this->messageRepository->all();

        return $this->render(
          'posts.html.twig',
            [
                'messages' => [...$messages]
            ]
        );
    }
}