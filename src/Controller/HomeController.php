<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ArticlesRepository $repo): Response
    {
        $articles = $repo->findAll();

        $lastArticle = $repo->findOneBy(array(), array('id' => 'desc'),1,0);

        return $this->render('home/index.html.twig', ['articles' => $articles, 'lastArticle' => $lastArticle]);
    }
}
