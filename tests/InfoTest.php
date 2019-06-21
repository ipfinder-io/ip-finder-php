<?php
namespace ipfinder\Test\Info;

use ipfinder\ipfinder\Info;

use PHPUnit\Framework\TestCase;

/**
 * Info
 * @package ipfinder\Test\Info
 */
class InfoTest extends TestCase
{
    /**
     * Sample array tset
     * @return array
     */
    public static function getArray()
    {
        return array(
            "ip" => "216.239.36.21",
            "type" => "IPV4",
            "continent_code" => "NA",
            "continent_name" => "North America",
            "country_code" => "US",
            "country_name" => "United States",
            "country_native_name" => "United States",
            "region_name" => "California",
            "city" => "Mountain View",
            "latitude" => "37.4229",
            "longitude" => "-122.085",
        );
    }
    /**
     * Gets the array
     * @return Address
     */
    public static function getObject()
    {
        return new Info(self::getArray());
    }
    /**
     * @return string
     */
    public function testKey()
    {
        $info = self::getObject();
        $this->assertTrue(property_exists($info, 'ip'));
        $this->assertTrue(property_exists($info, 'type'));
        $this->assertTrue(property_exists($info, 'continent_code'));
        $this->assertTrue(property_exists($info, 'continent_name'));
        $this->assertTrue(property_exists($info, 'country_name'));
        $this->assertTrue(property_exists($info, 'country_native_name'));
        $this->assertTrue(property_exists($info, 'region_name'));
        $this->assertTrue(property_exists($info, 'city'));
        $this->assertTrue(property_exists($info, 'latitude'));
        $this->assertTrue(property_exists($info, 'longitude'));
    }
}
