<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ActorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $actor = new Actor();
        $actor->setName('Leonardo DiCaprio');
        $manager->persist($actor);

        $actor1 = new Actor();
        $actor1->setName('Robert De Niro');
        $manager->persist($actor1);

        $actor2 = new Actor();
        $actor2->setName('Al Pacino');
        $manager->persist($actor2);

        $actor3 = new Actor();
        $actor3->setName('Jack Nicholson');
        $manager->persist($actor3);

        $actor4 = new Actor();
        $actor4->setName('Tom Hanks');
        $manager->persist($actor4);

        $manager->flush();

        // add relationship between actors and movies
        $this->addReference('actor-0', $actor);
        $this->addReference('actor-1', $actor1);
        $this->addReference('actor-2', $actor2);
        $this->addReference('actor-3', $actor3);
        $this->addReference('actor-4', $actor4);
    }
}
