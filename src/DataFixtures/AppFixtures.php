<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Image;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{
    
    /**
     * Variable pour encoder le mot de passe
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');


        //Pour gèrer les utilisateurs

        $users  = [];
        $genres = ['male', 'female'];

        for ($i=1; $i <=5 ; $i++) { 
            $user       = new User();

            $genre      = $faker->randomElement($genres);

            $picture    ='https://randomuser.me/api/portaits/';
            $pictureId  =$faker->numberBetween(1,99) . 'jpg';
            $picture   .= ($genre == 'male' ? 'men/' : 'women/') . $pictureId;

            $hash       = $this->encoder->encodePassword($user, 'password');
            
            $user       ->setFirstName($faker->firstName)
                        ->setLastName($faker->lastName)
                        ->setEmail($faker->email)
                        ->setIntroduction($faker->sentence())
                        ->setDescription('<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>')
                        ->setHash($hash)
                        ->setPicture($picture);

            $manager    ->persist($user);
            $users[]    = $user;
            
        }

        //Pour gèrer les annonces
        for($i = 1; $i <= 15; $i++){
            $ad = new Ad();
            
            $title          = $faker->sentence();
            $type           = $faker->sentence();
            $coverImage     = $faker->imageUrl(1000,350);
            $introduction   = $faker->paragraph(2);
            $content        = '<p>' .join('</p><p>', $faker->paragraphs(5)). '</p>';
            $user           = $users[mt_rand(0, count($users)-1)];

            $ad             ->setTitle($title)
                            ->setType($type)
                            ->setCoverImage($coverImage)
                            ->setIntroduction($introduction)
                            ->setContent($content)
                            ->setPrice(mt_rand(60,180))
                            ->setPlaces(mt_rand(2,6))
                            ->setBedding(mt_rand(2,6))
                            ->setAuthor($user);

               for($j = 1; $j <= mt_rand(2,5); $j++) {
                $image      = new Image();

                $image      ->setUrl($faker->imageUrl())
                            ->setCaption($faker->sentence())
                            ->setAd($ad);

                $manager    ->persist($image);
            }

            $manager->persist($ad);
        }

        $manager->flush();
    }
}
