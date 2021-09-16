<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Publisher;
use App\Enums\FlagType;
use App\Repository\GameRepository;
use App\Repository\PublisherRepository;
use App\Service\DataFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeletePanelController extends AbstractController
{
    /**
     * @var PublisherRepository
     */
    private $publisherRepository;

    /**
     * @var GameRepository
     */
    private $gameRepository;

    /**
     * @var DataFactory
     */
    private $dataFactory;

    public function __construct(
        PublisherRepository $publisherRepository,
        GameRepository $gameRepository,
        DataFactory $dataFactory
    ) {
        $this->publisherRepository = $publisherRepository;
        $this->gameRepository = $gameRepository;
        $this->dataFactory = $dataFactory;
    }

    /**
     * @Route("/deleted", name="app_deleted")
     */
    public function view(): Response
    {
        $publishers = $this->publisherRepository->findByIsDeleted(true);
        $games = $this->gameRepository->findByIsDeleted(true);

        return $this->render('deleted.html.twig', [
            'publishers' => $publishers,
            'games' => $games
        ]);
    }

    /**
     * @Route("/deleted/restorePublisher/{id}", name="app_restorePublisher")
     */
    public function restorePublisher(Publisher $publisher): Response
    {
        $check = $this->publisherRepository->findOneBy(array(
            'name' => $publisher->getName(),
            'isDeleted' => false
        ));

        if (!$check) {
            $response = $this->dataFactory->restorePublisher($publisher);
            $type = FlagType::SUCCESS_TYPE;
        } else {
            $response = "Publisher with this name already exists.";
            $type = FlagType::WARNING_TYPE;
        }

        $this->addFlash($type, $response);

        return $this->redirectToRoute('app_deleted');
    }

    /**
     * @Route("/deleted/restoreGame/{id}", name="app_restoreGame")
     */
    public function restoreGame(Game $game): Response
    {
        $check = $this->gameRepository->findOneBy(array(
            'name' => $game->getName(),
            'isDeleted' => false
        ));

        if (!$check) {
            $response = $this->dataFactory->restoreGame($game);
            $type = FlagType::SUCCESS_TYPE;
        } else {
            $response = "Game with this name already exists.";
            $type = FlagType::WARNING_TYPE;
        }

        $this->addFlash($type, $response);

        return $this->redirectToRoute('app_deleted');
    }
}
