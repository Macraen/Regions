<?php

namespace CepdTech\Regions\Controller\Index;

use CepdTech\Regions\Model\SaveCustomerAddress;
use Exception;
use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\Request\InvalidRequestException;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class GetShopByCoordinates extends \Magento\Framework\App\Action\Action implements CsrfAwareActionInterface
{
    protected $request, $_pageFactory, $customerSession, $response, $resultJsonFactory;
    private $logger;
    protected $addressDataFactory, $addressRepository, $shopResponse, $scopeConfig, $storeManager;


    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\App\Response\Http $response,
        \Magento\Framework\App\Action\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Customer\Model\Session\Proxy $customerSession,
        \CepdTech\Regions\Api\Data\ShopResponseInterface $shopResponse,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    )
    {
        $this->response = $response;
        $this->request = $request;
        $this->_pageFactory = $pageFactory;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
        $this->customerSession = $customerSession;
        $this->shopResponse = $shopResponse;
        $this->logger = $logger;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->resultRedirectFactory = $resultRedirectFactory;

        return parent::__construct($context);
    }

    public function getPostParams()
    {
        return json_decode(file_get_contents("php://input"));
    }

    public function execute()
    {
        $customerDeliveryAddress = $this->getPostParams();

        $eprufErrorMsg = null;
        //$eprufErrorMsg = 'Have not these pharmacies'; //TODO for test
        $eprufShopCode = 'pl_wdr_1_3';
        //$eprufShopCode = 'base'; //TODO for test

        try {
            $website = $this->storeManager->getWebsite($eprufShopCode);
            $websiteUrl = $this->scopeConfig->getValue('web/secure/base_url', 'website', $website->getCode());

            $this->customerSession->setAllowedWebsites($websiteUrl);
            $this->customerSession->setCustomerDeliveryAddress($customerDeliveryAddress);
        } catch (\Exception $e) {
            $result = array('error' => $e->getMessage());
        }

        if ($eprufErrorMsg) {
            $result = array('error' => $eprufErrorMsg);
        }

        if (!$result) {
            $result = array('url' => $websiteUrl);
        }
        $resultJson = $this->resultJsonFactory->create();

        return $resultJson->setData($result);
    }

    public function createCsrfValidationException(RequestInterface $request): ?InvalidRequestException
    {
        return null;
    }

    public function validateForCsrf(RequestInterface $request): ?bool
    {
        return true;
    }
}
