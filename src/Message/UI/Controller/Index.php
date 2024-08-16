<?php

namespace App\Message\UI\Controller;

use App\Message\Application\DTO\Message;
use App\Message\Domain\Message as DomainMessage;
use App\Message\UI\Form\IndexForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/', name: 'index')]
final class Index extends AbstractController
{
    public function __invoke(Request $request): Response
    {
        $form = $this->createForm(IndexForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            /** @var Message $dto */
            $dto = $form->getData();

            return new Response("Title = {$dto->title} and Text = {$dto->text}");
        }

        return $this->render(
            'index.html.twig', [
                'form' => $form->createView()
            ]
        );
    }

}