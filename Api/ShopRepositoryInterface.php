<?php

namespace CepdTech\Regions\Api;

use Magento\Framework\Exception\InputException;

interface ShopRepositoryInterface
{
    /**
     * @param string $coordinates
     * @return mixed
     */
    public function getShopByCoordinates($coordinates);
}
