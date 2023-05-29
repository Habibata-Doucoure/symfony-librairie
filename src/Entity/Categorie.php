<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Livre::class, orphanRemoval: true)]
    private Collection $y;

    public function __construct()
    {
        $this->y = new ArrayCollection();
    }
// si cet objet devrait être une chaine de caractère quelle est la propriété qu'il doit utiliser pour faire la conversion en string
// évité d'avoir une erreur car chaque catégorie renverra alors  un nom et non pas un objet lorsquil doit étre en chaine de caractère
// ici on utilise la propriété non
    public function __toString(): string
    {
        return $this ->nom;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, Livre>
     */
    public function getY(): Collection
    {
        return $this->y;
    }

    public function addY(Livre $y): self
    {
        if (!$this->y->contains($y)) {
            $this->y->add($y);
            $y->setCategorie($this);
        }

        return $this;
    }

    public function removeY(Livre $y): self
    {
        if ($this->y->removeElement($y)) {
            // set the owning side to null (unless already changed)
            if ($y->getCategorie() === $this) {
                $y->setCategorie(null);
            }
        }

        return $this;
    }
}
