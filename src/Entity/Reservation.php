<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="reservations")
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="reservations")
     */
    private $reservedBy;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $returned;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $returnedAt;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getReservedBy(): ?User
    {
        return $this->reservedBy;
    }

    public function setReservedBy(?User $reservedBy): self
    {
        $this->reservedBy = $reservedBy;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getReturned(): ?bool
    {
        return $this->returned;
    }

    public function setReturned(bool $returned): self
    {
        $this->returned = $returned;

        return $this;
    }

    public function getReturnedAt(): ?\DateTimeInterface
    {
        return $this->returnedAt;
    }

    public function setReturnedAt(?\DateTimeInterface $returnedAt): self
    {
        $this->returnedAt = $returnedAt;

        return $this;
    }
}
