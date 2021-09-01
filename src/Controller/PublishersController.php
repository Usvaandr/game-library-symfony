<?php

namespace App\Controller;

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

        $publisher = new Publisher();
        $form = $this->createForm(PublisherFormType::class, $publisher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($publisher);
            $entityManager->flush();

            return new Response("Publisher created: " . $publisher->getName());
        }

        return $this->render('home.html.twig', [
            'publishers' => $publishers,
            'publisher_form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/viewPublisher", name="app_viewPublisher")
     */
    public function view(): Response
    {
        $games = $this->gameRepository->findAll();

        return $this->render('viewPublisher.html.twig', [
            'games' => $games,
        ]);
    }

    /**
     * @Route ("/editPublisher", name="app_editPublisher")
     */
    public function edit(): Response
    {
        return $this->render('editPublisher.html.twig', [

        ]);
    }
}
