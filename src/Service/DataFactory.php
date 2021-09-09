<?php

namespace App\Service;

use App\Entity\Game;
use App\Entity\Publisher;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

class DataFactory
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function makePublisher(Publisher $publisher, FormInterface $form): ?string
    {
        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($publisher);
            $this->entityManager->flush();

            return "Publisher created: " . $publisher->getName();
        }

        return null;
    }

    public function updatePublisher(Publisher $publisher, FormInterface $form): ?string
    {
        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($publisher);
            $this->entityManager->flush();

            return "Publisher updated: " . $publisher->getName();
        }

        return null;
    }

    public function makeGame(Game $game, FormInterface $form): ?string
    {
        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($game);
            $this->entityManager->flush();

            return "Game created: " . $game->getName();
        }

        return null;
    }

    public function updateGame(Game $game, FormInterface $form): ?string
    {
        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($game);
            $this->entityManager->flush();

            return "Game updated: " . $game->getName();
        }

        return null;
    }

    public function deletePublisher(Publisher $publisher): string
    {
        $publisher->setIsDeleted(true);

        $this->entityManager->persist($publisher);
        $this->entityManager->flush();

        return "Game deleted.";
    }
}
