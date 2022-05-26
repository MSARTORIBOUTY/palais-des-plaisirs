<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\ArticlesRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    #[Route('/utilisateurs', name: 'utilisateurs', methods: ['GET', 'POST'])]
    public function index(Request $request, UsersRepository $usersRepository): Response
    {
        // $user = new Users();
        // $form = $this->createForm(usersAddType::class, $user);
        // $form->handleRequest($request);
        $delete = $request->request->get('delete_user');
        $update = $request->request->get('update_user');
        $newRole = $request->request->get('role');

        // $lastArticles = $repoArticle->findBy(array(), array('id' => 'desc'),3,0);

        
        if ($delete) {
            $user = $usersRepository->findOneBy(array('id' => $delete));
            $usersRepository->remove($user, true);
        } elseif ($update) {

            $user = $usersRepository->findOneBy(array('id' => $update));
            $user -> setRoles([$newRole]);
            $usersRepository->add($user, true);

        }
            


        return $this->render('users/index.html.twig', [
            'users' => $usersRepository->findAll(),
        ]);
    }
}