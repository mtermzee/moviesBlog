<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        /*First Movie*/
        $movie = new Movie();
        $movie->setTitle('The Shawshank Redemption');
        $movie->setReleaseYear(1994);
        $movie->setDescription('This is a description for this Movie');
        $movie->setImagePath('https://m.media-amazon.com/images/M/MV5BMDFkYTc0MGEtZmNhMC00ZDIzLWFmNTEtODM1ZmRlYWMwMWFmXkEyXkFqcGdeQXVyMTMxODk2OTU@._V1_.jpg');
        // add actors to movie
        $movie->addActor($this->getReference('actor-0'));     // add relationship between actors and movies
        $movie->addActor($this->getReference('actor-1'));     // add relationship between actors and movies
        $movie->addActor($this->getReference('actor-2'));     // add relationship between actors and movies

        $manager->persist($movie);  // persist the movie in the database

        /*Second Movie*/
        $movie2 = new Movie();
        $movie2->setTitle('The Godfather');
        $movie2->setReleaseYear(1972);
        $movie2->setDescription('This is a description for this Movie');
        $movie2->setImagePath('https://m.media-amazon.com/images/M/MV5BM2MyNjYxNmUtYTAwNi00MTYxLWJmNWYtYzZlODY3ZTk3OTFlXkEyXkFqcGdeQXVyNzkwMjQ5NzM@._V1_SY1000_CR0,0,666,1000_AL_.jpg');
        // add actors to movie
        $movie2->addActor($this->getReference('actor-3'));     // add relationship between actors and movies
        $movie2->addActor($this->getReference('actor-4'));     // add relationship between actors and movies

        $manager->persist($movie2);  // persist the movie in the database

        // flush the data in the database both of this queries at the same time
        $manager->flush();
    }
}
