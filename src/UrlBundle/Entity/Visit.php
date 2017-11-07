<?php

namespace UrlBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Visit
 *
 * @ORM\Table(name="visit")
 * @ORM\Entity(repositoryClass="UrlBundle\Repository\VisitRepository")
 */
class Visit
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Url
     *
     * @ORM\ManyToOne(targetEntity="UrlBundle\Entity\Url", inversedBy="visit")
     * @ORM\JoinColumn(name="url_id", referencedColumnName="id")
     */
    private $url;

    /**
     * @var int
     *
     * @ORM\Column(name="ip", type="integer", options={"unsigned":true})
     */
    private $ip;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="visited", type="datetime")
     */
    private $visited;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Url
     */
    public function getUrl(): Url
    {
        return $this->url;
    }

    /**
     * @param Url $url
     *
     * @return Visit
     */
    public function setUrl(Url $url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Set ip
     *
     * @param integer $ip
     *
     * @return Visit
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return int
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set visited
     *
     * @param \DateTime $visited
     *
     * @return Visit
     */
    public function setVisited($visited)
    {
        $this->visited = $visited;

        return $this;
    }

    /**
     * Get visited
     *
     * @return \DateTime
     */
    public function getVisited()
    {
        return $this->visited;
    }
}

