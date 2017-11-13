<?php


namespace UrlBundle\Service;


use UrlBundle\Entity\Url;

class HttpGetter
{
    /**
     * @var string
     */
    private $_url;

    /**
     * @var array
     */
    private $_response;


    /**
     * @param Url $url
     * @return HttpGetter
     */
    public function setUrl(Url $url) : HttpGetter
    {
        $this->_url = $url->getUrl();
        return $this;
    }

    /**
     * @return array
     */
    public function getHtmlMeta() : array
    {
        $result = [];
        if (empty($this->_response)) {
            $this->_doResponse();
        }

        if (empty($this->_response['meta']['content_type'])
            || !preg_match('/html/', $this->_response['meta']['content_type'])) {
            return $result;
        }

        if (preg_match('/<title>(.*)<\/title>/', $this->_response['body'], $matches)) {
            $result['title'] = $matches[1];
        }

        if (preg_match('/<meta[^(name)]*name="description"[^>]*>/i', $this->_response['body'], $matches)) {
            if (preg_match('/content=["\']*([^"\']+)/i', $matches[0], $descMatches)) {
                $result['description'] = $descMatches[1];
            }
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getRequestMeta() : array
    {
        if (empty($this->_response)) {
            $this->_doResponse();
        }
        $metaKeys = [
            'http_code',
            'content_type',
            'total_time',
            'size_download',
            'primary_ip',

        ];
        return array_intersect_key($this->_response['meta'], array_flip($metaKeys));
    }

    private function _doResponse()
    {
        $ch = curl_init($this->_url);
        curl_setopt_array($ch, [
            CURLOPT_URL => $this->_url,
            CURLOPT_HEADER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => 'Symfony Url Shortener Link Checker 1.0'
        ]);

        $resultBody = curl_exec($ch);
        $resultMeta = curl_getinfo($ch);
        $this->_response = ['meta' => $resultMeta, 'body' => $resultBody];
    }
}
