<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/article')]
class ArticleController extends AbstractController
{
    // #[Route('/article', name: 'article')]
    // public function index(): Response
    // {
        

    //     return $this->render('article/index.html.twig');
    // }

    #[Route('/', name: 'article', methods: ['GET', 'POST'])]
    public function new(Request $request, ArticlesRepository $articleRepository): Response
    {
        $article = new Articles();
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articleRepository->add($article, true);

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/index.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }
}