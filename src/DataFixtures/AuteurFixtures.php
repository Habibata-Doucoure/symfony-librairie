<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AuteurFixtures extends Fixture
{
    public const JEAN_ROBA = 'jean-roba';
    public const BELL_HOOKS = 'bell-hooks';
    public function load(ObjectManager $manager): void
    {
        $auteur = new Auteur();
        $auteur->setNom('Roba');
        $auteur->setPrenom('Jean');
        $auteur->setBiographie("Jean Roba, dit Roba, est un auteur de bande dessinée né le 28 juillet 1930 
        à Schaerbeek, dans la région de Bruxelles-Capitale, et mort dans la même ville le 14 juin 2006. 
        Il est surtout connu comme l'auteur de la série Boule et Bill, bien qu'il ait réalisé beaucoup 
        d'autres travaux.");
        $auteur->setSlug('jean-roba');
        $auteur->setImageName('afrique2.jpg');
        $manager->persist($auteur);
        // On associe l'instance de l'auteur à une référence pour pouvoir récupérer l'auteur dans une autre fixture
        // c'est ce qui fera un ajout d'auteur sur notre livre
        $this->addReference(self::JEAN_ROBA, $auteur);

        $auteur = new Auteur();
        $auteur->setPseudo('bell hooks');
        $auteur->setBiographie("Gloria Jean Watkins, connue sous son nom de plume bell hooks,
         née le 25 septembre 1952 à Hopkinsville (Kentucky) 
        et morte le 15 décembre 2021 à Berea (Kentucky), est une intellectuelle, 
        universitaire et militante américaine, 
        théoricienne du black feminism.
        Elle s'intéresse particulièrement aux relations qui existent entre race, classe et genre, et à la production et la perpétuation des systèmes d'oppression et de domination fondés sur ces catégories..");
        $auteur->setSlug("bell-hooks");
        $auteur->setImageName('automne.jpg');
        $manager->persist($auteur);
        $this->addReference(self::BELL_HOOKS, $auteur);

        $manager->flush();
    }
}
