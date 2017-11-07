<?php

namespace UrlBundle\Service;

/**
 * Class UrlChecker
 *
 * @package UrlBundle\Service
 */
class UrlChecker
{
    /**
     * @param string $url
     * @return bool
     */
    public function check(string $url) : bool
    {
        return !empty($url) && $this->_checkFormat($url) && $this->_checkResponse($url);
    }

    /**
     * @param string $url
     * @return bool
     */
    private function _checkFormat($url) : bool
    {
        $regex = "/^((https?):\/\/)?(([^@]+)?(@?([^:]+):))?([^:\/$]+)(:?(\d+)($)?)?([^?$]+)?(\?([^#$]+))?(#([^$]+))?$/";
        return preg_match($regex, $url);
    }

    /**
     * @param string $url
     * @return bool
     */
    private function _checkResponse($url) : bool
    {
        $httpGetter = new HttpGetter($url);
        $requestMeta = $httpGetter->getRequestMeta();
        if ($requestMeta['http_code'] < 400) {
            return false;
        }
        return true;
    }
}
