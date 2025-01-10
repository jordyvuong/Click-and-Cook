<?php

namespace App\Entity;

use App\Repository\CuisineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CuisineRepository::class)]
class Cuisine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Recipe>
     */
    #[ORM\OneToMany(targetEntity: Recipe::class, mappedBy: 'cuisine')]
    private Collection $cuisine;

    public function __construct()
    {
        $this->cuisine = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Recipe>
     */
    public function getCuisine(): Collection
    {
        return $this->cuisine;
    }

    public function addCuisine(Recipe $cuisine): static
    {
        if (!$this->cuisine->contains($cuisine)) {
            $this->cuisine->add($cuisine);
            $cuisine->setCuisine($this);
        }

        return $this;
    }

    public function removeCuisine(Recipe $cuisine): static
    {
        if ($this->cuisine->removeElement($cuisine)) {
            if ($cuisine->getCuisine() === $this) {
                $cuisine->setCuisine(null);
            }
        }

        return $this;
    }
}
