<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdministrationController extends AbstractController
{
    #[Route('/administration', name: 'administration', methods: ['GET', 'POST'])]
    public function index(Request $request, ArticlesRepository $articlesRepository): Response
    {

        // $user = new articles();
        // $form = $this->createForm(articlesAddType::class, $user);
        // $form->handleRequest($request);
        $delete = $request->request->get('delete_article');

        // $lastArticles = $repoArticle->findBy(array(), array('id' => 'desc'),3,0);

        
        if ($delete) {
            $article = $articlesRepository->findOneBy(array('id' => $delete));
            $articlesRepository->remove($article, true);
        } 
            


        return $this->render('administration/index.html.twig', [
            'articles' => $articlesRepository->findAll(),
        ]);        

        
    }
}