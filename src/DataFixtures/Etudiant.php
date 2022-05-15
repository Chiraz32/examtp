<?php

namespace App\DataFixtures;

use App\Entity\Section;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class Etudiant extends Fixture
{public function load(ObjectManager $manager): void
    {$faker=Factory::create();
        for($i=0;$i<30;$i++)
        {
            $etudiant =new \App\Entity\Etudiant() ;
            if ($i %2 ==0)
             {$section=new Section();
                 $manager->persist($section);
                 $etudiant->setSection($section);}


            $etudiant->setNom($faker->firstName);
            $etudiant->setPrenom($faker->lastName);
            $manager->persist($etudiant);
        }

        $manager->flush();
    }
}
