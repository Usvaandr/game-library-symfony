<?php

namespace App\Entity;

use App\Repository\PublisherRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PublisherRepository::class)
 */
class Publisher
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="text", length=100)
     */
    private $value;

    /**
     * @var string
     * @ORM\Column(type="text", length=100)
     */
    private $country;

    /**
     * @var DateTime
     * @ORM\Column(type="date")
     */
    private $year;

    /**
     * @var Game[]
     * @ORM\OneToMany(targetEntity="Game", mappedBy="publisher", orphanRemoval=true)
     */
    private $games;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isDeleted = 0;

    public function __construct()
    {
        $this->games = new ArrayCollection();
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

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getYear(): ?DateTime
    {
        return $this->year;
    }

    public function setYear(DateTime $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getIsDeleted(): int
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(int $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    public function hasGames(): bool
    {
        return $this->getGames()->isEmpty();
    }

    /**
     * @return Collection|Game[]
     */
    public function getGames(): Collection
    {
        return $this->games;
    }
}
