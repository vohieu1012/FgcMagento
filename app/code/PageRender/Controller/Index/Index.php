<?php

namespace Fgc\PageRender\Controller\Index;

use Fgc\PageRender\Block\Collection;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /** @var PageFactory */
    protected $pageFactory;

    /** @var  \Magento\Catalog\Model\ResourceModel\Product\Collection */
    protected $productCollection;

    protected $collection;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory,
        Collection $collection
    )
    {
        $this->pageFactory = $pageFactory;
        $this->productCollection = $collectionFactory->create();
        $this->collection = $collection;
        parent::__construct($context);
    }

    public function execute()
    {
        $result = $this->pageFactory->create();
        $this->setCollection();
        return $result;
    }
    public function getCollection() {
        $this->setCollection();
        return $this->collection->getLoadedProductCollection();
    }
    public function  setCollection() {
        $collection = $this->productCollection;
        $collection->addFieldToSelect('*');
        $collection->addAttributeToFilter('status',\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);
        $collection->addAttributeToSort('entity_id', 'ASC');
        // Filter enable product and id increase
        return $this->collection->setProductCollection($collection);
    }
}
