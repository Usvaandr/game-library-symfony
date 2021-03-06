<?php

namespace App\Controller;

use App\Entity\Publisher;
use App\Enums\FlagType;
use App\Repository\GameRepository;
use App\Repository\PublisherRepository;
use App\Service\DataFactory;
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
     * @Route("/", name="app_homepage")
     */
    public function index(): Response
    {
        $publishers = $this->publisherRepository->findByIsDeleted(false);

        return $this->render('home.html.twig', [
            'publishers' => $publishers
        ]);
    }

    /**
     * @Route("/createPublisher", name="app_createPublisher")
     */
    public function create(Request $request): Response
    {
        $publisher = new Publisher();
        $form = $this->createForm(PublisherFormType::class, $publisher);
        $form->handleRequest($request);

        $response = $this->dataFactory->makePublisher($publisher, $form);

        if ($response) {
            $this->addFlash(FlagType::SUCCESS_TYPE, $response);
            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('publisher/createPublisher.html.twig', [
            'publisher_form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/viewPublisher/{id}", name="app_viewPublisher")
     */
    public function view(int $id): Response
    {
        $games = $this->gameRepository->findByPublisher($id);

        return $this->render('/publisher/viewPublisher.html.twig', [
            'games' => $games,
        ]);
    }

    /**
     * @Route ("/editPublisher/{id}", name="app_editPublisher")
     */
    public function edit(Request $request, int $id): Response
    {
        $publisher = $this->publisherRepository->find($id);
        $form = $this->createForm(PublisherFormType::class, $publisher);
        $form->handleRequest($request);

        $response = $this->dataFactory->updatePublisher($publisher, $form);

        if ($response) {
            $this->addFlash(FlagType::SUCCESS_TYPE, $response);
            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('publisher/editPublisher.html.twig', [
            'publisher_form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/deletePublisher/{id}", name="app_deletePublisher")
     */
    public function delete(Publisher $publisher): Response
    {
        if ($publisher->hasGames()) {
            $response = $this->dataFactory->deletePublisher($publisher);
            $type = FlagType::SUCCESS_TYPE;
        } else {
            $response = "Delete publisher games first.";
            $type = FlagType::WARNING_TYPE;
        }

        $this->addFlash($type, $response);

        return $this->redirectToRoute('app_homepage');
    }

    /**
     * @Route ("/deleteAll/{id}", name="app_deleteAll")
     */
    public function deleteAll($id): Response
    {
        $publisher = $this->publisherRepository->find($id);
        $response = $this->dataFactory->deleteAll($publisher);

        $this->addFlash(FlagType::SUCCESS_TYPE, $response);

        return $this->redirectToRoute('app_homepage');
    }
}
