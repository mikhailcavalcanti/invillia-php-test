<?php

namespace App\DataFixtures;

use App\Entity\Person;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PersonFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $person1 = (new Person())->assign(['id' => 1, 'name' => 'Name Fixture 1', 'phones' => []], $manager);
        $person2 = (new Person())->assign(['id' => 2, 'name' => 'Name Fixture 2', 'phones' => []], $manager);
        $person3 = (new Person())->assign(['id' => 3, 'name' => 'Name Fixture 3', 'phones' => []], $manager);
        $manager->persist($person1);
        $manager->persist($person2);
        $manager->persist($person3);

        $manager->flush();
    }
}
