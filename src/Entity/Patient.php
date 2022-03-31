<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $refererFirstName;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $refererLastName;

    #[ORM\Column(type: 'string', length: 255)]
    private $patientFirstName;

    #[ORM\Column(type: 'string', length: 255)]
    private $patientLastName;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $token;

    #[ORM\OneToMany(mappedBy: 'patient', targetEntity: Answer::class)]
    private $answers;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRefererFirstName(): ?string
    {
        return $this->refererFirstName;
    }

    public function setRefererFirstName(?string $refererFirstName): self
    {
        $this->refererFirstName = $refererFirstName;

        return $this;
    }

    public function getRefererLastName(): ?string
    {
        return $this->refererLastName;
    }

    public function setRefererLastName(?string $refererLastName): self
    {
        $this->refererLastName = $refererLastName;

        return $this;
    }

    public function getPatientFirstName(): ?string
    {
        return $this->patientFirstName;
    }

    public function setPatientFirstName(string $patientFirstName): self
    {
        $this->patientFirstName = $patientFirstName;

        return $this;
    }

    public function getPatientLastName(): ?string
    {
        return $this->patientLastName;
    }

    public function setPatientLastName(string $patientLastName): self
    {
        $this->patientLastName = $patientLastName;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return Collection<int, Answer>
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setPatient($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getPatient() === $this) {
                $answer->setPatient(null);
            }
        }

        return $this;
    }
}
