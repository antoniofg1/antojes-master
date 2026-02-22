<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiDocController extends AbstractController
{
    #[Route('/api', name: 'api_documentation', methods: ['GET'])]
    public function documentation(): Response
    {
        $html = file_get_contents(__DIR__ . '/../../templates/api_doc.html.twig');
        return new Response($html);
    }
}
