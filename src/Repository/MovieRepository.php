<?php

namespace App\Repository;

use App\Entity\Actor;
use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Movie>
 *
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    public function add(Movie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Movie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // many to many (manuel)
    public function findOneByIdJoinedToCategory(int $actorId): ?Movie
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT a, m
            FROM App\Entity\Movie a
            INNER JOIN a.actors m
            WHERE a.id = :id'
        )->setParameter('id', $actorId);

        return $query->getOneOrNullResult();
    }

    // for MoviesAPI
    public function transform(Movie $movie)
    {
        return [
            'id'    => (int) $movie->getId(),
            'title' => (string) $movie->getTitle(),
            'releaseYear' => (int) $movie->getReleaseYear(),
            'description' => (string) $movie->getDescription(),
            'imagePath' => (string) $movie->getImagePath(),
            'actors' => (array) $movie->getActors(),
        ];
    }

    public function transformAll()
    {
        $movies = $this->findAll();
        $moviesArray = [];

        foreach ($movies as $movie) {
            $moviesArray[] = $this->transform($movie);
        }

        return $moviesArray;
    }
}
