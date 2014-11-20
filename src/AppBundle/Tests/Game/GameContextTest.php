<?php

namespace AppBundle\Tests\Game;

use AppBundle\Game\Game;
use AppBundle\Game\GameContext;
/**
 * Description of GameContextTest
 *
 * @author pinacolada
 */
class GameContextTest extends \PHPUnit_Framework_TestCase
{
    
    public static function setUpBeforeClass()
    {
        // executé avant le début de la classe de test        
    }
    public static function tearDownAfterClass()
    {
        // executé après la fin de la classe de test       
    }
    
    public function setUp()
    {
        // executé avant le début de chaque test        
    }
    public function tearDown()
    {
        // executé après la fin de chaque test       
    }
    
    
    public function testWhenGameIsNotStarted()
    {
        $session = $this->getMock('Symfony\Component\HttpFoundation\Session\Session');
        
        $session
                ->method('get')
                ->will(
                    $this->returnValue(null)
                    );
        
        $context = new GameContext($session);
        
        $this->assertFalse($context->loadGame());
    }
    
    public function testWhenGameIsStarted()
    {
        $expectedGame = new Game('symfony');
        
        $session = $this->getMock('Symfony\Component\HttpFoundation\Session\Session');
        
        $context = new GameContext($session);
        
        $data = [
            'word' => 'symfony',
            'attempts' => 0,
            'tried_letters' => [],
            'found_letters' => [],
        ];
        
        $session
                ->expects($this->once())
                ->method('get')
                ->will(
                    $this->returnValue($data)
                    );
                
        $this->assertEquals($expectedGame, $context->loadGame());
    }
    
    
    
    public function testWhenGameIsSaved()
    {
        $game = new Game('symfony');
        
        $session = $this->getMock('Symfony\Component\HttpFoundation\Session\Session');
        
        /*
        $session = $this->getMockBuilder('Symfony\Component\HttpFoundation\Session\Session')
                        ->setMethods(null)
                        ->getMock();
        */
        // pour DEBUG en TestUnitaire
        //\Symfony\Component\VarDumper\VarDumper::dump($session->get('hangman'));
        $context = new GameContext($session);
        
        $session
                ->expects($this->once())
                ->method('set')
                ->with(
                    $this->equalTo('hangman'),
                    $this->equalTo($game->getContext())
                    );
        
        $context->save($game);
    }
    
}
