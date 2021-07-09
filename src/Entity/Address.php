<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 */
class Address
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
    private $addressStreet;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $addressComplement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $addressZip;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $addressCity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $addressCountry;

    /**
     * @ORM\ManyToMany(targetEntity=NaturalPerson::class, inversedBy="addresses")
     */
    private $naturalPerson;

    /**
     * @ORM\ManyToMany(targetEntity=LegalPerson::class, inversedBy="addresses")
     */
    private $legalPerson;

    /**
     * @ORM\ManyToMany(targetEntity=Structure::class, mappedBy="adresses")
     */
    private $structures;

    public function __construct()
    {
        $this->naturalPerson = new ArrayCollection();
        $this->legalPerson = new ArrayCollection();
        $this->structures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddressStreet(): ?string
    {
        return $this->addressStreet;
    }

    public function setAddressStreet(string $addressStreet): self
    {
        $this->addressStreet = $addressStreet;

        return $this;
    }

    public function getAddressComplement(): ?string
    {
        return $this->addressComplement;
    }

    public function setAddressComplement(?string $addressComplement): self
    {
        $this->addressComplement = $addressComplement;

        return $this;
    }

    public function getAddressZip(): ?string
    {
        return $this->addressZip;
    }

    public function setAddressZip(string $addressZip): self
    {
        $this->addressZip = $addressZip;

        return $this;
    }

    public function getAddressCity(): ?string
    {
        return $this->addressCity;
    }

    public function setAddressCity(string $addressCity): self
    {
        $this->addressCity = $addressCity;

        return $this;
    }

    public function getAddressCountry(): ?string
    {
        return $this->addressCountry;
    }

    public function setAddressCountry(string $addressCountry): self
    {
        $this->addressCountry = $addressCountry;

        return $this;
    }

    /**
     * @return Collection|NaturalPerson[]
     */
    public function getNaturalPerson(): Collection
    {
        return $this->naturalPerson;
    }

    public function addNaturalPerson(NaturalPerson $naturalPerson): self
    {
        if (!$this->naturalPerson->contains($naturalPerson)) {
            $this->naturalPerson[] = $naturalPerson;
        }

        return $this;
    }

    public function removeNaturalPerson(NaturalPerson $naturalPerson): self
    {
        $this->naturalPerson->removeElement($naturalPerson);

        return $this;
    }

    /**
     * @return Collection|LegalPerson[]
     */
    public function getLegalPerson(): Collection
    {
        return $this->legalPerson;
    }

    public function addLegalPerson(LegalPerson $legalPerson): self
    {
        if (!$this->legalPerson->contains($legalPerson)) {
            $this->legalPerson[] = $legalPerson;
            $legalPerson->addAddress($this);
        }

        return $this;
    }

    public function removeLegalPerson(LegalPerson $legalPerson): self
    {
        if ($this->legalPerson->removeElement($legalPerson)) {
            $legalPerson->removeAddress($this);
        }

        return $this;
    }


    /**
     * @return Collection|Structure[]
     */
    public function getStructures(): Collection
    {
        return $this->structures;
    }

    public function addStructure(Structure $structure): self
    {
        if (!$this->structures->contains($structure)) {
            $this->structures[] = $structure;
            $structure->addAdress($this);
        }

        return $this;
    }

    public function removeStructure(Structure $structure): self
    {
        if ($this->structures->removeElement($structure)) {
            $structure->removeAdress($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->addressStreet . ' ' . $this->addressComplement . ' ' .
            $this->addressZip . ' ' . $this->addressCity . ' ' .
            $this->addressCountry;
    }
}
