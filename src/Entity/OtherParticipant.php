<?php

namespace App\Entity;

use App\Repository\OtherParticipantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OtherParticipantRepository::class)
 */
class OtherParticipant
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
    private $otherParticipantRole;

    /**
     * @ORM\OneToOne(targetEntity=NaturalPerson::class, inversedBy="otherParticipant", cascade={"persist", "remove"})
     */
    private $naturalPerson;

    /**
     * @ORM\OneToOne(targetEntity=LegalPerson::class, inversedBy="otherParticipant", cascade={"persist", "remove"})
     */
    private $legalPerson;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOtherParticipantRole(): ?string
    {
        return $this->otherParticipantRole;
    }

    public function setOtherParticipantRole(string $otherParticipantRole): self
    {
        $this->otherParticipantRole = $otherParticipantRole;

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

    public function getLegalPerson(): ?LegalPerson
    {
        return $this->legalPerson;
    }

    public function setLegalPerson(?LegalPerson $legalPerson): self
    {
        $this->legalPerson = $legalPerson;

        return $this;
    }
}
