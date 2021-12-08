<?php

namespace CepdTech\Regions\Model;

use CepdTech\Regions\Api\CustomerDeliveryAddressInterface;

class CustomerDeliveryAddress extends \Magento\Framework\Model\AbstractExtensibleModel implements CustomerDeliveryAddressInterface
{
    /**
     * {@inheritdoc}
     */
    public function getStreet()
    {
        return $this->getData(self::STREET);
    }

    /**
     * {@inheritdoc}
     */
    public function getCity()
    {
        return $this->getData(self::CITY);
    }

    /**
     * {@inheritdoc}
     */
    public function getCountry()
    {
        return $this->getData(self::COUNTRY);
    }

    /**
     * {@inheritdoc}
     */
    public function getLatitude()
    {
        return $this->getData(self::LATITUDE);
    }

    /**
     * {@inheritdoc}
     */
    public function getLongitude()
    {
        return $this->getData(self::LONGITUDE);
    }

    /**
     * {@inheritdoc}
     */
    public function setStreet($street)
    {
        $this->setData(self::STREET, $street);
    }

    /**
     * {@inheritdoc}
     */
    public function setCity($city)
    {
        $this->setData(self::CITY, $city);
    }

    /**
     * {@inheritdoc}
     */
    public function setCountry($country)
    {
        $this->setData(self::COUNTRY, $country);
    }

    /**
     * {@inheritdoc}
     */
    public function setLatitude($latitude)
    {
        $this->setData(self::LATITUDE, $latitude);
    }

    /**
     * {@inheritdoc}
     */
    public function setLongitude($longitude)
    {
        $this->setData(self::LONGITUDE, $longitude);
    }
}
