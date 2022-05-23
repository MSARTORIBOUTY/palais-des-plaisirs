<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MyArticlesController extends AbstractController
{
    #[Route('/mesarticles', name: 'mes articles')]
    public function index(): Response
    {
        

        return $this->render('MyArticles/index.html.twig');
    }
}