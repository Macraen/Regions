<?php

namespace CepdTech\Regions\Model;

use CepdTech\Regions\Api\ShopRepositoryInterface;

class ShopRepository implements ShopRepositoryInterface
{
    private \Magento\Customer\Model\Session\Proxy $customerSession;
    private \Magento\Store\Model\StoreManagerInterface $storeManager;
    private \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig;
    private \CepdTech\Regions\Api\Data\ShopResponseInterface $shopResponse;

    public function __construct(
        \Magento\Store\Model\StoreManagerInterface         $storeManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Customer\Model\Session\Proxy              $customerSession,
        \CepdTech\Regions\Api\Data\ShopResponseInterface   $shopResponse
    )
    {
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
        $this->customerSession = $customerSession;
        $this->shopResponse = $shopResponse;
    }

    /**
     * {@inheritdoc}
     */
    public function getShopByCoordinates(\CepdTech\Regions\Api\CustomerDeliveryAddressInterface $customerDeliveryAddress)
    {
        $eprufErrorMsg = null;
//        $eprufErrorMsg = 'Have not these pharmacies'; //TODO for test
        $eprufShopCode = 'pl_wdr_1_3';
//        $eprufShopCode = 'base'; //TODO for test

        try {
            $website = $this->storeManager->getWebsite($eprufShopCode);
            $websiteUrl = $this->scopeConfig->getValue('web/secure/base_url', 'website', $website->getCode());

            $this->customerSession->setAllowedWebsites($websiteUrl);
        } catch (\Exception $e) {
            throw new \Magento\Framework\Webapi\Exception(__($e->getMessage()), 400);
        }

        if ($eprufErrorMsg) {
            throw new \Magento\Framework\Webapi\Exception(__($eprufErrorMsg), 400);
        }

        $this->shopResponse->setUrl($websiteUrl);
        return $this->shopResponse;
    }
}
