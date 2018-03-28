<?php

namespace WH\MediaBundle\Twig;

use League\Glide\Responses\SymfonyResponseFactory;
use League\Glide\ServerFactory;
use Symfony\Component\Debug\Exception\ContextErrorException;
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
    public function thumbFilter($fileUrl, $format = 'default', $getUrl = false)
    {
        $mediaConfig = $this->container->getParameter('wh_media');

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

            if ($server->sourceFileExists($fileUrl)) {
                try {
                    $cachedPath = $server->makeImage(
                        $server->getSourcePath($fileUrl),
                        $glideData
                    );

                    $images['default'] = '/'.$cachedPath;
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
                                $server->getSourcePath($fileUrl),
                                $glideData
                            );

                            $images['responsive'][$maxWidth] = '/'.$cachedPath;
                        }
                        ksort($images['responsive']);
                    }
                } catch (ContextErrorException $e) {
                }
            }
        }

        return $this->container->get('twig')->render(
            'WHMediaBundle:Frontend/Thumb:view.html.twig',
            [
                'images' => $images,
            ]
        );
    }

    public function getName()
    {
        return 'media_thumb_extension';
    }
}