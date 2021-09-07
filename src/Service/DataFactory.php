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

    public function makePublisherCreateForm(Publisher $publisher, FormInterface $form)
    {
        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($publisher);
            $this->entityManager->flush();

            return new Response("Publisher created: " . $publisher->getName());
        }
    }

    public function updatePublisherCreateForm(Publisher $publisher, FormInterface $form)
    {
        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($publisher);
            $this->entityManager->flush();

            return new Response("Publisher updated: " . $publisher->getName());
        }
    }
}
