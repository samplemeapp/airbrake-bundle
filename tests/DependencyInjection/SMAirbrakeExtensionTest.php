<?php
declare(strict_types = 1);


namespace SM\AirbrakeBundle\Tests\DependencyInjection;

use SM\AirbrakeBundle\DependencyInjection\SMAirbrakeExtension;

/**
 * Test the behaviour of the bundle extension class.
 *
 * @package SM\AirbrakeBundle\tests\DependencyInjection
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 */
class SMAirbrakeExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SMAirbrakeExtension
     */
    protected $extension;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->extension = new SMAirbrakeExtension;
    }

    public function testGivenThatTheExtensionIsLoadedThenTheConfigurationParametersWillBeExposed()
    {
        $configs          = $this->getValidConfigurationParameters();
        $containerBuilder = $this->getContainerMock();

        $containerBuilder->expects($this->atLeastOnce())->method('setParameter');
        $containerBuilder->expects($this->atLeastOnce())->method('getParameter')->with('kernel.root_dir')->willReturn('/var/www/symfony/app');

        $this->extension->load($configs, $containerBuilder);
    }

    public function testGivenThatNoConfigurationIsMadeThenTheConfigurationParametersAreStillExposedUsingTheirDefaultValues()
    {
        $configs          = [];
        $containerBuilder = $this->getContainerMock();

        $containerBuilder->expects($this->atLeastOnce())->method('setParameter');
        $containerBuilder->expects($this->atLeastOnce())->method('getParameter')->with('kernel.root_dir')->willReturn(__FILE__);

        $this->extension->load($configs, $containerBuilder);
    }

    public function testGivenNoConfigurationAndHavingAnAppVersionStoredInTheContainerFromEnvironmentalVariablesOrOtherwiseThenTheContainerParametersWillBePopulatedWithTheCustomValue()
    {
        $configs          = [
            'sm_airbrake' => [
                'root_directory' => '/var/www/symfony/app',
                'app_version'    => '1.0RC',
            ]
        ];
        $containerBuilder = $this->getContainerMock();

        $containerBuilder->expects($this->atLeastOnce())->method('setParameter');
        $containerBuilder->expects($this->atLeastOnce())->method('hasParameter')->with('app.environment')->willReturn(true);
        $containerBuilder->expects($this->atLeastOnce())->method('getParameter')->with('app.environment')->willReturn('TST');

        $this->extension->load($configs, $containerBuilder);
    }

    private function getContainerMock(): \PHPUnit_Framework_MockObject_MockObject
    {
        return $this->getMockBuilder('Symfony\Component\DependencyInjection\ContainerBuilder')
            ->disableOriginalConstructor()
            ->setMethods(['setParameter', 'getParameter', 'hasParameter'])
            ->getMock();
    }

    private function getValidConfigurationParameters(): array
    {
        return [
            'sm_airbrake' => [
                'global_exception_instance'          => true,
                'global_error_and_exception_handler' => false,
                'ignored_exceptions'                 => [
                    'Symfony\Component\HttpKernel\Exception\HttpException',
                    'Symfony\Component\Security\Core\Exception\AccessDeniedException',
                ],
                'host'                               => 'api.airbrake.io',
                'http_client'                        => 'default',
                'project_id'                         => '000000',
                'project_key'                        => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            ],
        ];
    }
}
