<?php
namespace ipfinder\ipfinder\Validation;

use ipfinder\ipfinder\Exception\IPfinderException;

/**
 *  class Ipvalidation
 */
class Domainvalidation
{

    /**
     * Helper method for validating domain name
     * @see   https://stackoverflow.com/questions/10306690/what-is-a-regular-expression-which-will-match-a-valid-domain-name-without-a-subd
     * @see   https://stackoverflow.com/questions/11809631/fully-qualified-domain-name-validation/20204811
     * @param $argument     mixed The object to be validated
     * @return bool
     */
    public static function validate($argument)
    {
        if (!filter_var($argument, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^(?!\-)(?:[a-zA-Z\d\-]{0,62}[a-zA-Z\d]\.){1,126}(?!\d+)[a-zA-Z\d]{1,63}$/")))) {
            throw new IPfinderException("\e[0;37;41mInvalid Domain name \e[0m");
        }
        return true;
    }
}
