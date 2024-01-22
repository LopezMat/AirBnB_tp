<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Type;
use App\Entity\User;
use App\Entity\Images;
use App\Entity\Logement;
use App\Entity\Equipement;
use App\Entity\Reservation;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');


        //création de mes users

        $user = new User();
        $user->setEmail('toto@toto.fr')
            ->setRoles(['ROLE_USER'])
            ->setNom($faker->lastName)
            ->setIsActive(true)
            ->setPassword($faker->password)
            ->setPrenom($faker->firstName);
        $manager->persist($user);

        $user2 = new User();
        $user2->setEmail('admin@admin.fr')
            ->setRoles(['ROLE_ADMIN'])
            ->setNom($faker->lastName)
            ->setIsActive(true)
            ->setPassword($faker->password)
            ->setPrenom($faker->firstName);
        $manager->persist($user2);


        //création de mes types de logement
        $types = [
            'Appartement', 'Maison', 'Villa', 'Bungalow', 'Loft', 'Chalet',
            'Duplex', 'Studio', 'Cave', 'Camping', 'Camping-car', 'Penthouse'
        ];

        foreach ($types as $key => $typ) {
            $type = new Type();
            $type->setLabel($typ);
            $manager->persist($type);
            $this->addReference('type' . $key, $type);
        }

        //création de mes équipements
        $equipements = [
            'TV', 'Wi-Fi', 'Air conditioning', 'Heating', 'Kitchen', 'Washing machine',
            'Swimming pool', 'Gym', 'Parking', 'Balcony', 'Garden', 'Pet-friendly'
        ];

        foreach ($equipements as $key => $equipment) {
            $equipement = new Equipement();
            $equipement->setLabel($equipment)
                ->setIsActive(true);
            $manager->persist($equipement);
            $this->addReference('equipement' . $key, $equipement);
        }

        //création de mes logements
        for ($i = 0; $i < 10; $i++) {
            $logement = new Logement();
            $logement->setPrix($faker->numberBetween(100, 500))
                ->setCouchage($faker->numberBetween(1, 5))
                ->setTaille($faker->numberBetween(30, 100))
                ->setDescription($faker->words(30, true))
                ->addEquipementId($this->getReference('equipement' . $faker->numberBetween(0, 9)))
                ->addTypeId($this->getReference('type' . $faker->numberBetween(0, 9)))
                ->setUserId($user2)
                ->setIsActive(true)
                ->setAdresse($faker->words(10, true))
                ->setCodePostal($faker->numberBetween(1000, 9999))
                ->setVille($faker->words(3, true));
            $manager->persist($logement);
        }

        //création de mes images
        for ($i = 0; $i < 10; $i++) {
            $images = new Images();
            $images->setImagePath('telechargement.jpg')
                ->setLogementId($logement)
                ->setAlt($faker->words(10, true));
            $manager->persist($images);
        }

        $manager->flush();
    }
}
