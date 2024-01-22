<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use Symfony\Component\Uid\Uuid;

class CustomerFixtures extends Fixture implements DependentFixtureInterface
{

    // MODIFY Fixtures to match Entity + OneFile By FixtureEntity.
    /**
     * load function takes Object Manager as a parameter to push fixtures in bdd. It will create random data according to logic implemented in it.
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $customer = new Customer();
            $customer->setFirstName("John".$i);
            $customer->setLastName("Doe".$i);
            $customer->setEmail("custome@smartphoneapi".$i.".com");
            // Set the start and end dates for the range.
            $start = strtotime('2023-01-01 00:00:00');
            $end = strtotime('2023-12-31 00:00:00');
            // Generate a random timestamp within the range.
            $randomTimestamp = mt_rand($start, $end);

            // Create a DateTime object from the random timestamp.
            $randomDate = new DateTimeImmutable();
            $customer->setFacturationAddress(mt_rand(1,90)." rue untel ".$i);
            $customer->setCreatedAt($randomDate->setTimestamp($randomTimestamp));
            $customer->setUuid(Uuid::v6());
            $customer->setReseller($this->getReference('reseller_'.mt_rand(0, 4)));
            $manager->persist($customer);
        }

        $manager->flush();

        
    }

    public function getDependencies()
    {
        return [
            ResellerFixtures::class,
        ];
    }
}
