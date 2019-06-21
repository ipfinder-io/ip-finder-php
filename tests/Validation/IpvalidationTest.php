<?php
namespace ipfinder\Test\Ipvalidation;

use ipfinder\ipfinder\Validation\Ipvalidation;
use ipfinder\ipfinder\Exception\IPfinderException;

use PHPUnit\Framework\TestCase;

/**
 * IP4,IPV6 validation
 * @package ipfinder\Test\Ipvalidation
 */
class IpvalidationTest extends TestCase
{
    public static function positiveProvider()
    {
        return array(
            array("1.0.0.0", "127.0.0.1"),
            array("14.22.54.55", "2c0f:fb50:4003::")
        );
    }

    public static function invalidProvider()
    {
        return array(
            array("127..0.0.1"),
            array('8.8.8.8.8.8'),
            array('NULL'),
            array("1c0f::fb50::4003::")
        );
    }

    /**
     *
     * @dataProvider positiveProvider
     */
    public function testValidate($input)
    {
        $this->assertTrue(Ipvalidation::validate($input, "Test IP Value"));
    }
    /**
     *
     * @dataProvider invalidProvider
     */
    public function testValidateException($input)
    {
        $this->expectException(IPfinderException::class);
        $this->expectExceptionMessage('Invalid IPaddress');
        Ipvalidation::validate($input, "Test IP Value");
    }
}
