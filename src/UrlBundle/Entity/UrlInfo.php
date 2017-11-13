<?php

namespace UrlBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UrlInfo
 *
 * @ORM\Table(name="url_info")
 * @ORM\Entity(repositoryClass="UrlBundle\Repository\UrlInfoRepository")
 */
class UrlInfo
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
     * @var int
     *
     * @ORM\Column(name="ip", type="string", length=15)
     */
    private $ip;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="screenshot", type="string", length=255)
     */
    private $screenshot;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;


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
     * Set ip
     *
     * @param string $ip
     *
     * @return UrlInfo
     */
    public function setIp(string $ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return UrlInfo
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return UrlInfo
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set screenshot
     *
     * @param string $screenshot
     *
     * @return UrlInfo
     */
    public function setScreenshot($screenshot)
    {
        $this->screenshot = $screenshot;

        return $this;
    }

    /**
     * Get screenshot
     *
     * @return string
     */
    public function getScreenshot()
    {
        return $this->screenshot;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return UrlInfo
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }
}
