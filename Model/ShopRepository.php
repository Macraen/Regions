<?php

namespace CepdTech\Regions\Model;

use CepdTech\Regions\Api\ShopRepositoryInterface;
use Magento\Store\Model\StoresConfig;

class ShopRepository implements ShopRepositoryInterface
{
    private \Magento\Customer\Model\Session\Proxy $customerSession;
    private \Magento\Store\Model\StoreManagerInterface $storeManager;
    private \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig;
    private \Magento\Framework\Serialize\Serializer\Json $json;

    public function __construct(
        \Magento\Store\Model\StoreManagerInterface         $storeManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Customer\Model\Session\Proxy              $customerSession,
        \Magento\Framework\Serialize\Serializer\Json       $json
    )
    {
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
        $this->customerSession = $customerSession;
        $this->json = $json;
    }

    /**
     * @param $coordinates
     * @return array|bool|string
     */
    public function getShopByCoordinates($coordinates)
    {
        $eprufErrorMsg = null;
//        $eprufErrorMsg = 'Have not these pharmacies';

        $eprufShopCode = 'pl_wdr_1_3';

        $websiteUrl = null;
//        $websiteUrl = 'eskulap.pl_wdr_1_3';
        try {
//            $website = $this->storeManager->getWebsite($eprufShopCode);
//            $websiteUrl = $this->scopeConfig->getValue('web/secure/base_url', 'website', $website->getCode());
//
//            $this->customerSession->setAllowedWebsites($websiteUrl);
        } catch (\Exception $e) {
            throw new \Magento\Framework\Webapi\Exception(__($e->getMessage()), 400);
        }

        if ($eprufErrorMsg) {
            throw new \Magento\Framework\Webapi\Exception(__($eprufErrorMsg), 400);
        }

        return $this->json->serialize(['url' => $websiteUrl]);
    }
}
