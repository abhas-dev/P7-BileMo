<?php

namespace App\DataFixtures;

use App\Entity\ApiToken;
use App\Factory\ApiTokenFactory;
use App\Factory\ClientFactory;
use App\Factory\CustomerFactory;
use App\Factory\PhoneFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $user = UserFactory::createOne(['email' => 'test@test.fr', 'username:' => 'test']);
        $client = ClientFactory::createOne(['email' => 'client1@test.fr', 'password' => '12345678']);
        CustomerFactory::createMany(100, ['client' => $client]);
        PhoneFactory::createMany(100);

        $manager->flush();
    }
}
