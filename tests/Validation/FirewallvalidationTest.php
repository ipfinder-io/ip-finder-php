<?php
namespace ipfinder\Test\Firewallvalidation;

use ipfinder\ipfinder\Validation\Firewallvalidation;
use ipfinder\ipfinder\Exception\IPfinderException;


use PHPUnit\Framework\TestCase;

/**
 * Firewall validation input and format
 * @package ipfinder\Test\Firewallvalidation
 */
class FirewallvalidationTest extends TestCase
{
    /**
     * Positive Firewall
     * @return array
     */
    public static function positiveProvider()
    {
        return array(
            array("DZ", "juniper_junos"),
            array("as99", "peer_guardian_2"),
            array("TN", "cisco_bit_bucket"),
            array("MA", "microtik"),
            array("as99", "linux_iptables"),
            array("US", "nginx_allow")
        );
    }
    /**
     * invalid Firewall
     * @return array
     */
    public static function invalidProvider()
    {
        return array(
            array("4584", "zxczxcs"),
            array("tn", "sadsa"),
            array("na", "dsfewfds"),
            array("As11", "dfdvcx"),
            array("152", "asdasd"),
            array("USs", "adsd")
        );
    }

    /**
     * Test Firewall validation
     * @param  string $input
     * @param  string $format
     * @return bool
     * @dataProvider positiveProvider
     */
    public function testValidate(string $input, string $format)
    {
        $this->assertTrue(Firewallvalidation::validate($input, $format));
    }
    /**
     * Test Firewall validation Exception
     * @param  string $input
     * @param  string $format
     * @return bool
     * @dataProvider invalidProvider
     */
    public function testValidateException(string $input, string $format)
    {
        $this->expectException(IPfinderException::class);
        Firewallvalidation::validate($input, $format);
    }
}
