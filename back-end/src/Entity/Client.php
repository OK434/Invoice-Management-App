<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
class Client implements UserInterface
{
    public function __construct()
    {
        $this->invoices = new ArrayCollection();
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 255, unique: true)]
    private ?string $clientName = null;
    #[ORM\Column(length: 255)]
    private ?string $email = null;
    #[ORM\Column(length: 255)]
    private ?string $password = null;
    #[ORM\Column(length: 255)]
    private ?string $companyName = null;

    #[ORM\Column(length: 255)]
    private ?string $addressName = null;
    #[ORM\OneToMany(mappedBy: "client", targetEntity: Invoice::class)]
    private Collection $invoices;

    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function setInvoices(Collection $invoices): void
    {
        $this->invoices = $invoices;
    }

    public function setClientName(string $clientName): string
    {
        return $this->clientName = $clientName;
    }

    public function setEmail(string $email): string
    {
        return $this->email = $email;
    }

    public function setPassword(string $password): string
    {
        return $this->password = $password;
    }

    public function setCompanyName(string $companyName): string
    {
        return $this->companyName = $companyName;
    }

    public function setAddressName(string $addressName): string
    {
        return $this->addressName = $addressName;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientName(): ?string
    {
        return $this->clientName;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function getAddressName(): ?string
    {
        return $this->addressName;
    }


    public function getRoles(): array
    {

        return ['ROLE_CLIENT'];
    }

    public function eraseCredentials(): void
    {

    }

    public function getUserIdentifier(): string
    {

        return (string)$this->email;
    }
}
