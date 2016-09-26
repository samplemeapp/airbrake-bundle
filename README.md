# SampleMe Airbrake Bundle

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Our Airbrake bundle enables development teams to quickly add support for error/exception reporting via [airbrake.io](https://airbrake.io/) or [errbit.com](https://github.com/errbit/errbit), for their PHP7 packages and projects built on Symfony 2.8+.

The bundle supports a number of customisation parameters, PSR-4 autoloading, is PSR-2 compliant and has been well tested through automated tests, as well as being used in various microservices within the SampleMe ecosystem.

## Install

Via Composer

``` bash
$ composer require samplemeapp/airbrake-bundle
```

Enable the bundle in your AppKernel, present in: `app/AppKernel.php`.

``` php
$bundles = [
    new SM\AirbrakeBundle\SMAirbrakeBundle(),
]
```

## Configuration

In order to start reporting all exceptions to [airbrake.io](https://airbrake.io/), add the following configuration to your `app/config/config.yml`:
  
``` yml
sm_airbrake:
    project_id: 'your-project-id'
    project_key: 'your-project-key'
    listener_enabled: true
```

## Usage

If you want to manually interact with the Airbrake service, it is also exposed as a container service:
 
``` php
$exception = new \Exception('Something went wrong');
$container->get('sm_airbrake.airbrake.service')->notify($exception);
```

One use case in which you may want to follow the approach above is if you do not want the listener to trigger on every exception, or if you want to add your own business logic to when the service is called.

For more API information, see `SM\AirbrakeBundle\Service\AirbrakeService`.

## Configuration Reference

The following configuration parameters are also available for the bundle:

``` yml
sm_airbrake:
    # The ID of the project.
    project_id: string #project-id
    
    # The key of the project.
    project_key: string #project-key
    
    # The HTTP client to use in order to contact the host.
    # Defaults to 'default'.
    http_client: string #default/curl/guzzle/
    
    # Whether or not to register a global exception instance, retrievable via Instance::notify($e);
    # Defaults to false.
    global_exception_instance: boolean #true/false
    
    # Whether or not to register a global error and exception handler.
    # Defaults to false.
    global_error_and_exception_handler: boolean #true/false
    
    # The host to which the bundle should connect.
    # Defaults to 'api.airbrake.io'.
    host: string #api.airbrake.io/errbit.internal
    
    # Exception class paths that should be ignored. Useful for not overloading your logs.
    # Defaults to [].
    ignored_exceptions:
        - "Symfony\Component\HttpKernel\Exception\HttpException"
        - "Symfony\Component\Security\Core\Exception\AccessDeniedException"
        
    # The root directory that should be reported to the host
    # Defaults to the 'kernel.root_dir' parameter
    root_directory: string
    
    # The environment that should be reported to the host
    # Defaults to 'undefined'
    environment: string 
    
    # The app version that should be reported to the host
    # Defaults to 'undefined' or the value in the /VERSION file present in the root directory of the project.
    app_version: string
    
    # Enables or disables the 'kernel.exception' event listener.
    # Defaults to false.
    listener_enabled: boolean #true/false
```

## Testing

``` bash
$ composer test
```

## PSR-2 Compatibility

``` bash
$ composer check-styles
$ composer fix-styles
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email petre@dreamlabs.ro instead of using the issue tracker.

## Credits

- [Petre Pătrașc][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/samplemeapp/airbrake-bundle.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/samplemeapp/airbrake-bundle/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/samplemeapp/airbrake-bundle.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/samplemeapp/airbrake-bundle.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/samplemeapp/airbrake-bundle.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/samplemeapp/airbrake-bundle
[link-travis]: https://travis-ci.org/samplemeapp/airbrake-bundle
[link-scrutinizer]: https://scrutinizer-ci.com/g/samplemeapp/airbrake-bundle/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/samplemeapp/airbrake-bundle
[link-downloads]: https://packagist.org/packages/samplemeapp/airbrake-bundle
[link-author]: https://github.com/petrepatrasc
[link-contributors]: ../../contributors
