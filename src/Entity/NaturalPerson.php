<?php

namespace App\Entity;

use App\Repository\NaturalPersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=NaturalPersonRepository::class)
 */
class NaturalPerson
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1)
     * @Assert\NotBlank()
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $lastname;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateOfBirth;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $placeOfBirth;

    /**
     * @ORM\OneToOne(targetEntity=LegalPerson::class, mappedBy="mainRepresentative", cascade={"persist", "remove"})
     */
    private $mainLegalPerson;

    /**
     * @ORM\OneToOne(targetEntity=LegalPerson::class, mappedBy="secondRepresentative", cascade={"persist", "remove"})
     */
    private $secondLegalPerson;

    /**
     * @ORM\ManyToMany(targetEntity=Address::class, mappedBy="naturalPerson")
     */
    private $addresses;

    /**
     * @ORM\OneToOne(targetEntity=OtherParticipant::class, mappedBy="naturalPerson", cascade={"persist", "remove"})
     */
    private $otherParticipant;

    /**
     * @ORM\OneToOne(targetEntity=Executive::class, mappedBy="naturalPerson", cascade={"persist", "remove"})
     */
    private $executive;

    /**
     * @ORM\OneToOne(targetEntity=Associate::class, mappedBy="naturalPerson", cascade={"persist", "remove"})
     */
    private $associate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephone2;

    /**
     * @ORM\OneToOne(targetEntity=Structure::class, mappedBy="mainRepresentative", cascade={"persist", "remove"})
     */
    private $mainStructure;

    /**
     * @ORM\OneToOne(targetEntity=Structure::class, mappedBy="secondRepresentative", cascade={"persist", "remove"})
     */
    private $secondStructure;

    /**
     * @ORM\ManyToOne(targetEntity=Structure::class, inversedBy="naturalPerson")
     */
    private $structureMember;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isSelected = false;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getPlaceOfBirth(): ?string
    {
        return $this->placeOfBirth;
    }

    public function setPlaceOfBirth(?string $placeOfBirth): self
    {
        $this->placeOfBirth = $placeOfBirth;

        return $this;
    }

    public function getMainLegalPerson(): ?LegalPerson
    {
        return $this->mainLegalPerson;
    }

    public function setMainLegalPerson(?LegalPerson $mainLegalPerson): self
    {
        // unset the owning side of the relation if necessary
        if ($mainLegalPerson === null && $this->mainLegalPerson !== null) {
            $this->mainLegalPerson->setMainRepresentative(null);
        }

        // set the owning side of the relation if necessary
        if ($mainLegalPerson !== null && $mainLegalPerson->getMainRepresentative() !== $this) {
            $mainLegalPerson->setMainRepresentative($this);
        }

        $this->mainLegalPerson = $mainLegalPerson;

        return $this;
    }

    public function getSecondLegalPerson(): ?LegalPerson
    {
        return $this->secondLegalPerson;
    }

    public function setSecondLegalPerson(?LegalPerson $secondLegalPerson): self
    {
        // unset the owning side of the relation if necessary
        if ($secondLegalPerson === null && $this->secondLegalPerson !== null) {
            $this->secondLegalPerson->setSecondRepresentative(null);
        }

        // set the owning side of the relation if necessary
        if ($secondLegalPerson !== null && $secondLegalPerson->getSecondRepresentative() !== $this) {
            $secondLegalPerson->setSecondRepresentative($this);
        }

        $this->secondLegalPerson = $secondLegalPerson;

        return $this;
    }

    /**
     * @return Collection|Address[]
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses[] = $address;
            $address->addNaturalPerson($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        if ($this->addresses->removeElement($address)) {
            $address->removeNaturalPerson($this);
        }

        return $this;
    }

    public function getOtherParticipant(): ?OtherParticipant
    {
        return $this->otherParticipant;
    }

    public function setOtherParticipant(?OtherParticipant $otherParticipant): self
    {
        // unset the owning side of the relation if necessary
        if ($otherParticipant === null && $this->otherParticipant !== null) {
            $this->otherParticipant->setNaturalPerson(null);
        }

        // set the owning side of the relation if necessary
        if ($otherParticipant !== null && $otherParticipant->getNaturalPerson() !== $this) {
            $otherParticipant->setNaturalPerson($this);
        }

        $this->otherParticipant = $otherParticipant;

        return $this;
    }

    public function getExecutive(): ?Executive
    {
        return $this->executive;
    }

    public function setExecutive(?Executive $executive): self
    {
        // unset the owning side of the relation if necessary
        if ($executive === null && $this->executive !== null) {
            $this->executive->setNaturalPerson(null);
        }

        // set the owning side of the relation if necessary
        if ($executive !== null && $executive->getNaturalPerson() !== $this) {
            $executive->setNaturalPerson($this);
        }

        $this->executive = $executive;

        return $this;
    }

    public function getAssociate(): ?Associate
    {
        return $this->associate;
    }

    public function setAssociate(?Associate $associate): self
    {
        // unset the owning side of the relation if necessary
        if ($associate === null && $this->associate !== null) {
            $this->associate->setNaturalPerson(null);
        }

        // set the owning side of the relation if necessary
        if ($associate !== null && $associate->getNaturalPerson() !== $this) {
            $associate->setNaturalPerson($this);
        }

        $this->associate = $associate;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getTelephone2(): ?string
    {
        return $this->telephone2;
    }

    public function setTelephone2(?string $telephone2): self
    {
        $this->telephone2 = $telephone2;

        return $this;
    }

    public function __toString()
    {
        return $this->lastname . ' ' . $this->firstname;
    }

    public function getMainStructure(): ?Structure
    {
        return $this->mainStructure;
    }

    public function setMainStructure(?Structure $mainStructure): self
    {
        // unset the owning side of the relation if necessary
        if ($mainStructure === null && $this->mainStructure !== null) {
            $this->mainStructure->setMainRepresentative(null);
        }

        // set the owning side of the relation if necessary
        if ($mainStructure !== null && $mainStructure->getMainRepresentative() !== $this) {
            $mainStructure->setMainRepresentative($this);
        }

        $this->mainStructure = $mainStructure;

        return $this;
    }

    public function getSecondStructure(): ?Structure
    {
        return $this->secondStructure;
    }

    public function setSecondStructure(?Structure $secondStructure): self
    {
        // unset the owning side of the relation if necessary
        if ($secondStructure === null && $this->secondStructure !== null) {
            $this->secondStructure->setSecondRepresentative(null);
        }

        // set the owning side of the relation if necessary
        if ($secondStructure !== null && $secondStructure->getSecondRepresentative() !== $this) {
            $secondStructure->setSecondRepresentative($this);
        }

        $this->secondStructure = $secondStructure;

        return $this;
    }

    public function getStructureMember(): ?Structure
    {
        return $this->structureMember;
    }

    public function setStructureMember(?Structure $structureMember): self
    {
        $this->structureMember = $structureMember;

        return $this;
    }

    public function getIsSelected(): ?bool
    {
        return $this->isSelected;
    }

    public function setIsSelected(bool $isSelected): self
    {
        $this->isSelected = $isSelected;

        return $this;
    }
}
