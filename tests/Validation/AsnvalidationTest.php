<?php
namespace ipfinder\Test\Asnvalidation;

use ipfinder\ipfinder\Validation\Asnvalidation;
use ipfinder\ipfinder\Exception\IPfinderException;

use PHPUnit\Framework\TestCase;

/**
 * Asn number validation
 * @package ipfinder\Test\Asnvalidation
 */
class AsnvalidationTest extends TestCase
{

    public static function positiveProvider()
    {
        return array(
            array("as1"),
            array("AS99"),
            array("AS66"),
            array("as99")
        );
    }

    public static function invalidProvider()
    {
        return array(
            array("SA44"),
            array("444"),
            array("aS77"),
            array("As96")
        );
    }

    /**
     *
     * @dataProvider positiveProvider
     */
    public function testValidate($input)
    {
        $this->assertTrue(Asnvalidation::validate($input, "test asn"));
    }
    /**
     *
     * @dataProvider invalidProvider
     */

    public function testValidateException($input)
    {
        $this->expectException(IPfinderException::class);
        $this->expectExceptionMessage('Invalid asn number');
        Asnvalidation::validate($input, "test asn");
    }
}
