<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    #[Route('/recipe', name: 'recipe')]
    public function index(ArticlesRepository $repo): Response
    {
        $articles = $repo->findAll();

        return $this->render('recipe/index.html.twig', ['articles' => $articles]);
    }
}
