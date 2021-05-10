<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Figure;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FigureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',
                TextType::class,
                ['label' => 'nom de la figure'])
            ->add('content',
                TextareaType::class,
                ['label' => 'contenue'])
            ->add('category',
                EntityType::class,
                ['class' => Category::class,
                    'label' => 'catégorie'])
            ->add('files',
                FileType::class,
                ['multiple' => true,
                    'mapped' => false,
                    'required' => false,
                    'by_reference' => false,
                    'label' => 'ajouter une ou des images'
                ])
            ->add('videos', CollectionType::class,
                ['entry_type' => VideoType::class,
                    'by_reference' => false,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'label' => false,
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Figure::class,
        ]);
    }
}
