<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Invoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 550)]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: "invoices")]
    private ?Client $client = null;
    #[ORM\Column(type: "datetime")]
    private ?\DateTimeInterface $date = null;
    #[ORM\Column]
    private ?int $invoiceQuantity = null;
    #[ORM\Column]
    private ?int $invoicePrice = null;
    #[ORM\Column]
    private ?int $invoiceTotal = null;

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): void
    {
        $this->date = $date;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): void
    {
        $this->client = $client;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }


    public function getInvoiceQuantity(): ?int
    {
        return $this->invoiceQuantity;
    }

    public function setInvoiceQuantity(?int $invoiceQuantity): self
    {
        $this->invoiceQuantity = $invoiceQuantity;
        return $this;
    }

    public function getInvoicePrice(): ?int
    {
        return $this->invoicePrice;
    }

    public function setInvoicePrice(?int $invoicePrice): self
    {
        $this->invoicePrice = $invoicePrice;
        return $this;
    }

    public function getInvoiceTotal(): ?int
    {
        return $this->invoiceTotal;
    }

    public function setInvoiceTotal(?int $invoiceTotal): self
    {
        $this->invoiceTotal = $invoiceTotal;
        return $this;
    }
}
