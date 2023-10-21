<?php

namespace Fgc\Xhieu\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer as EventObserver;

/**
 * Xhieu module observer
 */
class OrderObserver implements ObserverInterface
{

    public function execute(EventObserver $observer)
    {
        $order = $observer->getEvent()->getData('order');
        $entityIdString = strval($order->getEntityId()); // Convert the order entity ID to a string
        $fileName = "order_" . $entityIdString . ".json"; // Create the filename

        // Create an array to hold the order information
        $data = [
            "order_id" => $order->getIncrementId(), // Order ID
            "created_at" => strtotime($order->getCreatedAt()), // Timestamp when the order was created
            "total" => $order->getGrandTotal(), // Order Grand Total
            "subtotal" => $order->getSubtotal(), // Subtotal
            "shipping_amount" => $order->getShippingAmount(), // Shipping Amount
            "discount_amount" => $order->getDiscountAmount(), // Discount Amount
            "customer_email" => $order->getCustomerEmail(), // Customer Email
            "items" => [] // Initialize an array for order items
        ];

        // Get order items
        foreach ($order->getAllVisibleItems() as $item) {
            // Add each item's information to the "items" array
            $data["items"][] = [
                "sku" => $item->getSku(), // SKU of the item
                "name" => $item->getName(), // Name of the item
                "price" => $item->getPrice(), // Price of the item
                "qty" => $item->getQtyOrdered() // Quantity of the item
            ];
        }

        // Encode the data as JSON
        $json = json_encode($data, JSON_PRETTY_PRINT);

        // Save the JSON data to the file
        file_put_contents($fileName, $json);
    }

}
