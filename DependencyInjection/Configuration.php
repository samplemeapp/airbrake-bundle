<?php
declare(strict_types = 1);

namespace SM\AirbrakeBundle\DependencyInjection;

use SM\AirbrakeBundle\Enum\AirbrakeDefaultEnum;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Sets up the configuration parameters of the Airbrake bundle.
 *
 * @package SM\AirbrakeBundle\DependencyInjection
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('sm_airbrake');

        $rootNode
            ->children()
                ->scalarNode('project_id')
                    ->defaultValue(AirbrakeDefaultEnum::PROJECT_ID)
                    ->end()
                ->scalarNode('project_key')
                    ->defaultValue(AirbrakeDefaultEnum::PROJECT_KEY)
                    ->end()
                ->scalarNode('http_client')
                    ->defaultValue(AirbrakeDefaultEnum::HTTP_CLIENT)
                    ->end()
                ->booleanNode('global_exception_instance')
                    ->defaultValue(AirbrakeDefaultEnum::GLOBAL_EXCEPTION_INSTANCE)
                    ->end()
                ->booleanNode('global_error_and_exception_handler')
                    ->defaultValue(AirbrakeDefaultEnum::GLOBAL_ERROR_AND_EXCEPTION_HANDLER)
                    ->end()
                ->scalarNode('host')
                    ->defaultValue(AirbrakeDefaultEnum::HOST)
                    ->end()
                ->arrayNode('ignored_exceptions')
                    ->prototype('scalar')->end()
                    ->defaultValue(AirbrakeDefaultEnum::IGNORED_EXCEPTIONS)
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
