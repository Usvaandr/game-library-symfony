<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Publisher;
use App\Repository\GameRepository;
use App\Repository\PublisherRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PublisherFormType;

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
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $publishers = $this->publisherRepository->findAll();

        $games = $this->gameRepository->findAll();

        $publisher = new Publisher();
        $form = $this->createForm(PublisherFormType::class, $publisher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($publisher);
            $entityManager->flush();

            return new Response("Publisher created: " . $publisher->getName());
        }

        return $this->render('home.html.twig', [
            'title' => 'List of publishers!',
            'publishers' => $publishers,
            'games' => $games,
            'publisher_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/games", name="app_games")
     */
    public function show(): Response
    {
        $games = $this->gameRepository->findAll();

        return $this->render('games.html.twig', [
            'title' => 'List of publishers!',
            'games' => $games
        ]);
    }
}
