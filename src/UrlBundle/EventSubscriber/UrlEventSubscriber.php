<?php
namespace UrlBundle\EventSubscriber;


use Doctrine\ORM\EntityManager;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;

use UrlBundle\Entity\Visit;
use UrlBundle\Event\VisitEvent;

/**
 * Class UrlEventSubscriber
 *
 * @package UrlBundle\EventSubscriber
 */
class UrlEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param EntityManager $em
     * @param RequestStack $requestStack
     */
    public function __construct(EntityManager $em, RequestStack $requestStack)
    {
        $this->em = $em;
        $this->requestStack = $requestStack;
    }

    /**
     * @param $event VisitEvent
     */
    public function onVisit(VisitEvent $event)
    {
        $clientIp = $this->requestStack->getCurrentRequest()->getClientIp();

        $visit = new Visit();
        $visit->setUrl($event->getUrl())
            ->setIp($clientIp)
            ->setVisited(new \DateTime());
        $this->em->persist($visit);
        $this->em->flush();
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            VisitEvent::NAME => 'onVisit',
        ];
    }
}