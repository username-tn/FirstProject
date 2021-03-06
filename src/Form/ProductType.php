<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Product;
use App\Entity\SubCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('prix', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('Description', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('quantity', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('image', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'choisir votre image'

            ])
            ->add(
                'SubCategory',
                EntityType::class,
                [
                    'class' => SubCategory::class,
                    'choice_label' => 'name',
                    'multiple' => false,
                    'expanded' => true,

                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
