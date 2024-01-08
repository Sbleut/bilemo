<?php

namespace App\DataFixtures;

use App\Entity\Smartphone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Symfony\Component\Uid\Uuid;

class SmartphoneFixtures extends Fixture
{

    
    // MODIFY Fixtures to match Entity + OneFile By FixtureEntity 
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $smartphone = new Smartphone();
            $smartphone->setName("Smartphone " . $i);
            $smartphone->setDescription("Ce téléphone présente les caractéristiques suivantes " . $i);
            $smartphone->setBrand("Nokia " . $i);
            $randomPrice = mt_rand(10000, 200000) / 100;
            $smartphone->setPrice($randomPrice);
            $smartphone->setUuid(Uuid::v6());

            $manager->persist($smartphone);
        }

        $manager->flush();

    }
}