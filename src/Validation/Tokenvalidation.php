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
     * @return bool
     */
    public static function validate($argument)
    {
        if (strlen($argument) <= 25) {
            throw new IPfinderException("\e[0;37;41mInvalid IPFINDER API Token\e[0m");
        }
        return true;
    }
}
