<?php
declare(strict_types = 1);


namespace SM\AirbrakeBundle\Tests\Service;


use Airbrake\ErrorHandler;
use Airbrake\Notifier;
use SM\AirbrakeBundle\Builder\NotifierBuilder;
use SM\AirbrakeBundle\Service\AirbrakeService;

/**
 * Tests the behaviour of the Airbrake service.
 *
 * @package SM\AirbrakeBundle\Tests\Service
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 */
class AirbrakeServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var NotifierBuilder
     */
    protected $notifierBuilder;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->notifierBuilder = new NotifierBuilder;
    }

    public function testGivenInvalidConfigurationParametersThenAnExceptionWillBeThrown()
    {
        $configurationParameters = [
                'projectKey' => '   ',
            ] + $this->getValidConfigurationParameters();

        $this->expectException('SM\\AirbrakeBundle\\Exception\\AirbrakeConfigurationException');
        $this->expectExceptionMessage('Project ID cannot be empty');

        $this->createServiceFromConfigurationParameters($configurationParameters);
    }

    public function testGivenValidConfigurationParametersThenTheServiceWillBeBootedCorrectly()
    {
        $configurationParameters = $this->getValidConfigurationParameters();
        $airbrakeService         = $this->createServiceFromConfigurationParameters($configurationParameters);

        $this->assertNotNull($airbrakeService);
        $this->assertTrue($airbrakeService instanceof AirbrakeService);

        $this->assertNull($airbrakeService->getErrorHandler());
        $this->assertTrue($airbrakeService->getNotifier() instanceof Notifier);
    }

    public function testGivenThatTheErrorHandlerIsRequiredThenTheInstanceWillBeAccessibleOnTheService()
    {
        $configurationParameters = [
                'globalErrorAndExceptionHandler' => true,
            ] + $this->getValidConfigurationParameters();
        $aibrakeService          = $this->createServiceFromConfigurationParameters($configurationParameters);

        $this->assertNotNull($aibrakeService);
        $this->assertTrue($aibrakeService instanceof AirbrakeService);

        $this->assertNotNull($aibrakeService->getErrorHandler());
        $this->assertTrue($aibrakeService->getErrorHandler() instanceof ErrorHandler);
    }

    /**
     * @return array
     */
    protected function getValidConfigurationParameters():array
    {
        $configurationParameters = [
            'projectKey'                     => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'projectId'                      => '000000',
            'host'                           => 'api.airbrake.io',
            'rootDirectory'                  => '/var/www/app/',
            'httpClient'                     => 'default',
            'ignoredExceptions'              => [
                'Symfony\Component\HttpKernel\Exception\HttpException',
                'Symfony\Component\Security\Core\Exception\AccessDeniedException',
            ],
            'globalExceptionInstance'        => true,
            'globalErrorAndExceptionHandler' => false,
            'environment'                    => 'PRD',
            'appVersion'                     => '1.0',
        ];

        return $configurationParameters;
    }

    /**
     * @param $configurationParameters
     *
     * @return AirbrakeService
     */
    protected function createServiceFromConfigurationParameters($configurationParameters):AirbrakeService
    {
        $aibrakeService = new AirbrakeService(
            $this->notifierBuilder,
            $configurationParameters['projectKey'],
            $configurationParameters['projectId'],
            $configurationParameters['globalExceptionInstance'],
            $configurationParameters['globalErrorAndExceptionHandler'],
            $configurationParameters['host'],
            $configurationParameters['httpClient'],
            $configurationParameters['rootDirectory'],
            $configurationParameters['ignoredExceptions'],
            $configurationParameters['environment'],
            $configurationParameters['appVersion']
        );

        return $aibrakeService;
    }
}
