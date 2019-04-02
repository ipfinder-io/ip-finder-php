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
        // if (!preg_match('/^[0-9a-z]{40}$/', $argument)) {
        //     throw new IPfinderException('Invalid Token.... ..... ........ ....');
        // }
        return true;
    }
}
