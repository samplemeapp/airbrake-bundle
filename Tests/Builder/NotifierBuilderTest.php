<?php
declare(strict_types = 1);


namespace SM\AirbrakeBundle\Tests\Builder;


use Airbrake\Notifier;
use SM\AirbrakeBundle\Builder\NotifierBuilder;

/**
 * Test the functionality of the builder to construct Notifiers.
 *
 * @package SM\AirbrakeBundle\Tests\Builder
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 */
class NotifierBuilderTest extends \PHPUnit_Framework_TestCase
{
    const EMPTY_STRING = '';
    const INVALID_STRING = '       ';
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

    public function testGivenThatAnEmptyProjectKeyIsProvidedThenAConfigurationExceptionWillBeThrown()
    {
        $this->expectException('SM\AirbrakeBundle\Exception\AirbrakeConfigurationException');
        $this->expectExceptionMessage('Project API key cannot be empty');

        $this->notifierBuilder->withProjectKey(self::EMPTY_STRING);
    }

    public function testGivenThatAnInvalidProjectKeyIsProvidedThenAConfigurationExceptionWillBeThrown()
    {
        $this->expectException('SM\AirbrakeBundle\Exception\AirbrakeConfigurationException');
        $this->expectExceptionMessage('Project API key cannot be empty');

        $this->notifierBuilder->withProjectKey(self::INVALID_STRING);
    }

    public function testGivenThatAnEmptyProjectIdIsProvidedThenAConfigurationExceptionWillBeThrown()
    {
        $this->expectException('SM\AirbrakeBundle\Exception\AirbrakeConfigurationException');
        $this->expectExceptionMessage('Project ID cannot be empty');

        $this->notifierBuilder->withProjectId(self::EMPTY_STRING);
    }

    public function testGivenThatAnInvalidProjectIdIsProvidedThenAConfigurationExceptionWillBeThrown()
    {
        $this->expectException('SM\AirbrakeBundle\Exception\AirbrakeConfigurationException');
        $this->expectExceptionMessage('Project ID cannot be empty');

        $this->notifierBuilder->withProjectId(self::INVALID_STRING);
    }

    public function testGivenThatAnEmptyHostIsProvidedThenAConfigurationExceptionWillBeThrown()
    {
        $this->expectException('SM\AirbrakeBundle\Exception\AirbrakeConfigurationException');
        $this->expectExceptionMessage('Host cannot be empty');

        $this->notifierBuilder->withHost(self::EMPTY_STRING);
    }

    public function testGivenThatAnInvalidHostIsProvidedThenAConfigurationExceptionWillBeThrown()
    {
        $this->expectException('SM\AirbrakeBundle\Exception\AirbrakeConfigurationException');
        $this->expectExceptionMessage('Host cannot be empty');

        $this->notifierBuilder->withHost(self::INVALID_STRING);
    }

    public function testGivenThatAnEmptyHttpClientIsProvidedThenAConfigurationExceptionWillBeThrown()
    {
        $this->expectException('SM\AirbrakeBundle\Exception\AirbrakeConfigurationException');
        $this->expectExceptionMessage('HTTP client cannot be empty');

        $this->notifierBuilder->withHttpClient(self::EMPTY_STRING);
    }

    public function testGivenThatAnInvalidHttpClientIsProvidedThenAConfigurationExceptionWillBeThrown()
    {
        $this->expectException('SM\AirbrakeBundle\Exception\AirbrakeConfigurationException');
        $this->expectExceptionMessage('HTTP client cannot be empty');

        $this->notifierBuilder->withHttpClient(self::INVALID_STRING);
    }

    public function testGivenThatAnEmptyRootDirectoryIsProvidedThenAConfigurationExceptionWillBeThrown()
    {
        $this->expectException('SM\AirbrakeBundle\Exception\AirbrakeConfigurationException');
        $this->expectExceptionMessage('Root directory cannot be empty');

        $this->notifierBuilder->withRootDirectory(self::EMPTY_STRING);
    }

    public function testGivenThatAnInvalidRootDirectoryIsProvidedThenAConfigurationExceptionWillBeThrown()
    {
        $this->expectException('SM\AirbrakeBundle\Exception\AirbrakeConfigurationException');
        $this->expectExceptionMessage('Root directory cannot be empty');

        $this->notifierBuilder->withRootDirectory(self::INVALID_STRING);
    }

    public function testGivenThatAValidParametersAreProvidedThenTheNotifierInstanceWillBeConstructedCorrectly()
    {
        $notifierInstance = $this->notifierBuilder
            ->withProjectKey('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa')
            ->withProjectId('000000')
            ->withHost('api.airbrake.io')
            ->withRootDirectory('/var/www/app/')
            ->withIgnoredExceptions([
                'Symfony\Component\HttpKernel\Exception\HttpException',
                'Symfony\Component\Security\Core\Exception\AccessDeniedException',
            ])
            ->build();

        $this->assertTrue($notifierInstance instanceof Notifier);
    }
}
