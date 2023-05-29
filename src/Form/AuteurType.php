<?php

namespace App\Form;

use App\Entity\Auteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        -> add('imageFile', FileType::class, [
            'required'=> false,
            "label"=>"Image du livre"
        ])
            ->add('nom')
            ->add('prenom')
            ->add('pseudo')
            ->add('biographie')
            // ->add('imageName')
            ->remove('slug')
            ->add('updatedAt')
            ->add('livres')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Auteur::class,
        ]);
    }
}
