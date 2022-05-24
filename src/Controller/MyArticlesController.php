<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MyArticlesController extends AbstractController
{
    #[Route('/mesarticles', name: 'mes articles')]
    public function index(Request $request, ArticlesRepository $articlesRepository): Response
    {
        
        $user = $this->getUser();

        $delete = $request->request->get('delete_article');

        if ($delete) {
            $articles = $articlesRepository->findOneBy(array('id' => $delete));
            $articlesRepository->remove($articles, true);

            return $this->redirect($request->getUri());
        }

        $articles = $articlesRepository->findOneBy(array('id_user' => $user), array('id_user' => 'desc'),1,0);

        return $this->render('MyArticles/index.html.twig', ['articles' => $articles]);
    }
}