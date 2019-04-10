<?php
namespace ipfinder\ipfinder\Validation;

use ipfinder\ipfinder\Exception\IPfinderException;

/**
 *  class Ipvalidation
 */
class Ipvalidation
{

    /**
     * Helper method for validating an argument if it is (IPV4|IPV6) IP address
     *
     *@param $argument     mixed The object to be validated
     */
    public static function validate($argument)
    {
        if (!filter_var($argument, FILTER_VALIDATE_IP)) {
            throw new IPfinderException('Invalid IPaddress');
        }
        return true;
    }
}
