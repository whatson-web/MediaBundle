<?php

namespace WH\MediaBundle\Services;

use League\Flysystem\Filesystem;
use League\Glide\ServerFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class FileManager
 *
 * @package MediaBundle\Services
 */
class FileManager
{

	protected $container;

	/**
	 * SearchController constructor.
	 *
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	/**
	 * @param UploadedFile $uploadedFile
	 * @param string       $basePath
	 *
	 * @return bool
	 */
	public function uploadFile(UploadedFile $uploadedFile, $basePath = '')
	{
		$filesystem = $this->container->get('oneup_flysystem.media_filesystem');
		$filesystem->put(
			$basePath . $uploadedFile->getClientOriginalName(),
			file_get_contents($uploadedFile->getRealPath())
		);

		return true;
	}

}