<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Figure;
use App\Entity\Video;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FigureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('content')
            ->add('category',EntityType::class,
                ['class'=>Category::class])
            ->add('files',FileType::class,['label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false])
            ->add('videos',CollectionType::class,
                ['entry_type'=>VideoType::class,

        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Figure::class,
        ]);
    }
}
