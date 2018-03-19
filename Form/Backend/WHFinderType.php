<?php

namespace WH\MediaBundle\Form\Backend;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

/**
 * Class WHFinderType
 *
 * @package WH\MediaBundle\Form\Backend
 */
class WHFinderType extends AbstractType
{
    /**
     * @return null|string
     */
    public function getParent()
    {
        return HiddenType::class;
    }
}