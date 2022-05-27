<?php

namespace App\Controller;

use App\DataFixtures\SearchData;
use App\Entity\Articles;
use App\Entity\Categories;
use App\Entity\Comments;
use App\Form\ArticlesType;
use App\Form\CategoriesType;
use App\Form\CommentsType;
use App\Form\SearchType;
use App\Repository\ArticlesRepository;
use App\Repository\CategoriesRepository;
use App\Repository\CommentsRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/recipes')]
class ArticlesController extends AbstractController
{
    #[Route('/', name: 'recipes', methods: ['GET'])]
    public function index(Request $request, ArticlesRepository $articlesRepository, CategoriesRepository $categoriesRepository): Response
    {
        $data = new SearchData();
        $form = $this->createForm(SearchType::class, $data);
        $form->handleRequest($request);

        $article = $articlesRepository->findSearch($data);

        return $this->render('recipes/index.html.twig', [
            'articles' => $article,
            'form' => $form->createView()
        ]);
    }

    #[Route('/new', name: 'recipes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ArticlesRepository $articlesRepository, SluggerInterface $slugger): Response
    {
        $article = new Articles();
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            
            $pictureFile = $form->get('picture')->getData();

            if ($pictureFile) {
                $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$pictureFile->guessExtension();
                
                // Move the file to the directory where brochures are stored
                try {
                    $pictureFile->move(
                        $this->getParameter('pictures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'pictureFilename' property to store the PDF file name
                // instead of its contents
                $article->setPicture($newFilename);
            }

            $articlesRepository->add($article, true);


            return $this->redirectToRoute('recipes', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('articles/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'recipe_show', methods: ['GET', 'POST'])]
    public function show(Request $request, Articles $article, CommentsRepository $commentsRepository, ArticlesRepository $repoArticle, CommentsRepository $repoComment): Response
    {
        $comment = new Comments();
        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);
        $delete = $request->request->get('delete_comment');

        $lastArticles = $repoArticle->findBy(array(), array('id' => 'desc'),3,0);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->getUser();
            $date = new DateTime();

            $comment
                ->setIdUser($user)
                ->setIdArticle($article)
                ->setDateCreate($date);
            $commentsRepository->add($comment, true);

            return $this->redirect($request->getUri());
        } elseif ($delete) {
            $comment = $repoComment->findOneBy(array('id' => $delete));
            $commentsRepository->remove($comment, true);
        }



        return $this->render('recipe/index.html.twig', [
            'article' => $article,
            'commentForm' => $form->createView(),
            'lastArticles' => $lastArticles,
        ]);
    }

    #[Route('/{id}/edit', name: 'recipes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Articles $article, ArticlesRepository $articlesRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ArticlesType::class, $article);
        $articlePicture= $article->getPicture();
        $articlePicture= 'img/'.$articlePicture;
        
        
        $form->handleRequest($request);
        $form->get('picture')->setData(new File($articlePicture));
        

        if ($form->isSubmitted() && $form->isValid()) {

            $pictureFile = $form->get('picture')->getData();

            if ($pictureFile) {
                $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$pictureFile->guessExtension();
                
                // Move the file to the directory where brochures are stored
                try {
                    $pictureFile->move(
                        $this->getParameter('pictures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'pictureFilename' property to store the PDF file name
                // instead of its contents
                $article->setPicture($newFilename);
            }

            $articlesRepository->add($article, true);

            return $this->redirectToRoute('recipes', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('MyArticles/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'recipes_delete', methods: ['POST'])]
    public function delete(Request $request, Articles $article, ArticlesRepository $articlesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $articlesRepository->remove($article, true);
        }

        return $this->redirectToRoute('recipes', [], Response::HTTP_SEE_OTHER);
    }
}
