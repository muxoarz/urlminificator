<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UrlClickRepository")
 */
class UrlClick
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    private $ip;

    /**
     * @ORM\ManyToOne(targetEntity="Url")
     * @var Url
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $referer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $useragent;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * UrlClick constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIp(): ?int
    {
        return $this->ip;
    }

    public function setIp(int $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getIpStr()
    {
        return long2ip($this->ip);
    }

    public function setIpStr(string $ip)
    {
        $this->ip = ip2long($ip);

        return $this;
    }

    public function getUrl(): ?Url
    {
        return $this->url;
    }

    public function setUrl(Url $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getReferer(): ?string
    {
        return $this->referer;
    }

    public function setReferer(string $referer): self
    {
        $this->referer = $referer;

        return $this;
    }

    public function getUseragent(): ?string
    {
        return $this->useragent;
    }

    public function setUseragent(string $useragent): self
    {
        $this->useragent = $useragent;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * working correctly only if installed geoip
     */
    public function getCountryCode()
    {
        if (function_exists('geoip_country_code_by_name')) {
            return geoip_country_code_by_name($this->getIpStr());
        }

        return '?';
    }
}
