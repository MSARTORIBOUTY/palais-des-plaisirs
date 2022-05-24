<?php

namespace App\Form;


use App\Entity\Categories;
use Laminas\Code\Generator\EnumGenerator\Name;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       

        $builder
            ->add('name', EntityType::class, [
                'label' => false,
                'class' => Categories::class,
                'attr' => ['class' => 'input-article' ],
                'choice_label' => 'name'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categories::class,
        ]);
    }
}
