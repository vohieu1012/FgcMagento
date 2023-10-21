<?php

namespace Fgc\PageRender\Model\Api;

use Fgc\PageRender\Api\CustomInterface;
use Fgc\PageRender\Controller\Index\Index;

/**
 *
 */
class Custom  implements CustomInterface
{
    /**
     * @var Index
     */
    protected $collection;
    /**
     * @var \Magento\Framework\Webapi\Rest\Request
     */
    protected $request;

    /**
     * @param Index $collection
     * @param \Magento\Framework\Webapi\Rest\Request $request
     */
    protected $storeManager;
    public function __construct(Index $collection, \Magento\Framework\Webapi\Rest\Request $request,\Magento\Store\Model\StoreManagerInterface $storemanager)
    {
        $this->collection = $collection;
        $this->request=$request;
        $this->storeManager =  $storemanager;
    }

    /**
     * @inheritdoc
     */

    public function getProductInf()
    {
        try {
            $pageIndex=$this->request->getParam('page');
            $startIndex=($pageIndex-1)*12;
            $store = $this->storeManager->getStore();
            $productData = [];
            $productCollection=$this->collection->getCollection();
            foreach ($productCollection as $product) {
                $productImageUrl = $store->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'catalog/product' .$product->getImage();
                // Product data
                $productData[$product->getEntityId()] = [
                    'Name' => $product->getName(),
                    'Price' => $product->getPrice(),
                    'UrlProduct'=> $product->getProductUrl(),
                    'UrlImages' => $productImageUrl
                ];
            }
            $response = ['success' => true, 'message' => 'Success', 'data' => array_slice($productData,$startIndex,12)];
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => $e->getMessage(), 'data' => []];
        }
        $returnArray = json_encode($response);
        return $returnArray;
    }
}
