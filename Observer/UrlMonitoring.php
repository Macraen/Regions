<?php

namespace CepdTech\Regions\Observer;


use Magento\Customer\Api\AccountManagementInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Store\Model\ScopeInterface;

class UrlMonitoring implements ObserverInterface
{

    const CONFIG_ERROR_TEXT = 'cepdtech_regions/general/error_text';

    protected $logger, $managmentInterface, $customerSession, $redirectFactory, $responseFactory, $url, $eprufApi;
    private $storeManager;
    private $scopeConfig;
    public $messageManager;

    public function __construct (\Psr\Log\LoggerInterface $logger,
                                 \Magento\Customer\Model\Session $customerSession,
                                 AccountManagementInterface $managmentInterface,
                                 RedirectFactory $redirectFactory,
                                 \Magento\Store\Model\StoreManagerInterface         $storeManager,
                                 \Magento\Framework\App\ResponseFactory $responseFactory,
                                 \Magento\Framework\UrlInterface $url,
                                 \Magento\Framework\Message\ManagerInterface $messageManager,
                                 \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig){
        $this->logger = $logger;
        $this->customerSession = $customerSession;
        $this->managmentInterface = $managmentInterface;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
        $this->redirectFactory = $redirectFactory;
        $this->responseFactory = $responseFactory;
        $this->messageManager = $messageManager;
        $this->url = $url;
    }

    public function getConfig($configPath) {
        return $this->scopeConfig->getValue(
            $configPath,
            ScopeInterface::SCOPE_STORE,
            $this->storeManager->getStore()->getId()
        );
    }

    public function execute(Observer $observer)
    {
        $this->logger->info('Event Triggered');
        $url = \Magento\Framework\App\ObjectManager::getInstance()
            ->get('Magento\Framework\UrlInterface');
        $allowUrl = $this->customerSession->getAllowedWebsites();
//        $currWeb = $url->getCurrentUrl();
//        $baseUrl = $url->getBaseUrl();
        $baseUrl = $this->storeManager->getStore()->getBaseUrl() ;
        $website = $this->storeManager->getWebsite('base');
        $mainUrl = $this->scopeConfig->getValue('web/secure/base_url', 'website', $website->getCode());
        if ($baseUrl != $mainUrl){
            if ($mainUrl != $allowUrl || $baseUrl != $allowUrl) {
                $this->responseFactory->create()->setRedirect($mainUrl)->sendResponse();
                $this->messageManager->addErrorMessage(__($this->getConfig(self::CONFIG_ERROR_TEXT)));
                return $this;
            }
        }
        return true;
    }
}
