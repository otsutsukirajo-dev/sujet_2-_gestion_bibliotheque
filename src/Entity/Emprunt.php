<?php

namespace App\Entity;

use App\Repository\EmpruntRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EmpruntRepository::class)]
class Emprunt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateEmprunt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateRetourPrevue = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateRetourEffective = null;

    #[ORM\ManyToOne(inversedBy: 'emprunts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'Veuillez sélectionner un livre.')]
    private ?Livre $livre = null;

    #[ORM\ManyToOne(inversedBy: 'emprunts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'Veuillez choisir un utilisateur.')]
    private ?User $user = null;

    public function getId(): ?int { return $this->id; }

    public function getDateEmprunt(): ?\DateTimeInterface { return $this->dateEmprunt; }
    public function setDateEmprunt(\DateTimeInterface $dateEmprunt): static { $this->dateEmprunt = $dateEmprunt; return $this; }

    public function getDateRetourPrevue(): ?\DateTimeInterface { return $this->dateRetourPrevue; }
    public function setDateRetourPrevue(\DateTimeInterface $dateRetourPrevue): static { $this->dateRetourPrevue = $dateRetourPrevue; return $this; }

    public function getDateRetourEffective(): ?\DateTimeInterface { return $this->dateRetourEffective; }
    public function setDateRetourEffective(?\DateTimeInterface $dateRetourEffective): static { $this->dateRetourEffective = $dateRetourEffective; return $this; }

    public function getLivre(): ?Livre { return $this->livre; }
    public function setLivre(?Livre $livre): static { $this->livre = $livre; return $this; }

    public function getUser(): ?User { return $this->user; }
    public function setUser(?User $user): static { $this->user = $user; return $this; }
}