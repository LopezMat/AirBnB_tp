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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->encoder = $hasher;
    }

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
            ->setPassword($this->encoder->hashPassword($user, "toto"))
            ->setPrenom($faker->firstName);
        $manager->persist($user);

        $user2 = new User();
        $user2->setEmail('admin@admin.fr')
            ->setRoles(['ROLE_ADMIN'])
            ->setNom($faker->lastName)
            ->setIsActive(true)
            ->setPassword($this->encoder->hashPassword($user2, "admin"))
            ->setPrenom($faker->firstName);
        $manager->persist($user2);


        //création de mes types de logement
        $typesArray = [
            'Bord de mer', 'Campagne', 'Cuisine équipé', 'Piscine', 'Cabanes', 'Ville emblématiques',
            'Sur l\'eau', 'Lux', 'Chateau', 'Design', 'Maison troglodytes', 'Grange'
        ];
        //création de mes images
        $imgType = [
            'bord-de-mer.jpg', 'campagne.jpg', 'cuisine-equipe.jpg', 'piscine.jpg', 'Cabanes.jpg', 'ville-emblematique.jpg',
            'sur-leau.jpg', 'lux.jpg', 'chateau.jpg', 'design.jpg', 'maison-troglodytes.jpg', 'grange.jpg'

        ];

        for ($i = 0; $i < count($typesArray); $i++) {
            $type = new Type();
            $type->setLabel($typesArray[$i])
                ->setImagePath($imgType[$i]);
            $manager->persist($type);
            $this->addReference('type' . $i, $type);
        }


        //création de mes équipements
        $equipements = [
            'TV', 'Wi-Fi', 'Air conditioning', 'Heating', 'Kitchen', 'Washing machine',
            'Swimming pool', 'Gym', 'Parking', 'Balcony', 'Garden', 'Pet-friendly', 'Barbecue',
            'Salle de sport', 'Table de pingpong', 'Jeux video', 'Salle de bain', 'Golf', 'Sauna',
            'Climatisation', 'Cuisine equipe', 'Cuisine individuelle', 'Cuisine equipe',
        ];



        foreach ($equipements as $key => $equipment) {
            $equipement = new Equipement();
            $equipement->setLabel($equipment)
                ->setIsActive(true);
            $manager->persist($equipement);
            $this->addReference('equipement' . $key, $equipement);
        }

        //création de mes logements
        for ($j = 0; $j < 100; $j++) {
            $image = new Images();
            $image->setImagePath('telechargement.jpg');
            $image->setAlt('logement');
            $manager->persist($image);
            $logement = new Logement();
            $logement->setPrix($faker->numberBetween(100, 500))
                ->setImagePath('telechargement.jpg')
                ->setCouchage($faker->numberBetween(1, 5))
                ->setTaille($faker->numberBetween(30, 100))
                ->setDescription($faker->words(30, true))
                //->addEquipementId($this->getReference('equipement' . $faker->numberBetween(0, 9)))
                ->addTypeId($this->getReference('type' . $faker->numberBetween(0, 9)))
                ->setUserId($user2)
                ->setIsActive(true)
                ->setAdresse($faker->words(10, true))
                ->setCodePostal($faker->numberBetween(1000, 9999))
                ->setPays($faker->country)
                ->addImage($image)
                ->setVille($faker->words(3, true))
                ->setName($faker->words(3, true));
            $manager->persist($logement);

            //boucle de relation avec les equipements
            for ($k = 0; $k < rand(10, count($equipements) - 1); $k++) {
                $logement->addEquipementId($this->getReference('equipement' . rand(0, count($equipements) - 1)));
            }
        }
        $manager->flush();
    }
}
