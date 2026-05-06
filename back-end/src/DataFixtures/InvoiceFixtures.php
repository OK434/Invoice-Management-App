<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Invoice;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class InvoiceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $clients = $manager->getRepository(Client::class)->findAll();

        for ($i = 1; $i <= 20; $i++) {

            $invoice = new Invoice();

            $quantity = rand(1, 10);
            $price = rand(50, 500);

            $invoice->setDescription("Invoice Description $i");
            $invoice->setInvoiceQuantity($quantity);
            $invoice->setInvoicePrice($price);
            $invoice->setInvoiceTotal($quantity * $price);
            $invoice->setDate(new \DateTime());

            $invoice->setClient(
                $clients[array_rand($clients)]
            );

            $manager->persist($invoice);
        }

        $manager->flush();
    }
}
