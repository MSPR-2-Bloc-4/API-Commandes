<?php

namespace App\Tests\Entity;

use App\Entity\CustomerOrder;
use PHPUnit\Framework\TestCase;

class CustomerOrderTest extends TestCase
{
    public function testCustomerOrderEntity()
    {
        $order = new CustomerOrder();
        $order->setCustomerName('John Doe');
        $order->setOrderDate(new \DateTime('2023-07-01 12:00:00'));
        $order->setTotalAmount(150.50);
        $order->setStatus('pending');
        $order->setPostalCode('75001');
        $order->setCountry('France');
        $order->setAddress('123 Rue de Paris');
        $order->setCity('Paris');

        $this->assertEquals('John Doe', $order->getCustomerName());
        $this->assertEquals(new \DateTime('2023-07-01 12:00:00'), $order->getOrderDate());
        $this->assertEquals(150.50, $order->getTotalAmount());
        $this->assertEquals('pending', $order->getStatus());
        $this->assertEquals('75001', $order->getPostalCode());
        $this->assertEquals('France', $order->getCountry());
        $this->assertEquals('123 Rue de Paris', $order->getAddress());
        $this->assertEquals('Paris', $order->getCity());
    }
}
