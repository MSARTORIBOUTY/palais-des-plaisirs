<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MyArticlesController extends AbstractController
{
    #[Route('/mesarticles', name: 'mes articles', methods: ['GET', 'POST'])]
    public function index(Request $request, ArticlesRepository $articlesRepository): Response
    {
        
        $user = $this->getUser();

        $delete = $request->request->get('delete_article');

        if ($delete) {
            $articles = $articlesRepository->findOneBy(array('id' => $delete));
            $articlesRepository->remove($articles, true);

            return $this->redirect($request->getUri());
        }
        $articles = $articlesRepository->findBy(array('id_user' => $user), array('id_user' => 'asc'),null,0);
        
        return $this->render('MyArticles/index.html.twig', ['articles' => $articles]);
    }
}