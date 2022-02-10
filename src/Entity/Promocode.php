<?php

namespace App\Entity;

use App\Repository\PromocodeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromocodeRepository::class)]
#[ORM\UniqueConstraint(name: 'keyword_uniq_idx', columns: ['keyword'])]
class Promocode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $keyword;

    #[ORM\Column(type: 'float')]
    private $discount_percent;

    #[ORM\Column(type: 'integer')]
    private $number_of_uses;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKeyword(): ?string
    {
        return $this->keyword;
    }

    public function setKeyword(string $keyword): self
    {
        $this->keyword = $keyword;

        return $this;
    }

    public function getDiscountPercent(): ?float
    {
        return $this->discount_percent;
    }

    public function setDiscountPercent(float $discount_percent): self
    {
        $this->discount_percent = $discount_percent;

        return $this;
    }

    public function getNumberOfUses(): ?int
    {
        return $this->number_of_uses;
    }

    public function setNumberOfUses(int $number_of_uses): self
    {
        $this->number_of_uses = $number_of_uses;

        return $this;
    }
}
