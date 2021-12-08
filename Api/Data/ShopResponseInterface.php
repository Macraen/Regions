<?php

namespace CepdTech\Regions\Api\Data;

interface ShopResponseInterface
{
    public const URL = 'url';

    /**
     * @return string
     */
    public function getUrl();

    /**
     * @param string $url
     * @return void
     */
    public function setUrl($url);
}
