<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Entity\Movie;
use App\Repository\ActorRepository;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    #[Route('/movies', name: 'app_movie')]
    public function index(ActorRepository $actorRepository, MovieRepository $movieRepository): Response
    {
        $actor1 = new Actor();
        $actor1->setName("KHOA");
        $actor2 = new Actor();
        $actor2->setName("KHOA 2");
        $actorRepository->save($actor1);
        $actorRepository->save($actor2);


        $movie = new Movie();
        $movie->setName('Movie 1');
        $movie->addActor($actor1);
        $movie->addActor($actor2);
        $movie->setReleaseYear(2020);
        $movieRepository->save($movie);
        return new Response("Success");
    }
}
