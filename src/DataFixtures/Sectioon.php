<?php

namespace App\DataFixtures;

use App\Entity\Section;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class Sectioon extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker=Factory::create();
        for($i=0;$i<30;$i++)
        {

            $section=new Section();
            $section->setDesignation($faker->title);
            $manager->persist($section);




        }


        $manager->flush();
    }
}
