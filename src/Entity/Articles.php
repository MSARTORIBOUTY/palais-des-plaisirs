<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticlesRepository::class)]
class Articles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 80)]
    private $title;

    #[ORM\Column(type: 'string', length: 50)]
    private $pricture;

    #[ORM\Column(type: 'text')]
    private $content;

    #[ORM\Column(type: 'date')]
    private $dateCreate;

    #[ORM\Column(type: 'text', nullable: true)]
    private $ingredients;

    #[ORM\OneToMany(mappedBy: 'id_article', targetEntity: Comments::class, orphanRemoval: true)]
    private $comments;

    #[ORM\ManyToOne(targetEntity: Categories::class, inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private $id_categorie;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPricture(): ?string
    {
        return $this->pricture;
    }

    public function setPricture(string $pricture): self
    {
        $this->pricture = $pricture;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDateCreate(): ?\DateTimeInterface
    {
        return $this->dateCreate;
    }

    public function setDateCreate(\DateTimeInterface $dateCreate): self
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    public function getIngredients(): ?string
    {
        return $this->ingredients;
    }

    public function setIngredients(?string $ingredients): self
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    /**
     * @return Collection<int, Comments>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setIdArticle($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getIdArticle() === $this) {
                $comment->setIdArticle(null);
            }
        }

        return $this;
    }

    public function getIdCategorie(): ?Categories
    {
        return $this->id_categorie;
    }

    public function setIdCategorie(?Categories $id_categorie): self
    {
        $this->id_categorie = $id_categorie;

        return $this;
    }
}
