<?php

namespace App\Entity;

use App\Repository\LegalPersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=LegalPersonRepository::class)
 */
class LegalPerson
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=9, nullable=true)
     */
    private $siren;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tradeAndCompagnyRegister;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $registerCapital;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $companyForm;

    /**
     * @ORM\OneToOne(targetEntity=NaturalPerson::class, inversedBy="mainLegalPerson", cascade={"persist", "remove"})
     */
    private $mainRepresentative;

    /**
     * @ORM\OneToOne(targetEntity=NaturalPerson::class, inversedBy="secondLegalPerson", cascade={"persist", "remove"})
     */
    private $secondRepresentative;

    /**
     * @ORM\ManyToMany(targetEntity=Address::class, mappedBy="legalPerson", cascade={"persist"})
     */
    private $addresses;

    /**
     * @ORM\OneToOne(targetEntity=OtherParticipant::class, mappedBy="legalPerson", cascade={"persist", "remove"})
     */
    private $otherParticipant;

    /**
     * @ORM\OneToOne(targetEntity=Executive::class, mappedBy="legalPerson", cascade={"persist", "remove"})
     */
    private $executive;

    /**
     * @ORM\OneToOne(targetEntity=Associate::class, mappedBy="legalPerson", cascade={"persist", "remove"})
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
     * @ORM\ManyToOne(targetEntity=Structure::class, inversedBy="legalPerson")
     */
    private $structure;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    public function getSiren(): ?string
    {
        return $this->siren;
    }

    public function setSiren(?string $siren): self
    {
        $this->siren = $siren;

        return $this;
    }

    public function getTradeAndCompagnyRegister(): ?string
    {
        return $this->tradeAndCompagnyRegister;
    }

    public function setTradeAndCompagnyRegister(?string $tradeAndCompagnyRegister): self
    {
        $this->tradeAndCompagnyRegister = $tradeAndCompagnyRegister;

        return $this;
    }

    public function getRegisterCapital(): ?float
    {
        return $this->registerCapital;
    }

    public function setRegisterCapital(?float $registerCapital): self
    {
        $this->registerCapital = $registerCapital;

        return $this;
    }

    public function getCompanyForm(): ?string
    {
        return $this->companyForm;
    }

    public function setCompanyForm(string $companyForm): self
    {
        $this->companyForm = $companyForm;

        return $this;
    }

    public function getMainRepresentative(): ?NaturalPerson
    {
        return $this->mainRepresentative;
    }

    public function setMainRepresentative(?NaturalPerson $mainRepresentative): self
    {
        $this->mainRepresentative = $mainRepresentative;

        return $this;
    }

    public function getSecondRepresentative(): ?NaturalPerson
    {
        return $this->secondRepresentative;
    }

    public function setSecondRepresentative(?NaturalPerson $secondRepresentative): self
    {
        $this->secondRepresentative = $secondRepresentative;

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
            $address->addLegalPerson($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        if ($this->addresses->removeElement($address)) {
            $address->removeLegalPerson($this);
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
            $this->otherParticipant->setLegalPerson(null);
        }

        // set the owning side of the relation if necessary
        if ($otherParticipant !== null && $otherParticipant->getLegalPerson() !== $this) {
            $otherParticipant->setLegalPerson($this);
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
            $this->executive->setLegalPerson(null);
        }

        // set the owning side of the relation if necessary
        if ($executive !== null && $executive->getLegalPerson() !== $this) {
            $executive->setLegalPerson($this);
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
            $this->associate->setLegalPerson(null);
        }

        // set the owning side of the relation if necessary
        if ($associate !== null && $associate->getLegalPerson() !== $this) {
            $associate->setLegalPerson($this);
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
        return $this->name;
    }

    public function getStructure(): ?Structure
    {
        return $this->structure;
    }

    public function setStructure(?Structure $structure): self
    {
        $this->structure = $structure;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
