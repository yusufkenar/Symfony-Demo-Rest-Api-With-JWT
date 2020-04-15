<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends ApiController
{
    /**
     * @param  OrderRepository  $orderRepository
     * @return JsonResponse
     */
    public function getOrders(OrderRepository $orderRepository)
    {
        $data = $orderRepository->findAll();

        return $this->response($data);
    }

    /**
     * @param  Request  $request
     * @param  EntityManagerInterface  $entityManager
     * @return JsonResponse
     */
    public function newOrder(Request $request, EntityManagerInterface $entityManager)
    {
        try {
            $request = $this->transformJsonBody($request);

            if (!$request || !$request->get('orderCode') || !$request->get('productId') || !$request->get('quantity') || !$request->get('address')) {
                return $this->responseWithError('Please fill in these fields: orderCode, productId, quantity, address');
            }

            $order = new Order();
            $order->setOrderCode($request->get('orderCode'));
            $order->setProductId($request->get('productId'));
            $order->setQuantity($request->get('quantity'));
            $order->setAddress($request->get('address'));

            if ($request->get('shippingDate')) {
                $order->setShippingDate($request->get('shippingDate'));
            }

            $entityManager->persist($order);
            $entityManager->flush();

            $data = [
                'status' => 200,
                'success' => "Order was created successfully.",
            ];

            return $this->response($data);
        } catch (\Exception $e) {
            $data = [
                'status' => 422,
                'errors' => "Data invalid.",
            ];
            $this->setStatusCode(422);

            return $this->response($data);
        }
    }

    /**
     * @param  OrderRepository  $orderRepository
     * @param $orderCode
     * @return JsonResponse
     */
    public function getOrderDetail(OrderRepository $orderRepository, $orderCode)
    {
        $order = $orderRepository->findOneBy(['orderCode' => $orderCode]);

        if (!$order) {
            $data = [
                'status' => 404,
                'errors' => "Post not found",
            ];
            $this->setStatusCode(404);

            return $this->response($data);
        }

        return $this->response($order);
    }

    /**
     * @param  Request  $request
     * @param  EntityManagerInterface  $entityManager
     * @param  OrderRepository  $orderRepository
     * @param $orderCode
     * @return JsonResponse
     */
    public function updateOrder(
        Request $request,
        EntityManagerInterface $entityManager,
        OrderRepository $orderRepository,
        $orderCode
    ) {

        try {
            $order = $orderRepository->findOneBy(['orderCode' => $orderCode]);

            if (!$order) {
                $data = [
                    'status' => 404,
                    'errors' => "Order not found",
                ];
                $this->setStatusCode(404);

                return $this->response($data);
            }

            $request = $this->transformJsonBody($request);

            if (!$request->get('shippingDate')) {
                return $this->responseWithError('Please fill shippingDate.');
            }

            $order->setShippingDate(new \DateTime($request->get('shippingDate')));
            $entityManager->flush();

            $data = [
                'status' => 200,
                'errors' => "Order updated successfully.",
            ];

            return $this->response($data);

        } catch (\Exception $e) {
            dd($e);
            $data = [
                'status' => 422,
                'errors' => "Data invalid.",
            ];
            return $this->response($data);
        }

    }


    /**
     * @param  EntityManagerInterface  $entityManager
     * @param  OrderRepository  $orderRepository
     * @param $orderCode
     * @return JsonResponse
     */
    public function deleteOrder(EntityManagerInterface $entityManager, OrderRepository $orderRepository, $orderCode)
    {
        $order = $orderRepository->findOneBy(['orderCode' => $orderCode]);

        if (!$order) {
            $data = [
                'status' => 404,
                'errors' => "Order not found",
            ];
            $this->setStatusCode(404);

            return $this->response($data);
        }

        $entityManager->remove($order);
        $entityManager->flush();
        $data = [
            'status' => 200,
            'errors' => "Order deleted successfully",
        ];

        return $this->response($data);
    }
}
