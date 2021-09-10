<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameFormType;
use App\Repository\GameRepository;
use App\Service\DataFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GamesController extends AbstractController
{
    /**
     * @var GameRepository
     */
    private $gameRepository;

    /**
     * @var DataFactory
     */
    private $dataFactory;

    public function __construct(
        GameRepository $gameRepository,
        DataFactory $dataFactory
    ){
        $this->gameRepository = $gameRepository;
        $this->dataFactory = $dataFactory;
    }

    /**
     * @Route("/games", name="app_games")
     */
    public function index(): Response
    {
        $games = $this->gameRepository->findByIsDeleted(false);

        return $this->render('games.html.twig', [
            'games' => $games
        ]);
    }

    /**
     * @Route ("/createGame", name="app_createGame")
     */
    public function create(Request $request): Response
    {
        $game = new Game();
        $form = $this->createForm(GameFormType::class, $game);
        $form->handleRequest($request);

        $response = $this->dataFactory->makeGame($game, $form);

        if ($response) {
            $this->addFlash('success', $response);
            return $this->redirectToRoute('app_games');
        }

        return $this->render('game/createGame.html.twig', [
            'game_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/editGame/{id}", name="app_editGame")
     */
    public function edit(Request $request, int $id): Response
    {
        $game = $this->gameRepository->find($id);
        $form = $this->createForm(GameFormType::class, $game);
        $form->handleRequest($request);

        $response = $this->dataFactory->updateGame($game, $form);

        if ($response) {
            $this->addFlash('success', $response);
            return $this->redirectToRoute('app_games');
        }

        return $this->render('game/editGame.html.twig', [
            'game_form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/deleteGame/{id}", name="app_deleteGame")
     */
    public function delete(Game $game): Response
    {
        $response = $this->dataFactory->deleteGame($game);

        $this->addFlash("success", $response);

        return $this->redirectToRoute('app_games');
    }
}
