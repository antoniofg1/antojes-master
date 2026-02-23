<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HealthController extends AbstractController
{
    #[Route('/health', name: 'health', methods: ['GET'])]
    public function health(EntityManagerInterface $em): JsonResponse
    {
        // Verificar base de datos
        $userCount = 0;
        $dbError = null;
        $dbConnected = false;
        
        try {
            // Intentar hacer una consulta simple
            $connection = $em->getConnection();
            $connection->executeQuery('SELECT 1');
            $dbConnected = true;
            
            // Si la conexión funciona, contar usuarios
            try {
                $userCount = $em->getRepository(User::class)->count([]);
            } catch (\Exception $e) {
                // La tabla puede no existir aún
                $dbError = 'Database connected but tables may not exist: ' . $e->getMessage();
            }
        } catch (\Exception $e) {
            $dbError = 'Database connection failed: ' . $e->getMessage();
        }
        
        return new JsonResponse([
            'status' => $dbConnected ? 'ok' : 'error',
            'timestamp' => time(),
            'server' => 'running',
            'php_version' => phpversion(),
            'env' => [
                'APP_ENV' => $_ENV['APP_ENV'] ?? 'not set',
                'APP_API_KEY_SET' => isset($_ENV['APP_API_KEY']) ? 'yes' : 'no',
                'APP_SECRET_SET' => isset($_ENV['APP_SECRET']) ? 'yes' : 'no',
                'DATABASE_URL_SET' => isset($_ENV['DATABASE_URL']) ? 'yes' : 'no',
            ],
            'database' => [
                'connected' => $dbConnected,
                'users_count' => $userCount,
                'error' => $dbError
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
