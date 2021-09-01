<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddGameController extends AbstractController
{
    /**
     * @Route("/addgame", name="app_addgame")
     */
    public function show(): Response
    {
        $game = new Game();

        $form = $this->createForm(GameFormType::class, $game);

        return new Response($this->render('form/addgame.html.twig', [
            'game_form' => $form->createView()
        ]));

    }
}
