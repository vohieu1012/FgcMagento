<?php
namespace Fgc\Xhieu\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\HTTP\Client\Curl;
use  Fgc\Xhieu\Helper\Data as DataHelper;

/**
 * Xhieu module observer
 */
class OrderCurl implements ObserverInterface
{
    /**
     * @var Curl
     */
    protected $curl;
    /**
     * @var DataHelper
     */
    protected $dataHelper;

    /**
     * @param Curl $curl
     * @param DataHelper $dataHelper
     */
    public function __construct(
        Curl       $curl,
        DataHelper $dataHelper
    )
    {
        $this->curl = $curl;
        $this->dataHelper = $dataHelper;
    }

    /**
     * @param EventObserver $observer
     * @return void
     */
    public function execute(EventObserver $observer)
    {

        $order = $observer->getEvent()->getData('order');
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
        $dataConfig=$this->dataHelper->getGeneralConfig();
        // Define the URL where you want to send the request
        $url =$dataConfig["url"] ;
        $token=$dataConfig["bearer_token"];

        // Set the headers, including the Authorization header with Bearer token
        $headers = [
            "Authorization: $token",
            "Content-Type: application/json"
        ];
        // Set cURL options
        $this->curl->setOption(CURLOPT_HTTPHEADER, $headers);
        $this->curl->post($url, json_encode($data));

        if ($this->curl->getStatus() != 200) {
            // Handle the error here
            $errorMessage = $this->curl->getError();
            // Log or handle the error message as needed
        } else {
            // Get the response content
            $response = $this->curl->getBody();
            // You can now work with the response data
            // For example, you can decode it from JSON if the response is in JSON format
            $responseData = json_decode($response, true);
            dd($responseData);
            return $responseData;
        }
    }
}
