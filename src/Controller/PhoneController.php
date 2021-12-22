<?php

namespace App\Controller;

use App\Repository\PhoneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class PhoneController extends AbstractController
{
    private PhoneRepository $phoneRepository;

    public function __construct(PhoneRepository $phoneRepository)
    {
        $this->phoneRepository = $phoneRepository;
    }

    #[Route('/phones', name: 'index_phone', methods: ['GET'])]
    public function index(): JsonResponse
    {
        try {
            return $this->json($this->phoneRepository->findAll(), 200, ['groups' => 'phone:read']);
        } catch (NotFoundHttpException $exception) {
            return $this->json([
                'status' => 400,
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    #[Route('/phones/{id<\d+>}', name: 'get_one_phone')]
    public function getOne(int $id): JsonResponse
    {
        $phone = $this->phoneRepository->find($id);

        if($phone)
        {
            return $this->json($this->phoneRepository->find($id), 200);
        }

        return $this->json([
            'status' => 400,
            'message' => "Ce produit n'existe pas"
        ], 400);
    }
}
