<?php

namespace App\Controller;

use App\Entity\Publisher;
use App\Form\PublisherFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class AddPublisherController extends AbstractController
{
    public function show(Environment $twig)
    {
        $publisher = new Publisher();

        $form = $this->createForm(PublisherFormType::class, $publisher);

        return new Response($twig->render('home.html.twig', [
            'publisher_form' => $form->createView()
        ]));
    }
}
