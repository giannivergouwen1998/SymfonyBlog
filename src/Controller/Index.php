<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/', name: 'index')]
final class Index extends AbstractController
{
    public function __invoke(Request $request): Response
    {
        return new Response('<h1>it Works!</h1>');
    }

}