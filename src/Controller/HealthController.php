<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HealthController extends AbstractController
{
    #[Route('/health', name: 'health', methods: ['GET'])]
    public function health(): JsonResponse
    {
        return new JsonResponse([
            'status' => 'ok',
            'timestamp' => time(),
            'env' => [
                'APP_ENV' => $_ENV['APP_ENV'] ?? 'not set',
                'APP_API_KEY_SET' => isset($_ENV['APP_API_KEY']) ? 'yes' : 'no',
                'APP_SECRET_SET' => isset($_ENV['APP_SECRET']) ? 'yes' : 'no',
                'DATABASE_URL_SET' => isset($_ENV['DATABASE_URL']) ? 'yes' : 'no',
            ]
        ]);
    }
    
    #[Route('/', name: 'home_redirect', methods: ['GET'])]
    public function homeRedirect(): JsonResponse
    {
        return new JsonResponse([
            'message' => 'API Antojes - Chat Geolocalizado',
            'documentation' => '/docs.html',
            'health' => '/health',
            'version' => '1.0.0'
        ]);
    }
}
