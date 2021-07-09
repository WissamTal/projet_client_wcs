<?php

namespace App\Entity;

use App\Repository\ExecutiveRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExecutiveRepository::class)
 */
class Executive
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $mandateStartdate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $mandateEnddate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mandateType;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $mandateLimitations;

    /**
     * @ORM\OneToOne(targetEntity=LegalPerson::class, inversedBy="executive", cascade={"persist", "remove"})
     */
    private $legalPerson;

    /**
     * @ORM\OneToOne(targetEntity=NaturalPerson::class, inversedBy="executive", cascade={"persist", "remove"})
     */
    private $naturalPerson;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMandateStartdate(): ?\DateTimeInterface
    {
        return $this->mandateStartdate;
    }

    public function setMandateStartdate(\DateTimeInterface $mandateStartdate): self
    {
        $this->mandateStartdate = $mandateStartdate;
        return $this;
    }

    public function getMandateEnddate(): ?\DateTimeInterface
    {
        return $this->mandateEnddate;
    }

    public function setMandateEnddate(?\DateTimeInterface $mandateEnddate): self
    {
        $this->mandateEnddate = $mandateEnddate;

        return $this;
    }

    public function getMandateType(): ?string
    {
        return $this->mandateType;
    }

    public function setMandateType(string $mandateType): self
    {
        $this->mandateType = $mandateType;

        return $this;
    }

    public function getMandateLimitations(): ?string
    {
        return $this->mandateLimitations;
    }

    public function setMandateLimitations(?string $mandateLimitations): self
    {
        $this->mandateLimitations = $mandateLimitations;

        return $this;
    }

    public function getLegalPerson(): ?LegalPerson
    {
        return $this->legalPerson;
    }

    public function setLegalPerson(?LegalPerson $legalPerson): self
    {
        $this->legalPerson = $legalPerson;

        return $this;
    }

    public function getNaturalPerson(): ?NaturalPerson
    {
        return $this->naturalPerson;
    }

    public function setNaturalPerson(?NaturalPerson $naturalPerson): self
    {
        $this->naturalPerson = $naturalPerson;

        return $this;
    }
}
