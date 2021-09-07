<?php

namespace App\Controller;

use App\Entity\Publisher;
use App\Repository\GameRepository;
use App\Repository\PublisherRepository;
use App\Service\DataFactory;
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
        $publishers = $this->publisherRepository->findAll();

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

        $response = $this->dataFactory->makePublisherCreateForm($publisher, $form);

        if ($response) {
            $this->addFlash('success', 'New Publisher Created!');
            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('publisher/createPublisher.html.twig', [
            'publisher_form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/viewPublisher", name="app_viewPublisher")
     */
    public function view(): Response
    {
        $games = $this->gameRepository->findAll();

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

        $response = $this->dataFactory->updatePublisherCreateForm($publisher, $form);

        if ($response) {
            $this->addFlash('success', 'Publisher Updated!');
            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('publisher/editPublisher.html.twig', [
            'publisher_form' => $form->createView()
        ]);
    }
}
