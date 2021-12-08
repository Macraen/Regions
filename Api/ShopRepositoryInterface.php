<?php

namespace CepdTech\Regions\Api;

use Magento\Framework\Exception\InputException;

interface ShopRepositoryInterface
{
    /**
     * @param \CepdTech\Regions\Api\CustomerDeliveryAddressInterface $customerDeliveryAddress
     * @return \CepdTech\Regions\Api\Data\ShopResponseInterface
     */
    public function getShopByCoordinates(\CepdTech\Regions\Api\CustomerDeliveryAddressInterface $customerDeliveryAddress);
}
