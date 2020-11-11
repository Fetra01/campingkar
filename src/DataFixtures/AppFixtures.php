<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Image;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');

        for($i = 1; $i <= 30; $i++){
            $ad = new Ad();
            
            $type           = $faker->sentence();
            $coverImage     = $faker->imageUrl(1000,350);
            $introduction   = $faker->paragraph(2);
            $content        = '<p>' .join('</p><p>', $faker->paragraphs(5)). '</p>';

            $ad->setType($type)
               ->setCoverImage($coverImage)
               ->setIntroduction($introduction)
               ->setContent($content)
               ->setPrice(mt_rand(60,180))
               ->setPlaces(mt_rand(2,6))
               ->setBedding(mt_rand(2,6));

               for($j = 1; $j <= mt_rand(2,5); $j++) {
                $image = new Image();

                $image->setUrl($faker->imageUrl())
                      ->setCaption($faker->sentence())
                      ->setAd($ad);

                $manager->persist($image);
            }

            $manager->persist($ad);
        }

        $manager->flush();
    }
}
