<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategoriesAddType;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CategoriesController extends AbstractController
{

    #[Route('/categories', name: 'categories', methods: ['GET', 'POST'])]
    public function index(Request $request, CategoriesRepository $categoriesRepository): Response

    {

        $category = new Categories();
        $form = $this->createForm(CategoriesAddType::class, $category);
        $form->handleRequest($request);
        $delete = $request->request->get('delete_category');
        $update = $request->request->get('update_category');
        $newName = $request->request->get('new_name');

        // $lastArticles = $repoArticle->findBy(array(), array('id' => 'desc'),3,0);

        if ($form->isSubmitted() && $form->isValid()) {

            $category
                ->setName($form->get('name')->getData());

            $categoriesRepository->add($category, true);

            return $this->redirect($request->getUri());
        } elseif ($delete) {
            $category = $categoriesRepository->findOneBy(array('id' => $delete));
            $categoriesRepository->remove($category, true);
        } elseif ($update) {

            $category = $categoriesRepository->findOneBy(array('id' => $update));
            $category -> setName($newName);
            $categoriesRepository->add($category, true);

        }
            


        return $this->render('categories/index.html.twig', [
            'categoryForm' => $form->createView(),
            'categories' => $categoriesRepository->findAll(),
        ]);

    }
}