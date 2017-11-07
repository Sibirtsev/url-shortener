<?php

namespace UrlBundle\Service;


class HashGenerator
{
    /**
     * @var string
     */
    private $_alphabet = '0123456789abcdefghijklmnopqrstuvwxyz-_ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * @return string
     */
    public function getHash()
    {
        $time = (new \DateTime())->getTimestamp();
        return $this->toHash($time);
    }

    /**
     * @param int $number
     * @return string
     */
    public function toHash(int $number) : string
    {
        $base = strlen($this->_alphabet);
        $hash = '';
        while ($number) {
            $index = $number % $base;
            $hash = $this->_alphabet[$index] . $hash;
            $number = floor($number / $base);
        }

        return $hash;
    }

    /**
     * @param string $hash
     * @return int
     */
    public function _fromHash(string $hash) : int
    {
        $base = strlen($this->_alphabet);
        $number = 0;

        $hashLen = strlen($hash);
        for ($i = 0, $power = $hashLen - 1; $i < $hashLen; ++$i, --$power) {
            $n = strpos($this->_alphabet, $hash[$i]);
            $number += $n * pow($base, $power);
        }

        return $number;
    }
}
