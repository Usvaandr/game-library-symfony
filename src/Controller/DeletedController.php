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

class DeletedController extends AbstractController
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
    public function restorePublisher(Publisher $publisher)
    {
        $response = $this->dataFactory->restorePublisher($publisher);

        $this->addFlash(FlagType::SUCCESS_TYPE, $response);

        return $this->redirectToRoute('app_deleted');
    }

    /**
     * @Route("/deleted/restoreGame/{id}", name="app_restoreGame")
     */
    public function restoreGame(Game $game)
    {
        $response = $this->dataFactory->restoreGame($game);

        $this->addFlash(FlagType::SUCCESS_TYPE, $response);

        return $this->redirectToRoute('app_deleted');
    }
}
