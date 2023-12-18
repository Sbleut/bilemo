<?php

namespace App\DataFixtures;

use App\Entity\Reseller;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

class ResellerFixtures extends Fixture
{
    private $userPasswordHasher;
    
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {
            $reseller = new Reseller();
            $reseller->setEmail("user@smartphoneapi" . $i . ".com");
            $reseller->setCompanyName("Operator" . $i);
            $reseller->setRoles(["ROLE_USER"]);
            $reseller->setUuid(Uuid::v6());
            $reseller->setPassword($this->userPasswordHasher->hashPassword($reseller, "password"));
            $manager->persist($reseller);
            $listReseller[]= $reseller;
        }

        // Création d'un user admin
        $userAdmin = new Reseller();
        $userAdmin->setEmail("admin@bookapi.com");
        $userAdmin->setRoles(["ROLE_ADMIN"]);
        $userAdmin->setPassword($this->userPasswordHasher->hashPassword($userAdmin, "password"));
        $manager->persist($userAdmin);

        $manager->flush();
    }

}