<?php
declare(strict_types = 1);


namespace SM\AirbrakeBundle\Builder;

/**
 * User for ensuring a contract for class builders.
 *
 * @package SM\AirbrakeBundle\Builder
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 */
interface BuilderInterface
{
    /**
     * Builds a new instance of a class with the
     * parameters that have been provided.
     */
    public function build();

    /**
     * Clears the value of all parameters
     * that have been provided to the builder.
     */
    public function clear();
}
