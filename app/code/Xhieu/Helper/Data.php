<?php

declare(strict_types=1);

namespace Fgc\Xhieu\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * class Data
 */
class Data extends AbstractHelper
{


    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     *
     */
    const PATH_URL ='orderreport/config/change_url';
    /**
     *
     */
    const PATH_BEARER_TOKEN='orderreport/config/change_token';

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
     {
         $this->scopeConfig = $scopeConfig;
     }

    /**
     * @return array
     */
    public function getGeneralConfig()
    {
        $storeScope =  ScopeInterface::SCOPE_STORE;
        $valueUrl = $this->scopeConfig->getValue(self::PATH_URL, $storeScope);
        $valueBearerToken=$this->scopeConfig->getValue(self::PATH_BEARER_TOKEN, $storeScope);
        $configValues = [
            'url' => $valueUrl,
            'bearer_token' => $valueBearerToken
        ];
        return $configValues;
    }
}
