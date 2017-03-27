<?php

namespace WH\MediaBundle\Repository;

use WH\LibBundle\Repository\BaseRepository;

/**
 * Class FileRepository
 *
 * @package WH\MediaBundle\Repository
 */
class FileRepository extends BaseRepository
{

	/**
	 * @return string
	 */
	public function getEntityNameQueryBuilder()
	{
		return 'file';
	}
}
