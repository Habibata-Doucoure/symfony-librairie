<?php

namespace App\Form;

use App\Entity\Livre;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            -> add('imageFile', FileType::class, [
                'required'=> false,
                "label"=>"Image du livre"
            ])
            ->add('titre')
            ->add('description',CKEditorType::class)
            // ->add('imageName')
// remove ou le fait de mettre en commentaire permet de ne pas l'afficher à l'admin que ce soit géré par php, c'est pareil
            ->remove('slug')
            ->remove('updatedAt',DateTimeType::class,[
                'widget'=> 'single_text',
                'data'=>new \DateTimeImmutable(),
            ])
            ->add('categorie', EntityType::class, [
                'class'=>'App\Entity\Categorie'
            ])
            ->add('auteurs', EntityType::class,[
                'class'=>'App\Entity\Auteur',
                'multiple'=> true,
                // je spécifie les attributs html que je veux dans mon rendu qui ne sont pas dsleformulaire de base
                'attr'=> [
                        "class"=>"select2"
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
