<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    /** @test */
    public function it_returns_the_categories()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/categories');

        die($client->getResponse()->getContent());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
