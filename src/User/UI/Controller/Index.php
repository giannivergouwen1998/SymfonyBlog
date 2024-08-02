<?php

namespace App\User\UI\Controller;

use App\User\UI\Form\IndexForm;
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
            return new Response('Ok');
        }

        return $this->render(
            'index.html.twig', [
                'form' => $form->createView()
            ]
        );
    }

}