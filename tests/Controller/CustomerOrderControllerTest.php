<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\CustomerOrder;
use Doctrine\ORM\EntityManagerInterface;

class CustomerOrderControllerTest extends WebTestCase
{
    private $client;
    private $entityManager;
    private $testOrderId;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();

        $this->entityManager->createQuery('DELETE FROM App\Entity\CustomerOrder')->execute();

        $order = new CustomerOrder();
        $order->setCustomerName('Test User');
        $order->setOrderDate(new \DateTime('2023-07-01 12:00:00'));
        $order->setTotalAmount(150.50);
        $order->setStatus('pending');
        $order->setPostalCode('75001');
        $order->setCountry('France');
        $order->setAddress('123 Rue de Paris');
        $order->setCity('Paris');

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        $this->testOrderId = $order->getId();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }

    public function testCreateOrder()
    {
        $this->client->request(
            'POST',
            '/orders',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'customerName' => 'Jane Doe',
                'orderDate' => '2023-07-02 14:00:00',
                'totalAmount' => 175.00,
                'status' => 'completed',
                'postalCode' => '75002',
                'country' => 'France',
                'address' => '124 Rue de Paris',
                'city' => 'Paris'
            ])
        );

        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
    }

    public function testGetOrders()
    {
        $this->client->request('GET', '/orders');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testGetOrder()
    {
        $this->client->request('GET', '/orders/' . $this->testOrderId);

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testUpdateOrder()
    {
        $this->client->request(
            'PUT',
            '/orders/' . $this->testOrderId,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'customerName' => 'John Doe Updated',
                'orderDate' => '2023-07-03 15:00:00',
                'totalAmount' => 200.00,
                'status' => 'shipped',
                'postalCode' => '75003',
                'country' => 'France',
                'address' => '125 Rue de Paris',
                'city' => 'Paris'
            ])
        );

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testDeleteOrder()
    {
        $this->client->request('DELETE', '/orders/' . $this->testOrderId);

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }
}
