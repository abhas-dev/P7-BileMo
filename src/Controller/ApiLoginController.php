<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ApiLoginController extends AbstractController
{
    #[Route('/login', name: 'api_login')]
    public function index(#[CurrentUser] ?User $user): Response
    {
        if ($user === null) {
            return $this->json(
                ['message' => 'missing credentials'],
                Response::HTTP_UNAUTHORIZED
            );
        }

//        $token = ...; // somehow create an API token for $user

        return $this->json([
            'user'  => $user->getUserIdentifier(),
//            'token' => $token,
        ]);
    }
}
