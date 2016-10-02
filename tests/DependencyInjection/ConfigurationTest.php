<?php
declare(strict_types = 1);


namespace SM\AirbrakeBundle\Tests\DependencyInjection;

use SM\AirbrakeBundle\DependencyInjection\Configuration;
use SM\AirbrakeBundle\Enum\AirbrakeDefaultEnum;
use Symfony\Component\Config\Definition\ArrayNode;
use Symfony\Component\Config\Definition\BooleanNode;
use Symfony\Component\Config\Definition\ScalarNode;

/**
 * tests the functionality of the bundle configuration class.
 *
 * @package SM\AirbrakeBundle\tests\DependencyInjection
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->configuration = new Configuration;
    }

    public function testGivenThatTheConfigurationTreeForTheBundleIsBuiltThenAllOfItsOptionsAreInPlace()
    {
        /** @var ArrayNode $compiledTree */
        $compiledTree = (new Configuration())->getConfigTreeBuilder()->buildTree();

        $this->assertTrue($compiledTree instanceof ArrayNode);
        $children = $compiledTree->getChildren();

        $this->assertArrayHasKey('project_id', $children);
        /** @var ScalarNode $projectIdNode */
        $projectIdNode = $children['project_id'];
        $this->assertEquals(AirbrakeDefaultEnum::PROJECT_KEY, $projectIdNode->getDefaultValue());

        $this->assertArrayHasKey('project_key', $children);
        /** @var ScalarNode $projectKeyNode */
        $projectKeyNode = $children['project_key'];
        $this->assertEquals(AirbrakeDefaultEnum::PROJECT_KEY, $projectKeyNode->getDefaultValue());

        $this->assertArrayHasKey('host', $children);
        /** @var ScalarNode $hostNode */
        $hostNode = $children['host'];
        $this->assertEquals(AirbrakeDefaultEnum::HOST, $hostNode->getDefaultValue());

        $this->assertArrayHasKey('ignored_exceptions', $children);
        /** @var ArrayNode $ignoredExceptionsNode */
        $ignoredExceptionsNode = $children['ignored_exceptions'];
        $this->assertInternalType('array', $ignoredExceptionsNode->getDefaultValue());
        $this->assertEquals(AirbrakeDefaultEnum::IGNORED_EXCEPTIONS, $ignoredExceptionsNode->getDefaultValue());

        $this->assertArrayHasKey('global_exception_instance', $children);
        /** @var BooleanNode $globalExceptionInstanceNode */
        $globalExceptionInstanceNode = $children['global_exception_instance'];
        $this->assertEquals(AirbrakeDefaultEnum::GLOBAL_EXCEPTION_INSTANCE, $globalExceptionInstanceNode->getDefaultValue());

        $this->assertArrayHasKey('global_error_and_exception_handler', $children);
        /** @var BooleanNode $globalErrorAndExceptionHandlerNode */
        $globalErrorAndExceptionHandlerNode = $children['global_error_and_exception_handler'];
        $this->assertEquals(AirbrakeDefaultEnum::GLOBAL_ERROR_AND_EXCEPTION_HANDLER, $globalErrorAndExceptionHandlerNode->getDefaultValue());

        $this->assertArrayHasKey('http_client', $children);
        /** @var ScalarNode $httpClientNode */
        $httpClientNode = $children['http_client'];
        $this->assertEquals(AirbrakeDefaultEnum::HTTP_CLIENT, $httpClientNode->getDefaultValue());

        $this->assertArrayHasKey('root_directory', $children);
        /** @var ScalarNode $rootDirectoryNode */
        $rootDirectoryNode = $children['root_directory'];
        $this->assertEquals(AirbrakeDefaultEnum::ROOT_DIRECTORY, $rootDirectoryNode->getDefaultValue());

        $this->assertArrayHasKey('environment', $children);
        /** @var ScalarNode $environmentNode */
        $environmentNode = $children['environment'];
        $this->assertEquals(AirbrakeDefaultEnum::ENVIRONMENT, $environmentNode->getDefaultValue());

        $this->assertArrayHasKey('app_version', $children);
        /** @var ScalarNode $appVersionNode */
        $appVersionNode = $children['app_version'];
        $this->assertEquals(AirbrakeDefaultEnum::APP_VERSION, $appVersionNode->getDefaultValue());

        $this->assertArrayHasKey('listener_enabled', $children);
        /** @var ScalarNode $listenerEnabledNode */
        $listenerEnabledNode = $children['listener_enabled'];
        $this->assertEquals(AirbrakeDefaultEnum::LISTNER_ENABLED, $listenerEnabledNode->getDefaultValue());
    }
}
