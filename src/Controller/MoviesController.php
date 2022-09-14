<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieFormType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MoviesController extends AbstractController
{
    private $em;
    private $movieRepository;
    public function __construct(MovieRepository $movieRepository, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->movieRepository = $movieRepository;
    }

    // methode 1 display all movies
    #[Route('/movies', methods: ['GET'], name: 'app_movies')]
    public function index(): Response
    {
        // $repository = $this->em->getRepository(Movie::class);
        $movies = $this->movieRepository->findAll();
        //dd($movies);

        return $this->render('movies/index.html.twig', [
            'movies' => $movies                    //define a key 'movies' will be accessible in the template(view)
        ]);
    }

    // methode 2 create a new movie
    #[Route('/movies/create', name: 'app_create_movie')]
    public function create(Request $request): Response
    {
        $movie = new Movie();
        $form = $this->createForm(MovieFormType::class, $movie);

        $form->handleRequest($request);         // handle the request
        // validate the form
        if ($form->isSubmitted() && $form->isValid()) {
            $newMovie = $form->getData();

            $imagePath = $form->get('imagePath')->getData();

            if ($imagePath) {
                $newFileName = uniqid() . '.' . $imagePath->guessExtension();

                try {
                    $imagePath->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads',
                        $newFileName
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                    return new Response($e->getMessage());
                }

                $newMovie->setImagePath('/uploads/' . $newFileName);
            }

            $this->em->persist($newMovie);
            $this->em->flush();
            $this->addFlash('success', 'Movie created!');
            return $this->redirectToRoute('app_movies');        // redirect to the list of movies
        }

        return $this->render('movies/create.html.twig', [
            'form' => $form->createView()                 //define a key 'movies' will be accessible in the template(view)
        ]);
    }

    // methode 3 update a movie by id
    #[Route('/movies/edit/{id}', name: 'app_edit_movie')]
    public function edit($id, Request $request): Response
    {
        // dd($id);
        $movie = $this->movieRepository->find($id);
        $form = $this->createForm(MovieFormType::class, $movie);

        $form->handleRequest($request);         // handle the request
        $imagePath = $form->get('imagePath')->getData();

        if ($form->isSubmitted() && $form->isValid()) { // validate the form
            if ($imagePath) {
                // Handle image upload
                if ($movie->getImagePath() !== null) {
                    if (file_exists($this->getParameter('kernel.project_dir') . '/public' . $movie->getImagePath())) {
                        $this->getParameter('kernel.project_dir') . '/public' . $movie->getImagePath();

                        $newFileName = uniqid() . '.' . $imagePath->guessExtension();

                        try {
                            $imagePath->move(
                                $this->getParameter('kernel.project_dir') . '/public/uploads',
                                $newFileName
                            );
                        } catch (FileException $e) {
                            // ... handle exception if something happens during file upload
                            return new Response($e->getMessage());
                        }

                        $movie->setImagePath('/uploads/' . $newFileName);
                        $this->em->flush();

                        return $this->redirectToRoute('app_movies');
                    }
                }
            } else {
                //dd("OK");
                $movie->setTitle($form->get('title')->getData());
                $movie->setReleaseYear($form->get('releaseYear')->getData());
                $movie->setDescription($form->get('description')->getData());

                $this->em->flush();
                return $this->redirectToRoute('app_movies');        // redirect to the list of movies
            }
        }

        return $this->render('movies/edit.html.twig', [
            'movie' => $movie,
            'form' => $form->createView()                 //define a key 'movies' will be accessible in the template(view)
        ]);
    }

    // methode 4 delete a movie by id
    #[Route('/movies/delete/{id}', methods: ['GET', 'DELETE'], name: 'app_delete_movie')]
    public function delete($id): Response
    {
        $movie = $this->movieRepository->find($id);
        $this->em->remove($movie);
        $this->em->flush();
        $this->addFlash('success', 'Movie deleted!');
        return $this->redirectToRoute('app_movies');        // redirect to the list of movies
    }

    // methode 5 display one movie by ID
    #[Route('/movies/{id}', methods: ['GET'], name: 'app_movie_show')]
    public function showById($id): Response
    {
        $movies = $this->movieRepository->find($id);
        // dd($movies);

        return $this->render('movies/show.html.twig', [
            'movie' => $movies                  //define a key 'movies' will be accessible in the template(view)
        ]);
    }
    /* public function showById($id): Response
    {
        $movies = $this->movieRepository->findOneByIdJoinedToCategory($id);
        $actors = $movies->getActors();
        //dd($movies);

        return $this->render('movies/show.html.twig', [
            'movie' => $movies,                  //define a key 'movies' will be accessible in the template(view)
            'actor' => $actors
        ]);

        on template show.html.twig
       	<div class="basis-1/2">
			{% for a in actor %}
				<div class="">
					<br>
						<span class="bg-purple-100 text-purple-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-purple-200 dark:text-purple-900">
							{{ a.name }}
						</span>
				</div>
			{% endfor %}
		</div>
    }*/
}
