<?php

namespace App\Entity;

use App\Repository\CommentsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentsRepository::class)]
class Comments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Users::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private $id_user;

    #[ORM\ManyToOne(targetEntity: Articles::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private $id_article;

    #[ORM\Column(type: 'text')]
    private $content;

    #[ORM\Column(type: 'datetime')]
    private $dateCreate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?Users
    {
        return $this->id_user;
    }

    public function setIdUser(?Users $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getIdArticle(): ?Articles
    {
        return $this->id_article;
    }

    public function setIdArticle(?Articles $id_article): self
    {
        $this->id_article = $id_article;

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
}
