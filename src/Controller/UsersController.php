<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    #[Route('/utilisateurs', name: 'utilisateurs')]
    public function index(): Response
    {
        

        return $this->render('users/index.html.twig');
    }
}