<?php

namespace App\Controller;

use App\Entity\CustomerOrder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer; // Utiliser AbstractObjectNormalizer au lieu de AbstractNormalizer


class OrderController extends AbstractController
{
    #[Route('/orders', name: 'get_orders', methods: ['GET'])]
    public function getOrders(EntityManagerInterface $em): JsonResponse
    {
        $orders = $em->getRepository(CustomerOrder::class)->findAll();
        return $this->json($orders, 200, [], [AbstractObjectNormalizer::GROUPS => 'order:read']);
    }

    #[Route('/orders/{id}', name: 'get_order', methods: ['GET'])]
    public function getOrder(int $id, EntityManagerInterface $em): JsonResponse
    {
        $order = $em->getRepository(CustomerOrder::class)->find($id);
        if (!$order) {
            return $this->json(['message' => 'Order not found'], 404);
        }
        return $this->json($order, 200, [], [AbstractObjectNormalizer::GROUPS => 'order:read']);
    }

    #[Route('/orders', name: 'create_order', methods: ['POST'])]
    public function createOrder(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $order = new CustomerOrder();
        $order->setCustomerName($data['customerName']);
        $order->setOrderDate(new \DateTime($data['orderDate']));
        $order->setTotalAmount($data['totalAmount']);
        $order->setStatus($data['status']);
        $order->setPostalCode($data['postalCode']);
        $order->setCountry($data['country']);
        $order->setAddress($data['address']);
        $order->setCity($data['city']);

        $em->persist($order);
        $em->flush();

        return $this->json($order, 201, [], [AbstractObjectNormalizer::GROUPS => 'order:read']);
    }

    #[Route('/orders/{id}', name: 'update_order', methods: ['PUT', 'PATCH'])]
    public function updateOrder(int $id, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $order = $em->getRepository(CustomerOrder::class)->find($id);
        if (!$order) {
            return $this->json(['message' => 'Order not found'], 404);
        }

        $data = json_decode($request->getContent(), true);
        $order->setCustomerName($data['customerName'] ?? $order->getCustomerName());
        $order->setOrderDate(new \DateTime($data['orderDate'] ?? $order->getOrderDate()->format('Y-m-d H:i:s')));
        $order->setTotalAmount($data['totalAmount'] ?? $order->getTotalAmount());
        $order->setStatus($data['status'] ?? $order->getStatus());
        $order->setPostalCode($data['postalCode'] ?? $order->getPostalCode());
        $order->setCountry($data['country'] ?? $order->getCountry());
        $order->setAddress($data['address'] ?? $order->getAddress());
        $order->setCity($data['city'] ?? $order->getCity());

        $em->flush();

        return $this->json($order, 200, [], [AbstractObjectNormalizer::GROUPS => 'order:read']);
    }

    #[Route('/orders/{id}', name: 'delete_order', methods: ['DELETE'])]
    public function deleteOrder(int $id, EntityManagerInterface $em): JsonResponse
    {
        $order = $em->getRepository(CustomerOrder::class)->find($id);
        if (!$order) {
            return $this->json(['message' => 'Order not found'], 404);
        }

        $em->remove($order);
        $em->flush();

        return $this->json(['message' => 'Order deleted'], 200);
    }
}
