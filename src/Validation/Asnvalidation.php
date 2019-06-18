<?php
namespace ipfinder\ipfinder\Validation;

use ipfinder\ipfinder\Exception\IPfinderException;

/**
 *  class Asnvalidation
 */
class Asnvalidation
{

    /**
     * Helper method for validating an argument if it is asn number
     *
     * @param $argument     mixed The object to be validated
     */
    public static function validate($argument)
    {
        if (!filter_var($argument, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^(as|AS)(\d+)$/")))) {
            throw new IPfinderException('Invalid asn number ');
        }
        return true;
    }
}
