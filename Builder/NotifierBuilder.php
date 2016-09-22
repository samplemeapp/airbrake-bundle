<?php
declare(strict_types = 1);


namespace SM\AirbrakeBundle\Builder;

use Airbrake\Notifier;
use SM\AirbrakeBundle\Enum\AirbrakeDefaultEnum;
use SM\AirbrakeBundle\Exception\AirbrakeConfigurationException;

/**
 * Handles the construction of Airbrake notifiers.
 *
 * @package SM\AirbrakeBundle\Builder
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 */
class NotifierBuilder implements BuilderInterface
{
    /**
     * @var string
     */
    protected $projectKey;

    /**
     * @var string
     */
    protected $projectId;

    /**
     * @var string
     */
    protected $host;

    /**
     * @var string
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $rootDirectory;

    /**
     * @var array
     */
    protected $ignoredExceptions;

    /**
     * @var string
     */
    protected $environment;

    /**
     * @var string
     */
    protected $appVersion;

    /**
     * NotifierBuilder constructor.
     */
    public function __construct()
    {
        $this->clear();
    }

    public function withProjectKey(string $projectKey): NotifierBuilder
    {
        if (empty(trim($projectKey))) {
            throw new AirbrakeConfigurationException('Project API key cannot be empty');
        }

        $this->projectKey = $projectKey;

        return $this;
    }

    public function withProjectId(string $projectId): NotifierBuilder
    {
        if (empty(trim($projectId))) {
            throw new AirbrakeConfigurationException('Project ID cannot be empty');
        }

        $this->projectId = $projectId;

        return $this;
    }

    public function withHost(string $host): NotifierBuilder
    {
        if (empty(trim($host))) {
            throw new AirbrakeConfigurationException('Host cannot be empty');
        }

        $this->host = $host;

        return $this;
    }

    public function withHttpClient(string $httpClient): NotifierBuilder
    {
        if (empty(trim($httpClient))) {
            throw new AirbrakeConfigurationException('HTTP client cannot be empty');
        }

        $this->httpClient = $httpClient;

        return $this;
    }

    public function withRootDirectory(string $rootDirectory): NotifierBuilder
    {
        if (empty(trim($rootDirectory))) {
            throw new AirbrakeConfigurationException('Root directory cannot be empty');
        }

        $this->rootDirectory = $rootDirectory;

        return $this;
    }

    public function withIgnoredExceptions(array $ignoredExceptions = []): NotifierBuilder
    {
        $this->ignoredExceptions = $ignoredExceptions;

        return $this;
    }

    public function withEnvironment(string $environment): NotifierBuilder
    {
        if (empty(trim($environment))) {
            throw new AirbrakeConfigurationException('Environment cannot be empty');
        }

        $this->environment = $environment;

        return $this;
    }

    public function withAppVersion(string $appVersion): NotifierBuilder
    {
        if (empty(trim($appVersion))) {
            throw new AirbrakeConfigurationException('App version cannot be empty');
        }

        $this->appVersion = $appVersion;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function build(): Notifier
    {
        $notifierInstance = new Notifier([
            'projectId'     => $this->projectId,
            'projectKey'    => $this->projectKey,
            'host'          => $this->host,
            'rootDirectory' => $this->rootDirectory,
            'httpClient'    => $this->httpClient,
            'environment'   => $this->environment,
            'appVersion'    => $this->appVersion,
        ]);

        if (false === empty($this->ignoredExceptions)) {
            $notifierInstance->addFilter(function ($notice) {
                foreach ($this->ignoredExceptions as $exceptionClass) {
                    if ($notice['errors'][0]['type'] === $exceptionClass) {
                        return null;
                    }
                }

                return $notice;
            });
        }
        $this->clear();

        return $notifierInstance;
    }

    /**
     * @inheritDoc
     */
    public function clear()
    {
        $this->projectKey        = AirbrakeDefaultEnum::PROJECT_KEY;
        $this->projectId         = AirbrakeDefaultEnum::PROJECT_ID;
        $this->host              = AirbrakeDefaultEnum::HOST;
        $this->httpClient        = AirbrakeDefaultEnum::HTTP_CLIENT;
        $this->ignoredExceptions = AirbrakeDefaultEnum::IGNORED_EXCEPTIONS;
        $this->rootDirectory     = AirbrakeDefaultEnum::ROOT_DIRECTORY;
        $this->environment       = AirbrakeDefaultEnum::ENVIRONMENT;
        $this->appVersion        = AirbrakeDefaultEnum::APP_VERSION;
    }
}
