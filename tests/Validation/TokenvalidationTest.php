<?php
namespace ipfinder\Test\Tokenvalidation;

use ipfinder\ipfinder\Validation\Tokenvalidation;
use ipfinder\ipfinder\Exception\IPfinderException;

use PHPUnit\Framework\TestCase;

/**
 * IPFINDER API Token validation
 * @package ipfinder\Test\Tokenvalidation
 */
class TokenvalidationTest extends TestCase
{

    public static function positiveProvider()
    {
        return array(
            array("asddddddddddddddddddasdasddddddddddddd"),
            array("sdv45vb44tby48s4be56brs8444bt44b5a4btrae6bae425"),
            array("ntyunynuytnutyntyuntyfaesre4554v5r"),
            array("dfgsdfgsadrbytybtuyunytunytunytun")
        );
    }

    public static function invalidProvider()
    {
        return array(
            array("sdfdsv484dsf"),
            array("asdasdasd54s5df"),
            array("asdasd585da55asdasdasdda"), //24
            array("sdvc44dsf4")
        );
    }

    /**
     * @dataProvider positiveProvider
     */
    public function testValidate($input)
    {
        $this->assertTrue(Tokenvalidation::validate($input, "Test token Value"));
    }
    /**
     * @dataProvider invalidProvider
     */

    public function testValidateException($input)
    {
        $this->expectException(IPfinderException::class);
        $this->expectExceptionMessage('Invalid IPFINDER API Token');
        Tokenvalidation::validate($input, "Test token Value");
    }
}
