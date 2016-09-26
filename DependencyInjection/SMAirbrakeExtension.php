<?php
declare(strict_types = 1);

namespace SM\AirbrakeBundle\DependencyInjection;

use SM\AirbrakeBundle\Enum\AirbrakeDefaultEnum;
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

        $this->configureRootDirectory($container, $config);
        $this->configureEnvironment($container, $config);
        $this->configureAppVersion($container, $config);
    }

    /**
     * Get the application version from the VERSION file in the root directory.
     *
     * @param ContainerBuilder $container
     *
     * @return string
     */
    private function getAppVersion(ContainerBuilder $container): string
    {
        $kernelRootDir = dirname($container->getParameter('kernel.root_dir'));

        if (false === file_exists("{$kernelRootDir}/VERSION")) {
            return AirbrakeDefaultEnum::APP_VERSION;
        }

        return file_get_contents("$kernelRootDir/VERSION");
    }

    /**
     * Configure the root directory parameter.
     *
     * @param ContainerBuilder $container
     * @param array            $config
     */
    protected function configureRootDirectory(ContainerBuilder $container, array $config)
    {
        if (AirbrakeDefaultEnum::ROOT_DIRECTORY === $config['root_directory']) {
            $container->setParameter(
                'sm_airbrake.root_directory',
                dirname($container->getParameter('kernel.root_dir'))
            );
        }
    }

    /**
     * Configure the environment parameter.
     *
     * @param ContainerBuilder $container
     * @param array            $config
     */
    protected function configureEnvironment(ContainerBuilder $container, array $config)
    {
        if (AirbrakeDefaultEnum::ENVIRONMENT === $config['environment']
            && $container->hasParameter('app.environment')
        ) {
            $container->setParameter(
                'sm_airbrake.environment',
                $container->getParameter('app.environment')
            );
        }
    }

    /**
     * Configure the application version parameter.
     *
     * @param ContainerBuilder $container
     * @param array $config
     */
    protected function configureAppVersion(ContainerBuilder $container, array $config)
    {
        if (AirbrakeDefaultEnum::APP_VERSION === $config['app_version']) {
            $container->setParameter(
                'sm_airbrake.app_version',
                $this->getAppVersion($container)
            );
        }
    }
}
