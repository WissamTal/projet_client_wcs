<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbMinAction;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbMaxAction;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prefixClassification;

    /**
     * @ORM\Column(type="integer")
     */
    private $shareValue;

    /**
     * @ORM\OneToMany(targetEntity=Associate::class, mappedBy="category")
     */
    private $associates;

    public function __construct()
    {
        $this->associates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getNbMinAction(): ?int
    {
        return $this->nbMinAction;
    }

    public function setNbMinAction(int $nbMinAction): self
    {
        $this->nbMinAction = $nbMinAction;

        return $this;
    }

    public function getNbMaxAction(): ?int
    {
        return $this->nbMaxAction;
    }

    public function setNbMaxAction(int $nbMaxAction): self
    {
        $this->nbMaxAction = $nbMaxAction;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrefixClassification(): ?string
    {
        return $this->prefixClassification;
    }

    public function setPrefixClassification(string $prefixClassification): self
    {
        $this->prefixClassification = $prefixClassification;

        return $this;
    }

    public function getShareValue(): ?int
    {
        return $this->shareValue;
    }

    public function setShareValue(int $shareValue): self
    {
        $this->shareValue = $shareValue;

        return $this;
    }

    /**
     * @return Collection|Associate[]
     */
    public function getAssociates(): Collection
    {
        return $this->associates;
    }

    public function addAssociate(Associate $associate): self
    {
        if (!$this->associates->contains($associate)) {
            $this->associates[] = $associate;
            $associate->setCategory($this);
        }

        return $this;
    }

    public function removeAssociate(Associate $associate): self
    {
        if ($this->associates->removeElement($associate)) {
            // set the owning side to null (unless already changed)
            if ($associate->getCategory() === $this) {
                $associate->setCategory(null);
            }
        }

        return $this;
    }
}
