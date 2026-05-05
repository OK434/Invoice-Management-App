<?php

namespace App\Controller;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/api/client")]
class ClientController
{
    public function __construct()
    {

    }

    #[Route("/register", name: "register_Client", methods: ["POST"])]
    public function registerClient(Request $request, EntityManagerInterface $em, ClientRepository $clientRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!$data || !isset(
                $data['clientName'],
                $data['email'],
                $data['password'],
                $data['companyName'],
                $data['addressName']
            )) {
            return new JsonResponse(['message' => 'Invalid data'], 400);
        }

        $existingEmail = $clientRepository->findByEmail($data['email']);
        if ($existingEmail) {
            return new JsonResponse([
                'message' => 'Email already exists'
            ], 409);
        }
        $existingName = $clientRepository->findByClientName($data['clientName']);
        if ($existingName) {
            return new JsonResponse([
                'message' => 'Client name already exists'
            ], 409);
        }
        $client = new Client();
        $client->setClientName($data['clientName']);
        $client->setEmail($data['email']);
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
        $client->setCompanyName($data['companyName']);
        $client->setAddressName($data['addressName']);
        $client->setPassword($hashedPassword);
        $em->persist($client);
        $em->flush();
        return new JsonResponse([
            'message' => 'Client created successfully'
        ], 201);
    }

    #[Route("/login", name: "Login_Client", methods: ["POST"])]
    public function loginClient(Request $request, EntityManagerInterface $em, ClientRepository $clientRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!$data || !isset($data['email'], $data['password'])) {
            return new JsonResponse([
                'message' => 'Invalid data'
            ], 400);
        }
        $client = $clientRepository->findByEmail($data['email']);
        if (!$client) {
            return new JsonResponse([
                'message' => 'Invalid email'
            ], 401);
        }
        if (!password_verify($data['password'], $client->getPassword())) {
            return new JsonResponse([
                'message' => 'Invalid password'
            ], 401);
        }
        return new JsonResponse([
            'message' => 'Login successful',
            'client' => [
                'email' => $client->getEmail(),
                'clientName' => $client->getClientName(),
                'addressName' => $client->getAddressName(),
                'companyName' => $client->getCompanyName()
            ]
        ], 200);
    }

    #[Route('/client', name: "Client", methods: ["GET"])]
    public function getClients(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $clients = $em->getRepository(Client::class)->findAll();
        $data = [];
        foreach ($clients as $client) {
            $data[] = [
                'id' => $client->getId(),
                'clientName' => $client->getClientName(),
                'email' => $client->getEmail(),
                'companyName' => $client->getCompanyName(),
                'addressName' => $client->getAddressName()
            ];
        }
        return new JsonResponse([$data], 200);
    }
}

