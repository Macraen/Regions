<?php

namespace CepdTech\Regions\Model;

use CepdTech\Regions\Api\Data\ShopResponseInterface;

class ShopResponse extends \Magento\Framework\Model\AbstractExtensibleModel implements ShopResponseInterface
{

    /**
     * {@inheritdoc}
     */
    public function getUrl()
    {
        return $this->getData(self::URL);
    }

    /**
     * {@inheritdoc}
     */
    public function setUrl($url)
    {
        $this->setData(self::URL, $url);
    }
}
