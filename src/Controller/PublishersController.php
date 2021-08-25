<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Publisher;
use App\Repository\GameRepository;
use App\Repository\PublisherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublishersController extends AbstractController
{
    /**
     * @var PublisherRepository
     */
    private $publisherRepository;

    /**
     * @var GameRepository
     */
    private $gameRepository;

    public function __construct(
        PublisherRepository $publisherRepository,
        GameRepository $gameRepository)
    {
        $this->publisherRepository = $publisherRepository;
        $this->gameRepository = $gameRepository;
    }

    /**
     * @Route("/", name="app_homepage")
     */
    public function index(): Response
    {
        $publishers = $this->getDoctrine()->getRepository(Publisher::class)->findAll();

        $games = $this->getDoctrine()->getRepository(Game::class)->findAll();

        return $this->render('home.html.twig', [
            'title' => 'List of publishers!',
            'publishers' => $publishers,
            'games' => $games
        ]);
    }

    /**
     * @Route("/games", name="app_games")
     */
    public function show(): Response
    {
        $games = $this->getDoctrine()->getRepository(Game::class)->findAll();

        return $this->render('games.html.twig', [
            'title' => 'List of publishers!',
            'games' => $games
        ]);
    }
}
