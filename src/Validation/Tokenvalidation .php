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
        if (!filter_var($argument, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[0-9a-z]{35}$/")))) {
            throw new IPfinderException('Invalid Token');
        }
        return true;
    }
}
