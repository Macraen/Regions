<?php
namespace CepdTech\Regions\Block;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Search
 */
class Search extends Template
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    const CONFIG_API_KEY = 'cepdtech_regions/general/api_key';

    const CONFIG_HOMEPAGE_TEXT = 'cepdtech_regions/general/homepage_text';

    const CONFIG_COUNTRY = 'cepdtech_regions/general/country';

    /**
     * @param Context $context
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param Session $customerSession
     * @param SerializerInterface $serializer
     */
    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        Session $customerSession,
        SerializerInterface $serializer
    ) {
        parent::__construct($context);
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->customerSession = $customerSession;
        $this->serializer = $serializer;
    }

    /**
     * @param $configPath
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getConfig($configPath) {
        return $this->scopeConfig->getValue(
            $configPath,
            ScopeInterface::SCOPE_STORE,
            $this->storeManager->getStore()->getId()
        );
    }

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getApiKey() {
        return $this->getConfig(self::CONFIG_API_KEY);
    }

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCountry() {
        return $this->getConfig(self::CONFIG_COUNTRY);
    }

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getHomepageText() {
        return $this->getConfig(self::CONFIG_HOMEPAGE_TEXT);
    }

    public function getCustomerAddress() {
         $address = $this->customerSession->getCustomerDeliveryAddress();

         return $address ? $address->street . ', ' . $address->city . ', ' . $address->country : '';
    }
}
