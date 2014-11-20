<?php

namespace AppBundle\Tests\Game;

use AppBundle\Game\Game;
/**
 * Description of GameTest
 *
 * @author pinacolada
 */
class GameTest extends \PHPUnit_Framework_TestCase
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
    
    
    public function testWhenWordIsGuessed()
    {
    }
    
    public function testWhenLetterIsGuessed()
    {
        $game = new Game('symfony');
        $guessed = $game->tryLetter('y');
        
        $this->assertSame(Game::MAX_ATTEMPTS, $game->getRemainingAttempts());
        $this->assertEquals(['y'], $game->getTriedLetters());
        $this->assertEquals(['y'], $game->getFoundLetters());
        $this->assertTrue($guessed);
    }
    
    public function testWhenWordIsNotGuessed()
    {
        
    }
    
    public function testWhenLetterIsNotGuessed()
    {
        $game = new Game('symfony');
        $guessed = $game->tryLetter('a');
        
        $this->assertSame(Game::MAX_ATTEMPTS-1, $game->getRemainingAttempts());
        $this->assertEquals(['a'], $game->getTriedLetters());
        $this->assertEquals([], $game->getFoundLetters());
        $this->assertFalse($guessed);
    }
    
    public function testWhenGivenCharNotLetter()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $game = new Game('symfony');
        $guessed = $game->tryLetter('@');                
    }
}
