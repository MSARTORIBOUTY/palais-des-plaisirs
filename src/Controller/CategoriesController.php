<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CategoriesController extends AbstractController
{
   
    #[Route('/categories', name: 'categories')]
    public function index(): Response
    {
        

        return $this->render('categories/index.html.twig');
    }
}