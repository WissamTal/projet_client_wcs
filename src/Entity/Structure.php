<?php

namespace App\Entity;

use App\Repository\StructureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StructureRepository::class)
 */
class Structure
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
     * @ORM\Column(type="string", length=9, nullable=true)
     */
    private $siren;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tradeAndCompanyRegister;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $registeredCapital;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $companyForm;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\ManyToMany(targetEntity=Address::class, inversedBy="structures")
     */
    private $adresses;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephone2;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="structure")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=LegalPerson::class, mappedBy="structure")
     */
    private $legalPerson;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToOne(targetEntity=NaturalPerson::class, inversedBy="mainStructure", cascade={"persist", "remove"})
     */
    private $mainRepresentative;

    /**
     * @ORM\OneToOne(targetEntity=NaturalPerson::class, inversedBy="secondStructure", cascade={"persist", "remove"})
     */
    private $secondRepresentative;

    /**
     * @ORM\OneToMany(targetEntity=NaturalPerson::class, mappedBy="structureMember")
     */
    private $naturalPerson;

    public function __construct()
    {
        $this->adresses = new ArrayCollection();
        $this->user = new ArrayCollection();
        $this->legalPerson = new ArrayCollection();
        $this->naturalPeople = new ArrayCollection();
        $this->naturalPerson = new ArrayCollection();
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

    public function getTradeAndCompanyRegister(): ?string
    {
        return $this->tradeAndCompanyRegister;
    }

    public function setTradeAndCompanyRegister(?string $tradeAndCompanyRegister): self
    {
        $this->tradeAndCompanyRegister = $tradeAndCompanyRegister;

        return $this;
    }

    public function getRegisteredCapital(): ?float
    {
        return $this->registeredCapital;
    }

    public function setRegisteredCapital(?float $registeredCapital): self
    {
        $this->registeredCapital = $registeredCapital;

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

    /**
     * @return Collection|Address[]
     */
    public function getAdresses(): Collection
    {
        return $this->adresses;
    }

    public function addAdress(Address $adress): self
    {
        if (!$this->adresses->contains($adress)) {
            $this->adresses[] = $adress;
        }

        return $this;
    }

    public function removeAdress(Address $adress): self
    {
        $this->adresses->removeElement($adress);

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

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->setStructure($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getStructure() === $this) {
                $user->setStructure(null);
            }
        }

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
            $legalPerson->setStructure($this);
        }

        return $this;
    }

    public function removeLegalPerson(LegalPerson $legalPerson): self
    {
        if ($this->legalPerson->removeElement($legalPerson)) {
            // set the owning side to null (unless already changed)
            if ($legalPerson->getStructure() === $this) {
                $legalPerson->setStructure(null);
            }
        }

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
            $naturalPerson->setStructureMember($this);
        }

        return $this;
    }

    public function removeNaturalPerson(NaturalPerson $naturalPerson): self
    {
        if ($this->naturalPerson->removeElement($naturalPerson)) {
            // set the owning side to null (unless already changed)
            if ($naturalPerson->getStructureMember() === $this) {
                $naturalPerson->setStructureMember(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
