<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nbnVisite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbnVisite(): ?int
    {
        return $this->nbnVisite;
    }

    public function setNbnVisite(int $nbnVisite): self
    {
        $this->nbnVisite = $nbnVisite;

        return $this;
    }
}
