<?php

namespace App\DataFixtures;

use App\Entity\Reseller;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

class ResellerFixtures extends Fixture
{
    /**
     * Constant to reference load order
     *
     */
    public const RESELLER_REFERENCE = 'reseller';
    /**
     * UserPasswordHasher to Hash Password before bdd push
     *
     * @var [Hasher]
     */
    private $userPasswordHasher;
    
    /**
     * Constructor to use UserPassxordHAsher interface as Injection dependancy
     *
     * @param UserPasswordHasherInterface $userPasswordHasher
     */
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    /**
     * load function to push fake data in bdd. Here Reseller with default company name and all random properties are reated and pass to the manager.
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {
            $reseller = new Reseller();
            $reseller->setEmail("user@smartphoneapi" . $i . ".com");
            $reseller->setCompanyName("Operator" . $i);
            $reseller->setRoles(["ROLE_USER"]);
            $reseller->setUuid(Uuid::v6());
            $reseller->setPassword($this->userPasswordHasher->hashPassword($reseller, "Y60vrqdBq9!?"));
            $this->addReference('reseller_'.$i, $reseller);
            $manager->persist($reseller);
        }

        $manager->flush();

        
    }

}