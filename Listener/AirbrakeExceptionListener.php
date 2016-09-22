<?php
declare(strict_types = 1);


namespace SM\AirbrakeBundle\Listener;

use SM\AirbrakeBundle\Service\AirbrakeService;
use Symfony\Component\Console\Event\ConsoleExceptionEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * Listens for exceptions and acts on them if the
 * Airbrake parameters have been provided.
 *
 * @package SM\AirbrakeBundle\Listener
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 */
class AirbrakeExceptionListener
{
    /**
     * Whether or not the listener is enabled.
     *
     * @var bool
     */
    protected $listenerEnabled;

    /**
     * @var AirbrakeService
     */
    protected $airbrakeService;

    /**
     * AirbrakeExceptionListener constructor.
     *
     * @param bool            $listenerEnabled
     * @param AirbrakeService $airbrakeService
     */
    public function __construct($listenerEnabled, AirbrakeService $airbrakeService)
    {
        $this->listenerEnabled = $listenerEnabled;
        $this->airbrakeService = $airbrakeService;
    }

    /**
     * Handled on a kernel exceptions.
     *
     * @param GetResponseForExceptionEvent $exceptionEvent
     */
    public function onKernelException(GetResponseForExceptionEvent $exceptionEvent)
    {
        $this->handleNotificationToAirbreakIfApplicable($exceptionEvent->getException());
    }

    /**
     * Handled on console exceptions.
     *
     * @param ConsoleExceptionEvent $exceptionEvent
     */
    public function onConsoleException(ConsoleExceptionEvent $exceptionEvent)
    {
        $this->handleNotificationToAirbreakIfApplicable($exceptionEvent->getException());
    }

    /**
     * Unify the workflows for kernel and console exceptions.
     *
     * @param \Exception $exception
     */
    protected function handleNotificationToAirbreakIfApplicable($exception)
    {
        if (true === $this->listenerEnabled) {
            $this->airbrakeService->notify($exception);
        }
    }
}
