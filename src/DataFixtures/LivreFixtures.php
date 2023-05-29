<?php

namespace App\DataFixtures;
use App\Entity\Livre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LivreFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $livre = new Livre();
        $livre->setTitre("Boule et Bill");
        $livre->setDescription("Lorem Ipsum") ;
        $livre->setSlug("boule-et-bill-l-echappee-belle");
        $livre->setImageName("livre-bell-hooks.jpg");
        // permet de récupérer la référence de catégorie,la relation est many to one c'est pour ça que c'est un getReference
        $livre->setCategorie($this->getReference(CategorieFixtures::BANDE_DESSINEE));
        $livre->addAuteur($this->getReference(AuteurFixtures::JEAN_ROBA));
        // persist se met à la fin de toutes les propriétés car il enregistre les données
        $manager->persist($livre);

        $livre = new Livre();
        $manager->persist($livre);
        $livre->setTitre("A propos d'amour");
        $livre->setDescription("Définissant l\'amour comme un acte et non comme un sentiment, 
        bell hooks démonte tous les obstacles que la culture patriarcale oppose à des relations d\'amour.") ;
        $livre->setSlug("noa-propos-d-amour");
        $livre->setImageName("livre-bell-hooks.jpg");
        $livre->setCategorie($this->getReference(CategorieFixtures::ESSAI_PHILOSOPHIQUE));
        // la relation est manytomany c'est pour ça qu'on met un addAuteur et non get auteur
        $livre->addAuteur($this->getReference(AuteurFixtures::BELL_HOOKS));
        $manager->persist($livre);

        $manager->flush();
    }
}
