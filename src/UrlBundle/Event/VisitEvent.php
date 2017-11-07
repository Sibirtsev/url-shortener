<?php
namespace UrlBundle\Event;

use Symfony\Component\EventDispatcher\Event;

use UrlBundle\Entity\Url;

/**
 * Class VisitEvent
 *
 * @package UrlBundle\Event
 */
class VisitEvent extends Event
{
    const NAME = 'url.visit';

    /**
     * @var Url
     */
    protected $url;

    /**
     * @param Url $url
     */
    public function __construct(Url $url)
    {
        $this->url = $url;
    }

    /**
     * @return Url
     */
    public function getUrl() : Url
    {
        return $this->url;
    }
}
