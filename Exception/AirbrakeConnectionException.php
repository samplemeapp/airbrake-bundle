<?php
declare(strict_types = 1);


namespace SM\AirbrakeBundle\Exception;

/**
 * Signals errors that took place when communicating
 * with the Airbrake service. Can indicate invalid credentials,
 * lack of connectivity, etc.
 *
 * @package SM\AirbrakeBundle\Exception
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 */
class AirbrakeConnectionException extends AirbrakeException
{

}
