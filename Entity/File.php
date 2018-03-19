<?php

namespace WH\MediaBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Annotation\ApiFilter;
use WH\LibBundle\Filter\SearchAnnotation as Searchable;


/**
 * File
 *
 * @ORM\Table(name="file")
 * @ORM\Entity(repositoryClass="WH\MediaBundle\Repository\FileRepository")
 * @ApiResource(
 *     attributes={
 *          "order"={"updated": "desc"},
 *          "filters"={"wh.searchfilter"}
 *      },
 * )
 * @Searchable({"url", "alt", "description"})
 */
class File {


    public function __construct()
    {
        $this->updated = new \DateTime();
    }

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
    public function getFolder()
    {
        $folder = preg_replace('#^(.*)/(.*)\.(.*)$#', '$1', $this->url);

        return $folder;
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
     * @return mixed|string
     */
    public function getUrlLast()
    {

        $last = '';
        if($this->getUpdated()) $last = $this->updated->getTimestamp();
        return $this->url.'?last='.$last;

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
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var string
     * @ORM\Column(name="alt", type="string", length=255, nullable=true)
     */
    private $alt;

    /**
     * @var string
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="translatableUrl", type="string", length=255, nullable=true)
     */
    private $translatableUrl;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;

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

    /**
     * Set setDescription
     *
     * @param string $description
     *
     * @return File
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get getDescription
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }


    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return File
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }


}

