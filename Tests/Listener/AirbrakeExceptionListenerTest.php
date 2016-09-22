<?php
declare(strict_types = 1);


namespace SM\AirbrakeBundle\Tests\Listener;

use SM\AirbrakeBundle\Listener\AirbrakeExceptionListener;

/**
 * Test the functionality of the exception listener.
 *
 * @package SM\AirbrakeBundle\Tests\Listener
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 */
class AirbrakeExceptionListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Exception
     */
    protected $exception;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->exception = new \Exception;
    }

    public function testGivenThatTheListenerIsDisabledThenAirbrakeWillNotBeNotifiedOfKernelExceptions()
    {
        $airbrakeService = $this->getAirbrakeService();
        $airbrakeService->expects($this->never())->method('notify');

        $listener = new AirbrakeExceptionListener(false, $airbrakeService);
        $listener->onKernelException($this->getKernelExceptionEvent());
    }

    public function testGivenThatTheListenerIsDisabledThenAirbrakeWillNotBeNotifiedOfConsoleExceptions()
    {
        $airbrakeService = $this->getAirbrakeService();
        $airbrakeService->expects($this->never())->method('notify');

        $listener = new AirbrakeExceptionListener(false, $airbrakeService);
        $listener->onConsoleException($this->getConsoleExceptionEvent());
    }

    public function testGivenThatTheListenerIsEnabledThenAirbrakeWillBeNotifiedOfKernelExceptions()
    {
        $airbrakeService = $this->getAirbrakeService();
        $airbrakeService->expects($this->once())->method('notify');

        $listener = new AirbrakeExceptionListener(true, $airbrakeService);
        $listener->onKernelException($this->getKernelExceptionEvent());
    }

    public function testGivenThatTheListenerIsEnabledThenAirbrakeWillBeNotifiedOfConsoleExceptions()
    {
        $airbrakeService = $this->getAirbrakeService();
        $airbrakeService->expects($this->once())->method('notify');

        $listener = new AirbrakeExceptionListener(true, $airbrakeService);
        $listener->onConsoleException($this->getConsoleExceptionEvent());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getAirbrakeService():\PHPUnit_Framework_MockObject_MockObject
    {
        $airbrakeService = $this->getMockBuilder('SM\AirbrakeBundle\Service\AirbrakeService')
            ->disableOriginalConstructor()
            ->setMethods(['notify'])
            ->getMock();

        return $airbrakeService;
    }

    /**
     * Generate a kernel exception event signature.
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getKernelExceptionEvent(): \PHPUnit_Framework_MockObject_MockObject
    {
        $kernelException = $this->getMockBuilder('Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent')
            ->disableOriginalConstructor()
            ->setMethods(['getException'])
            ->getMock();
        $kernelException->expects($this->any())->method('getException')->willReturn($this->exception);

        return $kernelException;
    }

    /**
     * Generate a console exception event signature.
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getConsoleExceptionEvent(): \PHPUnit_Framework_MockObject_MockObject
    {
        $consoleException = $this->getMockBuilder('Symfony\Component\Console\Event\ConsoleExceptionEvent')
            ->disableOriginalConstructor()
            ->setMethods(['getException'])
            ->getMock();
        $consoleException->expects($this->any())->method('getException')->willReturn($this->exception);

        return $consoleException;
    }
}
