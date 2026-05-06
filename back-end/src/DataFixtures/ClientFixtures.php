<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {

            $client = new Client();

            $password = "12345678";
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $client->setClientName("Client $i");
            $client->setEmail("client$i@gmail.com");
            $client->setPassword($hashedPassword);
            $client->setCompanyName("Company $i");
            $client->setAddressName("Address $i");

            $manager->persist($client);
        }

        $manager->flush();
    }
}
