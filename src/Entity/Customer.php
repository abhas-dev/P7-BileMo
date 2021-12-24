<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups("customer_read", "customer_edit")]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups("customer_read", "customer_edit")]
    #[Assert\NotBlank(message: 'Veuillez indiquer un prenom')]
    private string $firstname;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups("customer_read", "customer_edit")]
    #[Assert\NotBlank(message: 'Veuillez indiquer un nom')]
    private string $lastname;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups("customer_read", "customer_edit")]
    #[Assert\NotBlank(message: 'Veuillez indiquer une adresse')]
    private string $adress;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups("customer_read", "customer_edit")]
    #[Assert\NotBlank(message: 'Veuillez indiquer une adresse email')]
    private string $email;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups("customer_read", "customer_edit")]
    #[Assert\NotBlank(message: 'Veuillez indiquer un numero de telephone')]
    private string $phoneNumber;

    #[ORM\Column(type: 'datetime')]
    #[Groups("customer_read")]
    private \DateTime $createdAt;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'customers')]
    #[Groups("client_detail")]
    private Client $client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
