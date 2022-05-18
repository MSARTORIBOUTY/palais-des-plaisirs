<?php

namespace App\DataFixtures;

use App\Entity\Articles;
use App\Entity\Categories;
use App\Entity\Users;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $hasher)
    {
        // $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {

        $marie = new Users();
        $marie
            ->setUsername('Marie')
            ->setEmail('marie_laure.b13@hotmail.com')
            ->setPassword($this->hasher->hashPassword($marie, 'azerty789*'))
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($marie);

        $valou = new Users();
        $valou
            ->setUsername('Valou')
            ->setEmail('chico030372@gmail.com')
            ->setPassword($this->hasher->hashPassword($valou, 'azerty789*'))
            ->setRoles(['ROLE_USER']);
        $manager->persist($valou);

        $author = new Users();
        $author
            ->setUsername('Zola')
            ->setEmail('emile.zola@gmail.com')
            ->setPassword($this->hasher->hashPassword($author, 'azerty789*'))
            ->setRoles(['ROLE_AUTHOR']);
        $manager->persist($author);

        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $user = new Users();
            $user
                ->setUsername('username' . $i)
                ->setEmail('email' . $i . '@gmail.com')
                ->setPassword($this->hasher->hashPassword($user, 'azerty789*'));

            $manager->persist($user);
            $manager->flush();
            array_push($users, $user);
        }

        $categoriesString = ['Entrée', 'Plat', 'Dessert', 'Apéritif', 'Gourmandise'];
        $categories = [];

        for ($i = 0; $i < count($categoriesString)-1; $i++) {
            $category = new Categories();
            $category
                ->setName($categoriesString[$i]);

            $manager->persist($category);
            $manager->flush();
            array_push($categories, $category);
        }

        $img = ['img/aperitif-1.jpg', 'img/aperitif-2.jpg', 'img/bruschetta-b.jpg', 'img/bruschetta.jpg', 'img/burger.jpg', 'img/cake.jpg', 'img/cookies.jpg', 'img/cupcakes.jpg', 'img/gnocchis.jpg', 'img/pasta.jpg', 'img/pizza.jpg', 'img/rice.jpg', 'img/salad.jpg', 'img/sushis.jpg'];
        $title = "Abusus enim multitudine hominum";
        $ingredients = "Inconnus";
        $content = "Abusus enim multitudine hominum, quam tranquillis in rebus diutius rexit, ex agrestibus habitaculis urbes construxit multis opibus firmas et viribus, quarum ad praesens pleraeque licet Graecis nominibus appellentur, quae isdem ad arbitrium inposita sunt conditoris, primigenia tamen nomina non amittunt, quae eis Assyria lingua institutores veteres indiderunt.";
        $time = strtotime('10/01/2022');
        $literalTime = new DateTime();
        // $literalTime = \DateTime::createFromFormat("d/m/Y",$time);

        for ($j = 0; $j < count($img); $j++) {
            $article = new Articles();
            $article
                ->setTitle($title)
                ->setPicture($img[$j])
                ->setContent($content)
                ->setDateCreate($literalTime)
                ->setIngredients($ingredients)
                ->setIdCategorie($categories[rand(0,count($categories)-1)])
                ->setIdUser($users[rand(0,count($users)-1)]);
            $manager->persist($article);
            $manager->flush();
        }
    }
}
