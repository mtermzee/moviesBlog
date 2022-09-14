<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class MoviesApiController extends ApiController
{
    #[Route('/api/movies', name: 'app_movies_api', methods: ['GET'])]
    public function index(MovieRepository $movieRepository)
    {
        $movies = $movieRepository->transformAll();

        return $this->respond($movies);
    }

    #[Route('/api/movies/', name: 'app_movies_api_create', methods: ['POST'])]
    public function create(Request $request, MovieRepository $movieRepository, EntityManagerInterface $em)
    {
        $request = $this->transformJsonBody($request);

        /*if (!$request) {
            return $this->respondValidationError('Please provide a valid request!');
        }*/

        // validate the title
        if (!$request->get('title')) {
            return $this->respondValidationError('Please provide a title!');
        }

        // persist the new movie
        $movie = new Movie;
        $movie->setTitle($request->get('title'));
        $movie->setReleaseYear($request->get('releaseYear'));
        $movie->setDescription($request->get('description'));
        $movie->setImagePath($request->get('imagePath'));

        $em->persist($movie);
        $em->flush();

        return $this->respondCreated($movieRepository->transform($movie));
    }
}
