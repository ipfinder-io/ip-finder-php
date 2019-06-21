<?php
namespace ipfinder\ipfinder;

/**
 * Holds array data form call
 */
class Info
{
    /**
     * Constructor
     * @param array $Array call array
     */
    public function __construct(array $Array)
    {
        foreach ($Array as $property => $value) {
            $this->$property = $value;
        }
    }
}
