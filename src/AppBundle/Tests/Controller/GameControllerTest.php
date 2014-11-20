<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GameControllerTest extends WebTestCase
{
    public function testReset()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/reset');
    }

    public function testPlay()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/play');
    }

    public function testWin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/win');
    }

    public function testFail()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/fail');
    }

    public function testPlayletter()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/playLetter');
    }

    public function testPlayword()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/playWord');
    }
}
