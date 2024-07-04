<?php

namespace App\Tests\Entity;

use App\Entity\CustomerOrder;
use PHPUnit\Framework\TestCase;

class CustomerOrderTest extends TestCase
{
    public function testGetAndSetCustomerName()
    {
        $customerOrder = new CustomerOrder();
        $customerOrder->setCustomerName('John Doe');
        $this->assertSame('John Doe', $customerOrder->getCustomerName());
    }

    public function testGetAndSetOrderDate()
    {
        $customerOrder = new CustomerOrder();
        $date = new \DateTime('2024-07-04');
        $customerOrder->setOrderDate($date);
        $this->assertSame($date, $customerOrder->getOrderDate());
    }

    public function testGetAndSetTotalAmount()
    {
        $customerOrder = new CustomerOrder();
        $customerOrder->setTotalAmount(99.99);
        $this->assertSame(99.99, $customerOrder->getTotalAmount());
    }

    public function testGetAndSetStatus()
    {
        $customerOrder = new CustomerOrder();
        $customerOrder->setStatus('Pending');
        $this->assertSame('Pending', $customerOrder->getStatus());
    }

    public function testGetAndSetPostalCode()
    {
        $customerOrder = new CustomerOrder();
        $customerOrder->setPostalCode('12345');
        $this->assertSame('12345', $customerOrder->getPostalCode());
    }

    public function testGetAndSetCountry()
    {
        $customerOrder = new CustomerOrder();
        $customerOrder->setCountry('France');
        $this->assertSame('France', $customerOrder->getCountry());
    }

    public function testGetAndSetAddress()
    {
        $customerOrder = new CustomerOrder();
        $customerOrder->setAddress('123 Main St');
        $this->assertSame('123 Main St', $customerOrder->getAddress());
    }

    public function testGetAndSetCity()
    {
        $customerOrder = new CustomerOrder();
        $customerOrder->setCity('Paris');
        $this->assertSame('Paris', $customerOrder->getCity());
    }
}
