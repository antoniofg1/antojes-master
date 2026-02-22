<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserFollow;
use App\Service\JwtService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FollowController extends AbstractController
{
    #[Route('/api/seguir', name: 'api_follow_create', methods: ['POST'])]
    public function follow(
        Request $request,
        EntityManagerInterface $em,
        JwtService $jwtService
    ): JsonResponse {
        $expected = $this->getParameter('app_api_key');
        if ($request->headers->get('X-API-KEY') !== $expected) {
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
        if (!$data || !isset($data['user_id'])) {
            return new JsonResponse(['data' => null, 'error' => 'user_id required'], 400);
        }

        $follower = $em->getRepository(User::class)->find($payload['user_id']);
        $followed = $em->getRepository(User::class)->find($data['user_id']);

        if (!$follower || !$followed) {
            return new JsonResponse(['data' => null, 'error' => 'User not found'], 404);
        }

        if ($follower->getId() === $followed->getId()) {
            return new JsonResponse(['data' => null, 'error' => 'Cannot follow yourself'], 400);
        }

        // Check if already following
        $existing = $em->getRepository(UserFollow::class)->findOneBy([
            'followerUser' => $follower,
            'followedUser' => $followed
        ]);

        if ($existing) {
            return new JsonResponse(['data' => ['message' => 'Already following'], 'error' => null]);
        }

        $follow = new UserFollow();
        $follow->setFollowerUser($follower);
        $follow->setFollowedUser($followed);
        $em->persist($follow);
        $em->flush();

        return new JsonResponse(['data' => ['message' => 'User followed'], 'error' => null], 201);
    }

    #[Route('/api/seguir/{id}', name: 'api_follow_delete', methods: ['DELETE'])]
    public function unfollow(
        int $id,
        Request $request,
        EntityManagerInterface $em,
        JwtService $jwtService
    ): JsonResponse {
        $expected = $this->getParameter('app_api_key');
        if ($request->headers->get('X-API-KEY') !== $expected) {
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

        $follower = $em->getRepository(User::class)->find($payload['user_id']);
        $followed = $em->getRepository(User::class)->find($id);

        if (!$follower || !$followed) {
            return new JsonResponse(['data' => null, 'error' => 'User not found'], 404);
        }

        $follow = $em->getRepository(UserFollow::class)->findOneBy([
            'followerUser' => $follower,
            'followedUser' => $followed
        ]);

        if (!$follow) {
            return new JsonResponse(['data' => null, 'error' => 'Follow not found'], 404);
        }

        $em->remove($follow);
        $em->flush();

        return new JsonResponse(['data' => ['message' => 'User unfollowed'], 'error' => null]);
    }

    #[Route('/api/seguidos', name: 'api_followed_list', methods: ['GET'])]
    public function getFollowed(
        Request $request,
        EntityManagerInterface $em,
        JwtService $jwtService
    ): JsonResponse {
        $expected = $this->getParameter('app_api_key');
        if ($request->headers->get('X-API-KEY') !== $expected) {
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

        $user = $em->getRepository(User::class)->find($payload['user_id']);
        if (!$user) {
            return new JsonResponse(['data' => null, 'error' => 'User not found'], 404);
        }

        $followedUsers = $em->getRepository(UserFollow::class)->findBy([
            'followerUser' => $user
        ]);

        $followed = [];
        foreach ($followedUsers as $follow) {
            $followedUser = $follow->getFollowedUser();
            $followed[] = [
                'id' => $followedUser->getId(),
                'name' => $followedUser->getName(),
                'email' => $followedUser->getEmail(),
            ];
        }

        return new JsonResponse(['data' => ['followed_users' => $followed], 'error' => null]);
    }
}
