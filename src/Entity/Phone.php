<?php

namespace App\Entity;

use App\Repository\PhoneRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PhoneRepository::class)]
class Phone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups("phone:read")]
    private int $id; /** @phpstan-ignore-line */

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups("phone:read")]
    private string $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups("phone:read")]
    private string $display;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups("phone:read")]
    private string $processor;

    #[ORM\Column(type: 'integer')]
    #[Groups("phone:read")]
    private int $batteryCapacity;

    #[ORM\Column(type: 'integer')]
    #[Groups("phone:read")]
    private int $price;

    #[ORM\Column(type: 'integer')]
    #[Groups("phone:read")]
    private int $quantity;

    #[ORM\Column(type: 'datetime')]
    #[Groups("phone:read")]
    private \DateTime $createdAt;

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

    public function getDisplay(): ?float
    {
        return $this->display; /** @phpstan-ignore-line */
    }

    public function setDisplay(float $display): self
    {
        $this->display = $display; /** @phpstan-ignore-line */

        return $this;
    }

    public function getProcessor(): ?string
    {
        return $this->processor;
    }

    public function setProcessor(string $processor): self
    {
        $this->processor = $processor;

        return $this;
    }

    public function getBatteryCapacity(): ?int
    {
        return $this->batteryCapacity;
    }

    public function setBatteryCapacity(int $batteryCapacity): self
    {
        $this->batteryCapacity = $batteryCapacity;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
