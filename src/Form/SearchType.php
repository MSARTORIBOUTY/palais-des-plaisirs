<?php

namespace App\Form;

use App\DataFixtures\SearchData;
use App\Entity\Categories;
use App\Entity\Message;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
            ->add('q', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'input-research',
                    'placeholder' => 'Rechercher'
             ],
             
            ])
            ->add('categories', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Categories::class,
                'expanded' => true,
                'multiple' => true,
                'attr' => [
                    'class' => 'input-checkbox'
             ],
             
            ]);
        ;
    }

    public function getBlockPrefix()
    {
        return ''; //retourner une simple chaîne de caractère pour l'url sinon il met tout dans un tableau de la class
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }
}
