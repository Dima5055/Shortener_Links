<?php

namespace App\Entity;

use App\Repository\LinksRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\DateType;

#[ORM\Entity(repositoryClass: LinksRepository::class)]
class Links
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Значение поля не передано')]
    #[Assert\Url(message: 'Указанная ссылка {{ value }} не является url',)]
    private ?string $originalUrl = null;

    #[ORM\Column(length: 255)]
    private ?string $shortUrl = null;

    #[ORM\Column]
    private ?\DateTime $creationDate = null;

    #[ORM\Column]
    private ?\DateTime $lastUseDate = null;

    #[ORM\Column]
    private ?int $numbersOfClick = null;

    #[ORM\Column(nullable: true)]
    private ?bool $disposable = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    //#[Assert\DateTime(message: 'Указанное значение даты {{ value }} не является правильной',)]
    private ?\DateTime $expirationDate = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOriginalUrl(): ?string
    {
        return $this->originalUrl;
    }

    public function setOriginalUrl(string $originalUrl): static
    {
        $this->originalUrl = $originalUrl;

        return $this;
    }

    public function getShortUrl(): ?string
    {
        return $this->shortUrl;
    }

    public function setShortUrl(string $shortUrl): static
    {
        $this->shortUrl = $shortUrl;

        return $this;
    }

    public function getCreationDate(): ?\DateTime
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTime $creationDate): static
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getLastUseDate(): ?\DateTime
    {
        return $this->lastUseDate;
    }

    public function setLastUseDate(\DateTime $lastUseDate): static
    {
        $this->lastUseDate = $lastUseDate;

        return $this;
    }

    public function getNumbersOfClick(): ?int
    {
        return $this->numbersOfClick;
    }

    public function setNumbersOfClick(int $numbersOfClick): static
    {
        $this->numbersOfClick = $numbersOfClick;
        return $this;
    }

    public function isDisposable(): ?bool
    {
        return $this->disposable;
    }

    public function setDisposable(bool $disposable): static
    {
        $this->disposable = $disposable;

        return $this;
    }

    public function getExpirationDate(): ?\DateTime
    {
        return $this->expirationDate;
    }


    public function setExpirationDate(?\DateTime $expirationDate): self
    {
        $this->expirationDate = $expirationDate;
        return $this;
    }
}
