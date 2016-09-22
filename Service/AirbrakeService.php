<?php
declare(strict_types = 1);


namespace SM\AirbrakeBundle\Service;


use Airbrake\ErrorHandler;
use Airbrake\Instance;
use Airbrake\Notifier;
use SM\AirbrakeBundle\Builder\NotifierBuilder;
use SM\AirbrakeBundle\Exception\AirbrakeConnectionException;

/**
 * Defines the Airbrake service wrapper.
 *
 * @package SM\AirbrakeBundle\Service
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 */
class AirbrakeService
{
    /**
     * Notifier that has been set up with configuration parameters
     * and filters.
     *
     * @var Notifier
     */
    protected $notifier;

    /**
     * The global error and exception handler instance.
     * Defaults to null if the global_error_and_exception_handler
     * configuration is set to false.
     *
     * @var ErrorHandler
     */
    protected $errorHandler;

    /**
     * AirbrakeService constructor.
     *
     * @param NotifierBuilder $notifierBuilder
     * @param string          $projectId
     * @param string          $projectKey
     * @param bool            $globalExceptionInstance
     * @param bool            $globalErrorAndExceptionHandler
     * @param string          $host
     * @param string          $httpClient
     * @param string          $rootDirectory
     * @param array           $ignoredExceptions
     * @param string          $environment
     * @param string          $appVersion
     */
    public function __construct(NotifierBuilder $notifierBuilder, string $projectId, string $projectKey, bool $globalExceptionInstance, bool $globalErrorAndExceptionHandler, string $host, string $httpClient, string $rootDirectory, array $ignoredExceptions = [], string $environment, string $appVersion)
    {
        $this->notifier = $notifierBuilder
            ->withProjectKey($projectKey)
            ->withProjectId($projectId)
            ->withHost($host)
            ->withHttpClient($httpClient)
            ->withIgnoredExceptions($ignoredExceptions)
            ->withRootDirectory($rootDirectory)
            ->withEnvironment($environment)
            ->withAppVersion($appVersion)
            ->build();

        $this
            ->withGlobalExceptionInstance($globalExceptionInstance)
            ->withGlobalErrorAndExceptionHandler($globalErrorAndExceptionHandler);
    }

    /**
     * Notify Airbrake of the exception.
     *
     * @param \Exception $exception
     *
     * @return bool
     * @throws AirbrakeConnectionException
     */
    public function notify(\Exception $exception): bool
    {
        $airbrakeResponse = $this->notifier->notify($exception);

        if (array_key_exists('id', $airbrakeResponse)) {
            return true;
        }

        throw new AirbrakeConnectionException($airbrakeResponse['error']);
    }

    /**
     * @return Notifier
     */
    public function getNotifier(): Notifier
    {
        return $this->notifier;
    }

    /**
     * @return ErrorHandler|null
     */
    public function getErrorHandler()
    {
        return $this->errorHandler;
    }

    /**
     * Add a global exception instance if applicable.
     *
     * @param bool $globalExceptionInstance
     *
     * @return AirbrakeService
     */
    protected function withGlobalExceptionInstance(bool $globalExceptionInstance): AirbrakeService
    {
        if (true === $globalExceptionInstance) {
            Instance::set($this->notifier);
        }

        return $this;
    }

    /**
     * Add a global error and exception handler if applicable.
     *
     * @param bool $globalErrorAndExceptionHandler
     *
     * @return AirbrakeService
     */
    protected function withGlobalErrorAndExceptionHandler(bool $globalErrorAndExceptionHandler): AirbrakeService
    {
        if (true === $globalErrorAndExceptionHandler) {
            $this->errorHandler = new ErrorHandler($this->notifier);
            $this->errorHandler->register();
        }

        return $this;
    }
}
