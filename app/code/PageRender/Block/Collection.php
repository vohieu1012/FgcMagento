<?php
namespace Fgc\PageRender\Block;
use Magento\Catalog\Block\Product\ListProduct;
use Magento\Catalog\Model\ResourceModel\Collection\AbstractCollection;
class Collection extends ListProduct{
    public function setProductCollection(AbstractCollection $collection)
    {
        $this->_productCollection = $collection;
    }

    public function getLoadedProductCollection()
    {
        return $this->_productCollection;
    }

}
