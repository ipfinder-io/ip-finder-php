<?php
namespace ipfinder\Test\Domainvalidation;

use ipfinder\ipfinder\Validation\Domainvalidation;
use ipfinder\ipfinder\Exception\IPfinderException;

use PHPUnit\Framework\TestCase;

/**
 * Domain validation
 * @package ipfinder\Test\Domainvalidation
 */
class DomainvalidationTest extends TestCase
{

    public static function positiveProvider()
    {
        return array(
            array("google.com", "facebook.com"),
            array("ipfinder.io", "twitter.io")
        );
    }

    public static function invalidProvider()
    {
        return array(
            array("#@%^%#$@#$@#.com"),
            array("あいうえお@example.com"),
            array("localhost"),
            array("شسييبيلقققل.سيب.يب")
        );
    }

    /**
     *
     * @dataProvider positiveProvider
     */
    public function testValidate($input)
    {
        $this->assertTrue(Domainvalidation::validate($input, "Test domain Value"));
    }
    /**
     *
     * @dataProvider invalidProvider
     */
    public function testValidateException($input)
    {
        $this->expectException(IPfinderException::class);
        $this->expectExceptionMessage('Invalid Domain name');
        Domainvalidation::validate($input, "Test domain Value");
    }
}
