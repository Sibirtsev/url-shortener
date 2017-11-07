<?php
namespace UrlBundle\EventListener;


use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;

use UrlBundle\Entity\Url;
use UrlBundle\Service\HashGenerator;

/**
 * Class ShortUrlGenerator
 *
 * @package UrlBundle\EventListener
 */
class ShortUrlGenerator implements EventSubscriber
{
    /**
     * @var HashGenerator
     */
    private $_hashGenerator;

    /**
     * @param HashGenerator $hashGenerator
     */
    public function __construct(HashGenerator $hashGenerator)
    {
        $this->_hashGenerator = $hashGenerator;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        /** @var Url $entity */
        $entity = $args->getEntity();
        if (!$entity instanceof Url) {
            return;
        }
        if (empty($entity->getShortUrl())) {
            $code = $this->_hashGenerator->getHash();
            $entity->setShortUrl($code);
        }
    }


    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            'prePersist',
        ];
    }
}