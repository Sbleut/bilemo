<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Symfony\Component\Uid\Uuid;

class AppFixtures extends Fixture
{
    
    // MODIFY Fixtures to match Entity + OneFile By FixtureEntity 
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $customer = new Customer();
            $customer->setFirstName("John" . $i );
            $customer->setLastName("Doe" . $i );
            $customer->setEmail("custome@smartphoneapi" . $i . ".com");
            $customer->setUuid(Uuid::v6());
            $manager->persist($customer);
        }

        $manager->flush();
    }
}
