<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategorieFixtures extends Fixture
{
    public const BANDE_DESSINEE = 'bande-dessinee';
    public const ESSAI_PHILOSOPHIQUE = 'essai-philosophique';

    public function load(ObjectManager $manager): void
    {
// Je crée les catégories en utilisant les propriétés set suivie du nom de la propriété qui commence par MAJ
        $categorie = new Categorie();
        $categorie->setNom('Bande dessinée');
        $categorie-> setSlug('bande-dessinee');
        $manager->persist($categorie);
        $this->addReference(self::BANDE_DESSINEE, $categorie);

        $categorie = new Categorie();
        $categorie->setNom('Roman policier');
        $categorie-> setSlug('roman-policier');
        $manager->persist($categorie);

        $categorie = new Categorie();
        $categorie->setNom('Essai philosophique');
        $categorie-> setSlug('essai-philosophique');
        $manager->persist($categorie);
        $this->addReference(self::ESSAI_PHILOSOPHIQUE, $categorie);

        $categorie = new Categorie();
        $categorie->setNom('Thriller');
        $categorie-> setSlug('thriller');
        // persist met en mémoire, à mettre avec chaque donnée
        $manager->persist($categorie);
// flush signifie que c'est envoyé en BDD
        $manager->flush();
    }
}
