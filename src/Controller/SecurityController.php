<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class SecurityController extends AbstractController {
	#[Route('/login', name: 'app_login', methods: ['POST'])]
	public function Login(#[CurrentUser] User $user = null): Response {
		if (!$user) {
			return $this->json([
				'error' => 'Invalid login request: check that the Content-Type header is "application/json"'
			], 401);
		}

		return $this->json([
			'user' => '/api/users/' . $user->getId()
		]);
	}
}