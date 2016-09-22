<?php
declare(strict_types = 1);


namespace SM\AirbrakeBundle\Enum;

/**
 * Holds default configuration values for Airbrake.
 *
 * @package SM\AirbrakeBundle\Enum
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 */
final class AirbrakeDefaultEnum
{
    const PROJECT_KEY = '';
    const PROJECT_ID = '';
    const HOST = 'api.airbrake.io';
    const HTTP_CLIENT = 'default';
    const GLOBAL_EXCEPTION_INSTANCE = false;
    const GLOBAL_ERROR_AND_EXCEPTION_HANDLER = false;
    const IGNORED_EXCEPTIONS = [];
    const ROOT_DIRECTORY = 'undefined';
    const ENVIRONMENT = 'undefined';
    const APP_VERSION = 'undefined';
}
