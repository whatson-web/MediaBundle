<?php

namespace WH\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * File
 *
 * @ORM\Table(name="file")
 * @ORM\Entity(repositoryClass="WH\MediaBundle\Repository\FileRepository")
 */
class File
{

    /**
     * @return mixed|string
     */
    public function getFileName()
    {
        $fileName = preg_replace('#.*\/(.*\..*)#', '$1', $this->url);

        return $fileName;
    }

    /**
     * @return mixed|string
     */
    public function getFileExtension()
    {
        $fileExtension = preg_replace('#.*\/.*\.(.*)#', '$1', $this->url);
        $fileExtension = strtolower($fileExtension);

        return $fileExtension;
    }

    /**
     * @return bool
     */
    public function getIsImage()
    {
        $imageFileExtensions = [
            'jpg',
            'jpeg',
            'gif',
            'png',
        ];
        if (in_array($this->getFileExtension(), $imageFileExtensions)) {
            return true;
        }

        return false;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255, nullable=true)
     */
    private $alt;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="translatableUrl", type="string", length=255, nullable=true)
     */
    private $translatableUrl;

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
     * Set url
     *
     * @param string $url
     *
     * @return File
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return File
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set translatableUrl
     *
     * @param string $translatableUrl
     *
     * @return File
     */
    public function setTranslatableUrl($translatableUrl)
    {
        $this->translatableUrl = $translatableUrl;

        return $this;
    }

    /**
     * Get translatableUrl
     *
     * @return string
     */
    public function getTranslatableUrl()
    {
        return $this->translatableUrl;
    }

}

