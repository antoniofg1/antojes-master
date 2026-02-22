<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\JwtService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/api/usuarios', name: 'api_usuarios_list', methods: ['GET'])]
    public function list(
        Request $request,
        EntityManagerInterface $em,
        JwtService $jwtService
    ): JsonResponse {
        // Validate token
        $token = $this->getTokenFromRequest($request, $jwtService);
        if (!$token) {
            return new JsonResponse(['data' => null, 'error' => 'Unauthorized'], 401);
        }

        $users = $em->getRepository(User::class)->findAll();
        $userData = [];
        foreach ($users as $user) {
            $userData[] = [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
            ];
        }

        return new JsonResponse(['data' => ['users' => $userData], 'error' => null]);
    }

    #[Route('/api/usuarios', name: 'api_usuarios_create', methods: ['POST'])]
    public function create(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher
    ): JsonResponse {
        // Create user - public endpoint, only requires API Key
        $data = json_decode($request->getContent(), true);
        
        if (!$data || !isset($data['name']) || !isset($data['email']) || !isset($data['password'])) {
            return new JsonResponse(['data' => null, 'error' => 'Name, email and password required'], 400);
        }

        // Check if email exists
        $existing = $em->getRepository(User::class)->findOneBy(['email' => $data['email']]);
        if ($existing) {
            return new JsonResponse(['data' => null, 'error' => 'Email already exists'], 400);
        }

        $user = new User();
        $user->setName($data['name']);
        $user->setEmail($data['email']);
        $user->setPassword($passwordHasher->hashPassword($user, $data['password']));
        $em->persist($user);
        $em->flush();

        return new JsonResponse([
            'data' => [
                'message' => 'User created',
                'user' => [
                    'id' => $user->getId(),
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                ],
            ],
            'error' => null
        ], 201);
    }

    #[Route('/api/usuarios/{id}', name: 'api_usuarios_show', methods: ['GET'], requirements: ['id' => '\\d+'])]
    public function show(
        int $id,
        Request $request,
        EntityManagerInterface $em,
        JwtService $jwtService
    ): JsonResponse {
        $token = $this->getTokenFromRequest($request, $jwtService);
        if (!$token) {
            return new JsonResponse(['data' => null, 'error' => 'Unauthorized'], 401);
        }

        $user = $em->getRepository(User::class)->find($id);
        if (!$user) {
            return new JsonResponse(['data' => null, 'error' => 'User not found'], 404);
        }

        return new JsonResponse([
            'data' => [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'lat' => $user->getLat(),
                'lng' => $user->getLng(),
                'online' => $user->isOnline(),
            ],
            'error' => null
        ]);
    }

    #[Route('/api/usuarios/me', name: 'api_usuarios_me', methods: ['GET'])]
    public function me(
        Request $request,
        EntityManagerInterface $em,
        JwtService $jwtService
    ): JsonResponse {
        $token = $this->getTokenFromRequest($request, $jwtService);
        if (!$token) {
            return new JsonResponse(['data' => null, 'error' => 'Unauthorized'], 401);
        }

        $user = $em->getRepository(User::class)->find($token['user_id']);
        if (!$user) {
            return new JsonResponse(['data' => null, 'error' => 'User not found'], 404);
        }

        return new JsonResponse([
            'data' => [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'lat' => $user->getLat(),
                'lng' => $user->getLng(),
                'online' => $user->isOnline(),
            ],
            'error' => null
        ]);
    }

    #[Route('/api/usuarios/{id}', name: 'api_usuarios_update', methods: ['PUT'], requirements: ['id' => '\\d+'])]
    public function update(
        int $id,
        Request $request,
        EntityManagerInterface $em,
        JwtService $jwtService
    ): JsonResponse {
        $token = $this->getTokenFromRequest($request, $jwtService);
        if (!$token || $token['user_id'] !== $id) {
            return new JsonResponse(['data' => null, 'error' => 'Unauthorized'], 403);
        }

        $user = $em->getRepository(User::class)->find($id);
        if (!$user) {
            return new JsonResponse(['data' => null, 'error' => 'User not found'], 404);
        }

        $data = json_decode($request->getContent(), true);
        if ($data && isset($data['name'])) {
            $user->setName($data['name']);
        }
        if ($data && isset($data['email'])) {
            $user->setEmail($data['email']);
        }

        $em->flush();

        return new JsonResponse(['data' => ['message' => 'User updated'], 'error' => null]);
    }

    #[Route('/api/usuarios/me', name: 'api_usuarios_update_me', methods: ['PUT'])]
    public function updateMe(
        Request $request,
        EntityManagerInterface $em,
        JwtService $jwtService
    ): JsonResponse {
        $token = $this->getTokenFromRequest($request, $jwtService);
        if (!$token) {
            return new JsonResponse(['data' => null, 'error' => 'Unauthorized'], 401);
        }

        $user = $em->getRepository(User::class)->find($token['user_id']);
        if (!$user) {
            return new JsonResponse(['data' => null, 'error' => 'User not found'], 404);
        }

        $data = json_decode($request->getContent(), true);
        if ($data && isset($data['name'])) {
            $user->setName($data['name']);
        }
        if ($data && isset($data['email'])) {
            $user->setEmail($data['email']);
        }

        $em->flush();

        return new JsonResponse(['data' => ['message' => 'User updated'], 'error' => null]);
    }

    #[Route('/api/usuarios/{id}', name: 'api_usuarios_delete', methods: ['DELETE'])]
    public function delete(
        int $id,
        Request $request,
        EntityManagerInterface $em,
        JwtService $jwtService
    ): JsonResponse {
        $token = $this->getTokenFromRequest($request, $jwtService);
        if (!$token || $token['user_id'] !== $id) {
            return new JsonResponse(['data' => null, 'error' => 'Unauthorized'], 403);
        }

        $user = $em->getRepository(User::class)->find($id);
        if (!$user) {
            return new JsonResponse(['data' => null, 'error' => 'User not found'], 404);
        }

        $em->remove($user);
        $em->flush();

        return new JsonResponse(['data' => ['message' => 'User deleted'], 'error' => null]);
    }

    #[Route('/api/usuarios/locations', name: 'api_usuarios_locations', methods: ['GET'])]
    public function locations(
        Request $request,
        EntityManagerInterface $em,
        JwtService $jwtService
    ): JsonResponse {
        $token = $this->getTokenFromRequest($request, $jwtService);
        if (!$token) {
            return new JsonResponse(['data' => null, 'error' => 'Unauthorized'], 401);
        }

        $users = $em->getRepository(User::class)->findAll();
        $data = [];
        foreach ($users as $user) {
            if ($user->getLat() && $user->getLng()) {
                $data[] = [
                    'id' => $user->getId(),
                    'name' => $user->getName(),
                    'lat' => $user->getLat(),
                    'lng' => $user->getLng(),
                    'online' => $user->isOnline(),
                ];
            }
        }

        return new JsonResponse(['data' => ['users' => $data], 'error' => null]);
    }

    private function getTokenFromRequest(Request $request, JwtService $jwtService): ?array
    {
        $authHeader = $request->headers->get('Authorization');
        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return null;
        }

        $token = substr($authHeader, 7);
        return $jwtService->validateToken($token);
    }
}
