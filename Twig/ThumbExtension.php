<?php

namespace WH\MediaBundle\Twig;

use League\Glide\Responses\SymfonyResponseFactory;
use League\Glide\ServerFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ThumbExtension
 *
 * @package WH\MediaBundle\Twig
 */
class ThumbExtension extends \Twig_Extension
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
                'wh_thumb',
                [
                    $this,
                    'thumbFilter',
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
     * @param      $format
     * @param bool $getUrl
     *
     * @return string
     */
    public function thumbFilter($entity, $field, $format, $getUrl = false)
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
        $images = [];

        if ($file && $file->getUrl()) {

            $mediaConfig = $this->container->getParameter('wh_media');

            $entityClass = get_class($entity);
            $entityClass = str_replace('Proxies\__CG__\\', '', $entityClass);
            if (!isset($mediaConfig['entities'][$entityClass])) {
                throw new NotFoundHttpException(
                    'L\'entité "' . $entityClass . '" n\'est pas déclarée en dessous de "wh_media.entities"'
                );
            }
            if (!isset($mediaConfig['entities'][$entityClass][$field])) {
                throw new NotFoundHttpException(
                    'Le champ "' . $field . '" n\'est pas déclaré en dessous de "wh_media.entities.' . $entityClass . '"'
                );
            }
            if (!in_array($format, $mediaConfig['entities'][$entityClass][$field]['usedFormats'])) {
                throw new NotFoundHttpException(
                    'Le format "' . $format . '" n\'est pas déclaré en dessous de "wh_media:entities:' . $entityClass . ':usedFormats"'
                );
            }

            $filesystem = $this->container->get('oneup_flysystem.media_filesystem');

            $serverFactory = new ServerFactory(
                [
                    'source'            => $filesystem,
                    'cache'             => $filesystem,
                    'cache_path_prefix' => '.cache',
                ]
            );
            $server = $serverFactory->getServer();

            if ($format != '' && !empty($mediaConfig['formats'][$format])) {
                $formatConfig = $mediaConfig['formats'][$format];

                $glideData = [];

                foreach ($formatConfig['configuration'] as $key => $value) {
                    if ($value) {
                        $glideData[$key] = $value;
                    }
                }

                $response = new SymfonyResponseFactory();
                $server->setResponseFactory($response);


                if ($server->sourceFileExists($file->getUrl())) {
                    $cachedPath = $server->makeImage(
                        $server->getSourcePath($file->getUrl()),
                        $glideData
                    );

                    $images['default'] = '/' . $cachedPath;
                    if ($getUrl) {
                        return $this->container->get('twig')->render(
                            'WHMediaBundle:Frontend/Thumb:view.html.twig',
                            [
                                'url' => $images['default'],
                            ]
                        );
                    }

                    if (!empty($formatConfig['breakpointConfigurations'])) {

                        foreach ($formatConfig['breakpointConfigurations'] as $maxWidth => $configuration) {
                            foreach ($configuration as $key => $value) {
                                if ($value) {
                                    $glideData[$key] = $value;
                                }
                            }

                            $cachedPath = $server->makeImage(
                                $server->getSourcePath($file->getUrl()),
                                $glideData
                            );

                            $images['responsive'][$maxWidth] = '/' . $cachedPath;
                        }
                        ksort($images['responsive']);
                    }
                }
            }
        }

        return $this->container->get('twig')->render(
            'WHMediaBundle:Frontend/Thumb:view.html.twig',
            [
                'file'   => $file,
                'images' => $images,
            ]
        );
    }

    public function getName()
    {
        return 'media_thumb_extension';
    }
}