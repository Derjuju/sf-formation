<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/** @Route("/game")
 *  @Security("is_granted('ROLE_USER')")
 */
class GameController extends Controller
{
    

    /**
     * @Route("/reset", name="game_reset")
     * @Method("GET")
     */
    public function resetAction()
    {
        $wordList = $this->container->get('app.word_list');
        $context = $this->container->get('app.game_context');

        $length = $this->container->getParameter('word_length');
        $game = $context->newGame($wordList->getRandomWord($length));
        $context->save($game);

        return $this->redirect($this->generateUrl('game_play'));
    }

    /**
     * @Route("/", name="game_play")
     * @Method("GET")
     */
    public function playAction()
    {
        $context = $this->container->get('app.game_context');
        if (!$game = $context->loadGame()) {
            return $this->forward('AppBundle:Game:reset');
        }

        return $this->render('Game/play.html.twig', [ 'game' => $game ]);
    }

    /**
     * @Route("/win", name="game_win")
     * @Method("GET")
     */
    public function winAction()
    {
        $context = $this->container->get('app.game_context');
        if (!$game = $context->loadGame()) {
            throw $this->createNotFoundException('No existing Game context found.');
        }

        if (!$game->isWon()) {
            throw $this->createNotFoundException('Game is not yet won.');
        }

        $context->reset();

        return $this->render('Game/win.html.twig', [ 'word' => $game->getWord() ]);
    }

    /**
     * @Route("/fail", name="game_fail")
     * @Method("GET")
     */
    public function failAction()
    {
        $context = $this->container->get('app.game_context');
        if (!$game = $context->loadGame()) {
            throw $this->createNotFoundException('No existing Game context found.');
        }

        if (!$game->isHanged()) {
            throw $this->createNotFoundException('Game is not yet over.');
        }

        $context->reset();

        return $this->render('Game/fail.html.twig', [ 'word' => $game->getWord() ]);
    }

    /**
     * @Route(
     *   path="/letter/{letter}",
     *   name="game_play_letter",
     *   requirements={
     *       "letter"="[a-z]"
     *   }
     * )
     * @Method("GET")
     */
    public function playLetterAction($letter)
    {
        $context = $this->container->get('app.game_context');
        if (!$game = $context->loadGame()) {
            throw $this->createNotFoundException('No existing Game context found.');
        }

        $game->tryLetter($letter);
        $context->save($game);

        if (!$game->isOver()) {
            return $this->redirect($this->generateUrl('game_play'));
        }

        return $this->redirect($this->generateUrl($game->isWon() ? 'game_win' : 'game_fail'));
    }

    /**
     * @Route("/word", name="game_play_word")
     * @Method("POST")
     */
    public function playWordAction(Request $request)
    {
        $context = $this->container->get('app.game_context');
        if (!$game = $context->loadGame()) {
            throw $this->createNotFoundException('No existing Game context found.');
        }

        $game->tryWord($request->request->get('word'));
        $context->save($game);

        return $this->redirect($this->generateUrl($game->isWon() ? 'game_win' : 'game_fail'));
    }
}
