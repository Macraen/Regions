<?php
namespace CepdTech\Regions\CustomerData;
use Magento\Customer\CustomerData\SectionSourceInterface;

class CustomSection implements SectionSourceInterface
{
    public $customerSession;

    public function __construct (\Magento\Customer\Model\Session\Proxy $customerSession)
    {
        $this->customerSession = $customerSession;
    }

    public function getSectionData()
    {
        $customerSession = json_decode(json_encode($this->customerSession->getCustomerDeliveryAddress()), true);
        return $customerSession ? $customerSession : array( 'error' => 'no address' ) ;
    }
}
