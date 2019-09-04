<?php


namespace Tests\AppBundle\Controller;


use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
{
    function testListReturnUsers(){
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'Page1',
            'PHP_AUTH_PW'   => '1234',
        ]);
        $responseApiService = [];
        $crawler = $client->request('GET', '/api/users');
        $apiServiceMock = $this->getMockBuilder('AppBundle\Services\ApiService')
            ->disableOriginalConstructor()
            ->getMock();
        $apiServiceMock->expects($this->any())
            ->method('list')
            ->willReturn($responseApiService);
        $response = $client->getResponse();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    function testGetReturnUser(){
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'Page1',
            'PHP_AUTH_PW'   => '1234',
        ]);
        $responseApiService = new User();
        $crawler = $client->request('GET', '/api/user/1');
        $apiServiceMock = $this->getMockBuilder('AppBundle\Services\ApiService')
            ->disableOriginalConstructor()
            ->getMock();
        $apiServiceMock->expects($this->any())
            ->method('get')
            ->willReturn($responseApiService);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    function testCreateReturnOk(){
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'Admin',
            'PHP_AUTH_PW'   => '1234',
        ]);
        $responseApiService = [];
        $postData = [];

        $crawler = $client->request(
            'POST',
            '/api/new',
            $postData,
            array(),
            array('CONTENT_TYPE' => 'application/json')
        );
        $apiServiceMock = $this->getMockBuilder('AppBundle\Services\ApiService')
            ->disableOriginalConstructor()
            ->getMock();
        $apiServiceMock->expects($this->any())
            ->method('create')
            ->willReturn($responseApiService);
        $response = $client->getResponse();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}