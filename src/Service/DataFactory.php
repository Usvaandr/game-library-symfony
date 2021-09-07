<?php

namespace App\Service;

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
        } else {
            return null;
        }
    }

    public function updatePublisher(Publisher $publisher, FormInterface $form): ?string
    {
        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($publisher);
            $this->entityManager->flush();

            return "Publisher updated: " . $publisher->getName();
        } else {
            return null;
        }
    }
}
