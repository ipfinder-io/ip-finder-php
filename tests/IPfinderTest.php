<?php
namespace ipfinder\Test\IPfinder;

use ipfinder\ipfinder\IPfinder;
use ipfinder\ipfinder\Exception\IPfinderException;

use PHPUnit\Framework\TestCase;

/**
 *  IPFinder
 * @package ipfinder\Test\IPfinder
 */
class IPfinderTest extends TestCase
{

    public function testToken()
    {
          $token = 'asdasdasdasdasdsdasdasdasdasdasdasdasdasd';
          $api = new IPfinder($token);
          $this->assertSame($token, $api->token);
    }

    public function testFreeToken()
    {
          $token = 'free';
          $api = new IPfinder();
          $this->assertSame($token, $api::DEFAULT_API_TOKEN);
          $this->assertSame($token, $api->token);
    }

/*    public function testBadToken()
    {
          $token = 'a';
          $api = new IPfinder($token);
          $this->expectException(IPfinderException::class);
          $this->expectExceptionMessage('Invalid IPFINDER API Token');
    }*/


    public function testBaseUrl()
    {
          $url = 'https://api.ipfinder.io/v1/';
          $api = new IPfinder();
          $this->assertSame($url, $api->baseUrl);
    }

    public function testGetStatus()
    {
          $path = 'info';
          $api = new IPfinder();
          $this->assertSame($path, $api::STATUS_PATH);
    }

    public function testGetRanges()
    {
          $path = 'ranges/';
          $api = new IPfinder();
          $this->assertSame($path, $api::RANGES_PATH);
    }

    public function testGetFirewall()
    {
          $path = 'firewall/';
          $api = new IPfinder();
          $this->assertSame($path, $api::FIREWALL_PATH);
    }

    public function testGetDomain()
    {
          $path = 'domain/';
          $api = new IPfinder();
          $this->assertSame($path, $api::DOMAIN_PATH);
    }

    public function testGetDomainHistory()
    {
          $path = 'domainhistory/';
          $api = new IPfinder();
          $this->assertSame($path, $api::DOMAIN_H_PATH);
    }

    public function testGetDomainBy()
    {
          $path = 'domainby/';
          $api = new IPfinder();
          $this->assertSame($path, $api::DOMAIN_BY_PATH);
    }

    public function testAddress()
    {
        $ip = "1..0.0.0";
        $api = new IPfinder();
        $this->expectException(IPfinderException::class);
        $this->expectExceptionMessage('Invalid IPaddress');
        $api->getAddressInfo($ip);
    }


    public function testAsn()
    {
        $asn = "ip";
        $api = new IPfinder();
        $this->expectException(IPfinderException::class);
        $this->expectExceptionMessage('Invalid asn number');
        $api->getAsn($asn);
    }

    public function testDomain()
    {
        $domain = "fsdf";
        $api = new IPfinder();
        $this->expectException(IPfinderException::class);
        $this->expectExceptionMessage('Invalid Domain name');
        $api->getDomain($domain);
    }

    public function testFirewallFormat()
    {
        $asn = "as1";
        $api = new IPfinder();
        $this->expectException(IPfinderException::class);
        $this->expectExceptionMessage('Invalid Format supported format https://ipfinder.io/docs/?shell#firewall');
        $api->getFirewall($asn, 'ada');
    }

    public function testFirewallBy()
    {
        $country = "DZZ";  // country , ASN
        $api = new IPfinder();
        $this->expectException(IPfinderException::class);
        $this->expectExceptionMessage('Invalid Firewall string please use AS number or ISO 3166-1 alpha-2 country');
        $api->getFirewall($country, 'juniper_junos');
    }
}
