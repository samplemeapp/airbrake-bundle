<?php
declare(strict_types = 1);

namespace SM\AirbrakeBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Defines the service container configuration for the bundle.
 *
 * @package SM\AirbrakeBundle\DependencyInjection
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 */
class SMAirbrakeExtension extends Extension
{
    /**
     * Loads a specific configuration.
     *
     * @param array            $configs   An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        foreach ($config as $configKey => $configValue) {
            $container->setParameter("sm_airbrake.{$configKey}", $configValue);
        }
        $container->setParameter('sm_airbrake.root_directory', dirname($container->getParameter('kernel.root_dir')));
    }
}
