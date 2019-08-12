<?php


namespace App\Tests\Controller;


use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QuoteControllerTest extends WebTestCase
{
    public function testGetAll() {
        $client = static::createClient(); //boot kernel + créer client BrowserKit
        $crawler = $client->request('GET', '/quotes');

        $this->assertResponseStatusCodeSame(200, $client->getResponse()->getStatusCode());

        $this->assertResponseHasHeader("CONTENT_TYPE","application/json");

    }

    public function testGetOne() {
        $client = static::createClient(); //boot kernel + créer client BrowserKit
        $crawler = $client->request('GET', '/quotes/1');

        $this->assertResponseStatusCodeSame(200, $client->getResponse()->getStatusCode());

        $this->assertResponseHasHeader("CONTENT_TYPE","application/json");
    }

    public function testCreateOne() {
        $client = static::createClient(); //boot kernel + créer client BrowserKit
        $crawler = $client->request('POST', '/quotes');

        $this->assertResponseStatusCodeSame(400, $client->getResponse()->getStatusCode());

        static::bootKernel(); // Instancie et boot le kernel Symfony
        $container = static::$kernel->getContainer();

        $client->request('POST', '/quotes', [], [], [], "{
            \"value\" : \"May the force be with you.\",
            \"owner_id\" : 1
        }");
        $this->assertResponseStatusCodeSame(201, $client->getResponse()->getStatusCode());
    }




}