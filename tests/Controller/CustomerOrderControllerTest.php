<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\CustomerOrder;
use Doctrine\ORM\EntityManagerInterface;

class CustomerOrderIntegrationTest extends KernelTestCase
{
    private ?EntityManagerInterface $entityManager = null;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = static::getContainer()->get('doctrine')->getManager();
    }

    public function testCreateAndRetrieveCustomerOrder(): void
    {
        $customerOrder = new CustomerOrder();
        $customerOrder->setCustomerName('John Doe');
        $customerOrder->setOrderDate(new \DateTime('2024-07-04'));
        $customerOrder->setTotalAmount(99.99);
        $customerOrder->setStatus('Pending');
        $customerOrder->setPostalCode('12345');
        $customerOrder->setCountry('France');
        $customerOrder->setAddress('123 Main St');
        $customerOrder->setCity('Paris');

        $this->entityManager->persist($customerOrder);
        $this->entityManager->flush();

        $this->entityManager->clear();

        $retrievedOrder = $this->entityManager->getRepository(CustomerOrder::class)->find($customerOrder->getId());

        $this->assertInstanceOf(CustomerOrder::class, $retrievedOrder);
        $this->assertSame('John Doe', $retrievedOrder->getCustomerName());
        $this->assertEquals(new \DateTime('2024-07-04'), $retrievedOrder->getOrderDate());
        $this->assertSame(99.99, $retrievedOrder->getTotalAmount());
        $this->assertSame('Pending', $retrievedOrder->getStatus());
        $this->assertSame('12345', $retrievedOrder->getPostalCode());
        $this->assertSame('France', $retrievedOrder->getCountry());
        $this->assertSame('123 Main St', $retrievedOrder->getAddress());
        $this->assertSame('Paris', $retrievedOrder->getCity());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        if ($this->entityManager) {
            $this->entityManager->close();
            $this->entityManager = null;
        }
    }
}
