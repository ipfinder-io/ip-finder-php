<?php
namespace ipfinder\ipfinder\Validation;

use ipfinder\ipfinder\Exception\IPfinderException;

/**
 *  class Tokenvalidation
 */
class Tokenvalidation
{

    /**
     * Helper method for validating an IPFINDER TOKEN string
     *
     * @param mixed     $argument
     */
    public static function validate($argument)
    {
        if (strlen($argument) <= 25) {
            throw new IPfinderException('Invalid Token');
        }
        return true;
    }
}
