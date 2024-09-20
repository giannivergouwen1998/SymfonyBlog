<?php

namespace App\Message\UI\Controller;

use App\Message\Application\DTO\Message;
use App\Message\Application\PostMessage;
use App\Message\UI\Form\IndexForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Throwable;

#[Route(path: '/', name: 'index')]
final class Index extends AbstractController
{
    public function __construct(
        public MessageBusInterface $messageBus,
        public UrlGeneratorInterface $generator,
    )
    {
    }

    public function __invoke(Request $request): Response
    {

        $form = $this->createForm(IndexForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            /** @var Message $dto */
            $dto = $form->getData();

            try {
                $this->messageBus->dispatch(
                    new PostMessage(
                        $dto->title,
                        $dto->text
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
            'index.html.twig', [
                'form' => $form->createView()
            ]
        );
    }

}