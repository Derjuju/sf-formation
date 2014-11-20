<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    
    public function testWhenRegistrationSucceed()
    {
        $client = static::createClient();
        $client->followRedirects(true);
        $client->request('GET', '/signup');
        $form = $client->getCrawler()->selectButton('Register')->form();
        
        $client->submit($form, [
            'player[username]' => 'toto',
            'player[email]' => 'toto@toto.fr',
            'player[password][first]' => 'test',
            'player[password][second]' => 'test',
        ]);
        
        //print_r($client->getResponse()->getContent());die;
        
        $this->assertEquals('Your account has been successfully created.', $client->getCrawler()->filter('.alert.alert-success')->text());
        
    }
    
    public function testLogin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');
    }

    public function testSignup()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/signup');
    }

    public function testLogout()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/logout');
    }

    public function testLogincheck()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/loginCheck');
    }

    public function testLastplayers()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/lastPlayers');
    }

}
