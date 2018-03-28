<?php

namespace WH\MediaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package WH\MediaBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{

    /**
     * @return mixed
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        return $treeBuilder
            ->root('wh_media', 'array')
                ->children()
                    ->arrayNode('formats')
                        ->prototype('array')
                            ->children()
                                ->arrayNode('configuration')
                                    ->children()
                                        ->scalarNode('fit')->defaultValue('')->end()
                                        ->scalarNode('w')->defaultValue('')->end()
                                        ->scalarNode('h')->defaultValue('')->end()
                                        ->scalarNode('crop')->defaultValue('')->end()
                                        ->scalarNode('blur')->defaultValue('')->end()
                                        ->scalarNode('pixel')->defaultValue('')->end()
                                        ->scalarNode('filt')->defaultValue('')->end()
                                    ->end()
                                ->end()
                                ->arrayNode('breakpointConfigurations')
                                    ->prototype('array')
                                        ->children()
                                            ->scalarNode('fit')->defaultValue('')->end()
                                            ->scalarNode('w')->defaultValue('')->end()
                                            ->scalarNode('h')->defaultValue('')->end()
                                            ->scalarNode('crop')->defaultValue('')->end()
                                            ->scalarNode('blur')->defaultValue('')->end()
                                            ->scalarNode('pixel')->defaultValue('')->end()
                                            ->scalarNode('filt')->defaultValue('')->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
