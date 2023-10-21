<?php

namespace Fgc\Xhieu\Model\Api;

use Fgc\Xhieu\Api\OrderLatestInterface;
use Magento\Sales\Model\OrderFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Sales\Model\OrderRepository;

class CustomOrderInformation implements OrderLatestInterface
{
    protected $orderFactory;
    protected $orderRepository;
    protected $searchCriteriaBuilder;
    public function __construct(
        OrderFactory $orderFactory,
        OrderRepository $orderRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder

    ) {
        $this->orderFactory = $orderFactory;
        $this->orderRepository = $orderRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }
    public  function getLatestOrder() {
        $orderId = $this->getLastOrderIncrementId();
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('increment_id', $orderId)
            ->create();

        $orders = $this->orderRepository->getList($searchCriteria);

        foreach ($orders->getItems() as $order) {
            // Order information can be accessed here
            $orderEntityId = $orderId;
            $createdAtTimestamp = strtotime($order->getCreatedAt());
            $total = $order->getGrandTotal();
            $subtotal = $order->getSubtotal();
            $shippingAmount = $order->getShippingAmount();
            $discountAmount = $order->getDiscountAmount();
            $customerEmail = $order->getCustomerEmail();

            $items = [];
            foreach ($order->getAllVisibleItems() as $item) {
                $items[] = [
                    "sku" => $item->getSku(),
                    "name" => $item->getName(),
                    "price" => $item->getPrice(),
                    "qty" => $item->getQtyOrdered()
                ];
            }

            $orderData = [
                "order_id" => $orderEntityId,
                "create_at" => $createdAtTimestamp,
                "total" => $total,
                "subtotal" => $subtotal,
                "shipping_amount" => $shippingAmount,
                "discount_amount" => $discountAmount,
                "customer_email" => $customerEmail,
                "items" => $items
            ];

            // Now you have the order data in the desired format
        }
        // Encode the data as JSON
        $json = json_encode($orderData, JSON_PRETTY_PRINT);
        return $json;
    }
    public function getLastOrderIncrementId() {
        $lastOrder = $this->orderFactory->create()->getCollection()
            ->setOrder('entity_id', 'DESC')
            ->getFirstItem();

        if ($lastOrder->getId()) {
            $lastOrderIncrementId = $lastOrder->getIncrementId();
            return $lastOrderIncrementId;
        } else {
            return null; // No orders found
        }
    }
}
