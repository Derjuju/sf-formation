<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;

use AppBundle\Entity\Player;
use AppBundle\Form\Type\PlayerType;
use AppBundle\Form\Type\LoginType;

class UserController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @Method("GET")
     */
    public function loginAction(Request $request)
    {
        $form = $this->createForm(new LoginType());
        $form->add('login','submit');
        
        if($exception = $request->getSession()->get('_security.last_error')){
            $request->getSession()->remove('_security.last_error');
        }
        
        return $this->render('User/login.html.twig', ['login_form' => $form->createView(), 'exception' => $exception]);
    }

    /**
     * @Route("/signup", name="signup")
     * @Method({ "GET", "POST" })
     */
    public function signupAction(Request $request)
    {
        $player = new Player();
        $form = $this->createForm(new PlayerType(), $player);
        $form->add('submit','submit', array('label'=>'Register'));
        
        if($form->handleRequest($request)->isValid()){
            // Insert to DB
            $encoder = $this->get('security.encoder_factory')->getEncoder($player);
            $secureRandom = $this->get('security.secure_random');
            $player->generatePassword($encoder, $secureRandom);
            
            $em = $this->get('doctrine')->getManager();            
            $em->persist($player);
            $em->flush();
            
            // Redirection avec Message de confirmation
            $this->addFlash('success', 'Your account has been successfully created.');
            return $this->redirectToRoute('game_play');
            
        }

        return $this->render('User/signup.html.twig', ['registration_form'=>$form->createView()]);
    }

    /**
     * @Route("/logout", name="logout")
     * @Method("GET")
     */
    public function logoutAction()
    {
        
    }

    /**
     * @Route("/login-check", name="login_check")
     * @Method("POST")
     */
    public function loginCheckAction()
    {
        
    }

    
    public function lastPlayersAction()
    {
        $playerRepository = $this->get('doctrine')->getManager()->getRepository('AppBundle:Player');
        
        return $this->render('User/players.html.twig', [
            'users' => $playerRepository->getLastRegisteredPlayer(),
        ]);
    }
    
    
    public function lastPlayersBisAction()
    {
        usleep(80000);

        $this->get('debug.stopwatch')->start('lent');
        for ($i = 0; $i<20000; $i++) {
            $users = [
                [ 'username' => 'foobar' ],
                [ 'username' => 'toto' ],
                [ 'username' => 'jwage' ],
                [ 'username' => 'hhamon' ],
                [ 'username' => 'fabpot' ],
            ];
        }
        $this->get('debug.stopwatch')->stop('lent');

        usleep(30000);

        return $this->render('User/players.html.twig', [
            'users' => $users,
        ]);
    }

}
