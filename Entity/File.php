<?php

namespace WH\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * File
 *
 * @ORM\Table(name="file")
 * @ORM\Entity(repositoryClass="WH\MediaBundle\Repository\FileRepository")
 */
class File
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
		$imageFileExtensions = array(
			'jpg',
			'jpeg',
			'gif',
			'png',
		);
		if (in_array($this->getFileExtension(), $imageFileExtensions)) {
			return true;
		}

		return false;
	}
}

