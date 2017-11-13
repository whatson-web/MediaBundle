<?php

namespace WH\MediaBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class FileExtension
 *
 * @package WH\MediaBundle\Twig
 */
class FileExtension extends \Twig_Extension
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
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter(
                'wh_file',
                [
                    $this,
                    'fileFilter',
                ],
                [
                    'is_safe' => [
                        'html',
                    ],
                ]
            ),
        ];
    }

    /**
     * @param      $entity
     * @param      $field
     * @param bool $getUrl
     *
     * @return string
     */
    public function fileFilter($entity, $field, $getUrl = false)
    {
        $fileId = null;
        if ($entity->{'get' . ucfirst($field)}()) {
            $fileId = $entity->{'get' . ucfirst($field)}()->getId();
        }

        $em = $this->container->get('doctrine')->getManager();

        $file = $em->getRepository('WHMediaBundle:File')->get(
            'one',
            [
                'conditions' => [
                    'file.id' => $fileId,
                ],
            ]
        );

        $renderVars = [];

        if ($file && $file->getUrl()) {
            if ($getUrl) {
                $renderVars['url'] = $file->getUrl();
            } else {
                $renderVars['file'] = $file;
            }
        }

        if ($file && $file->getTranslatableUrl()) {
            if ($getUrl) {
                $renderVars['url'] = $file->getUrl();
            } else {
                $renderVars['file'] = $file;
            }
        }

        return $this->container->get('twig')->render(
            'WHMediaBundle:Frontend/File:view.html.twig',
            $renderVars
        );
    }

    public function getName()
    {
        return 'media_file_extension';
    }
}