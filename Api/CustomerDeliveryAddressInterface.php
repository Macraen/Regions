<?php

namespace CepdTech\Regions\Api;

interface CustomerDeliveryAddressInterface
{
    public const ADDRESS = 'address';
    public const COORDINATES = 'coordinates';
    public const STREET = 'street';
    public const CITY = 'city';
    public const COUNTRY = 'country';
    public const LATITUDE = 'latitude';
    public const LONGITUDE = 'longitude';

    /**
     * @return string
     */
    public function getStreet();

    /**
     * @return string
     */
    public function getCity();

    /**
     * @return string
     */
    public function getCountry();

    /**
     * @return double
     */
    public function getLatitude();

    /**
     * @return double
     */
    public function getLongitude();

    /**
     * @param string $street
     * @return void
     */
    public function setStreet($street);

    /**
     * @param string $city
     * @return void
     */
    public function setCity($city);

    /**
     * @param string $country
     * @return void
     */
    public function setCountry($country);

    /**
     * @param double $latitude
     * @return void
     */
    public function setLatitude($latitude);

    /**
     * @param double $longitude
     * @return void
     */
    public function setLongitude($longitude);
}
