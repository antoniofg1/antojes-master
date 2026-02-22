<?php

namespace App\Controller;

use App\Service\JwtService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UpdateController extends AbstractController
{
    #[Route('/api/actualizar', name: 'api_actualizar', methods: ['POST'])]
    public function actualizar(
        Request $request,
        EntityManagerInterface $em,
        JwtService $jwtService
    ): JsonResponse {
        // Check API Key
        $apiKey = $request->headers->get('X-API-KEY');
        $expected = $this->getParameter('app_api_key');
        if ($apiKey !== $expected) {
            return new JsonResponse(['data' => null, 'error' => 'Invalid API Key'], 401);
        }

        $authHeader = $request->headers->get('Authorization');
        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return new JsonResponse(['data' => null, 'error' => 'Token required'], 401);
        }

        $token = substr($authHeader, 7);
        $payload = $jwtService->validateToken($token);
        if (!$payload) {
            return new JsonResponse(['data' => null, 'error' => 'Invalid token'], 401);
        }

        $data = json_decode($request->getContent(), true);
        if (!$data) {
            return new JsonResponse(['data' => null, 'error' => 'Invalid JSON'], 400);
        }

        $user = $em->getRepository(\App\Entity\User::class)->find($payload['user_id']);
        if (!$user) {
            return new JsonResponse(['data' => null, 'error' => 'User not found'], 404);
        }

        // Actualizar ubicación GPS (lat, lng)
        if (isset($data['lat']) && isset($data['lng'])) {
            $user->setLat($data['lat']);
            $user->setLng($data['lng']);
        }

        // Actualizar estado online/offline
        if (isset($data['online'])) {
            $user->setOnline((bool)$data['online']);
        }

        // Actualizar nombre si se proporciona
        if (isset($data['name']) && !empty(trim($data['name']))) {
            $user->setName(trim($data['name']));
        }

        // Actualizar email si se proporciona
        if (isset($data['email']) && !empty(trim($data['email']))) {
            // Verificar que el email no exista
            $existingUser = $em->getRepository(\App\Entity\User::class)->findOneBy(['email' => $data['email']]);
            if ($existingUser && $existingUser->getId() !== $user->getId()) {
                return new JsonResponse(['data' => null, 'error' => 'Email already exists'], 400);
            }
            $user->setEmail(trim($data['email']));
        }

        $em->flush();

        return new JsonResponse([
            'data' => [
                'message' => 'User data updated successfully',
                'user' => [
                    'id' => $user->getId(),
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'lat' => $user->getLat(),
                    'lng' => $user->getLng(),
                    'online' => $user->isOnline()
                ]
            ],
            'error' => null
        ]);
    }
}