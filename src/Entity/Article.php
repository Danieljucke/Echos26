<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $teaser = null;

    #[ORM\Column(length: 5000)]
    private ?string $corps = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Type $type = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Image $imageEntete = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    private ?Image $imageCorps = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $ecritPar = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateAffihcer = null;

    #[ORM\Column]
    private ?bool $statut = null;

    #[ORM\OneToMany(mappedBy: 'article', targetEntity: Commentaire::class)]
    private Collection $commentaires;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Section = null;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getTeaser(): ?string
    {
        return $this->teaser;
    }

    public function setTeaser(string $teaser): self
    {
        $this->teaser = $teaser;

        return $this;
    }

    public function getCorps(): ?string
    {
        return $this->corps;
    }

    public function setCorps(string $corps): self
    {
        $this->corps = $corps;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getImageEntete(): ?Image
    {
        return $this->imageEntete;
    }

    public function setImageEntete(?Image $imageEntete): self
    {
        $this->imageEntete = $imageEntete;

        return $this;
    }

    public function getImageCorps(): ?Image
    {
        return $this->imageCorps;
    }

    public function setImageCorps(?Image $imageCorps): self
    {
        $this->imageCorps = $imageCorps;

        return $this;
    }

    public function getEcritPar(): ?string
    {
        return $this->ecritPar;
    }

    public function setEcritPar(?string $ecritPar): self
    {
        $this->ecritPar = $ecritPar;

        return $this;
    }

    public function getDateAffihcer(): ?\DateTimeInterface
    {
        return $this->DateAffihcer;
    }

    public function setDateAffihcer(?\DateTimeInterface $DateAffihcer): self
    {
        $this->DateAffihcer = $DateAffihcer;

        return $this;
    }

    public function isStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setArticle($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getArticle() === $this) {
                $commentaire->setArticle(null);
            }
        }

        return $this;
    }

    public function getSection(): ?string
    {
        return $this->Section;
    }

    public function setSection(?string $Section): self
    {
        $this->Section = $Section;

        return $this;
    }

    public function __toString(): string
    {
        return $this->titre;
    }
}
