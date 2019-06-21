<?php namespace ipfinder\ipfinder;

/*
 * Copyright 2019 Mohamed Benrebia <mohamed@ipfinder.io>
 *
 * Licensed under the Apache License, Version 2.0 (the License);
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an AS IS BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package   ipfinder
 * @author    Mohamed Benrebia <mohamed@ipfinder.io>
 * @copyright 2019 Mohamed Benrebia
 * @license   https://opensource.org/licenses/Apache-2.0 Apache License, Version 2.0
 * @link      https://ipfinder.io
 */

use ipfinder\ipfinder\Exception\IPfinderException;
use ipfinder\ipfinder\Info;
use ipfinder\ipfinder\Validation\Asnvalidation;
use ipfinder\ipfinder\Validation\Ipvalidation;
use ipfinder\ipfinder\Validation\Tokenvalidation;
use ipfinder\ipfinder\Validation\Firewallvalidation;
use ipfinder\ipfinder\Validation\Domainvalidation;

/**
 * The IPfinder library main class.
 *
 * @package   ipfinder
 * @author    Mohamed Benrebia <mohamed@ipfinder.io>
 * @copyright 2019 Mohamed Benrebia
 * @license   https://opensource.org/licenses/Apache-2.0 Apache License, Version 2.0
 * @link      https://ipfinder.io
 * @version   1.0.1
 */

class IPfinder
{

    /**
     * DEFAULT BASE URL
     *
     * @var string
     */
    const DEFAULT_BASE_URL  = "https://api.ipfinder.io/v1/"; // or add proxy pass with your domain

    /**
     * The free token
     *
     * @var string
     */

    const DEFAULT_API_TOKEN = "free"; //  limited to 4,000 requests a day

    /**
     * DEFAULT FORMAT
     *
     * @var string
     */
    const FORMAT            = 'json';

    /**
     * @var string
     */
    const STATUS_PATH      = 'info';

    /**
     * @var string
     */
    const RANGES_PATH      = 'ranges/';

    /**
     * @var string
     */
    const FIREWALL_PATH      = 'firewall/';

    /**
     *
     * @var string
     */
    const DOMAIN_PATH      = 'domain/';

    /**
     * @var string
     */
    const DOMAIN_H_PATH      = 'domainhistory/';


    /**
     * @var string
     */
    const DOMAIN_BY_PATH      = 'domainby/';


    private static $defaultBaseUrl = self::DEFAULT_BASE_URL;


    private static $defaultToken   = self::DEFAULT_API_TOKEN;


    private static $defaulFormat   = self::FORMAT;

    /**
     * Constructor
     * @param string|null $token   add your token
     * @param string|null $baseUrl add proxy pass
     */
    public function __construct(string $token = null, string $baseUrl = null)
    {

        if (isset($token)) {
            Tokenvalidation::validate($token);
            $this->token = trim($token);
        } else {
            $this->token = self::$defaultToken;
        }


        if (isset($baseUrl)) {
            $this->baseUrl = $baseUrl;
        } else {
            $this->baseUrl = self::$defaultBaseUrl;
        }
    }

    /**
     *  get details for a specific asn, IP address, ranges, Firewall,Token status
     *  @param  string|null $path asn, IP address, ranges, Firewall
     *  @param  string|null $format json,list Firewall formats supported
     *  @return data body
     *  @throws IPfinderException
     **/
    public function call(string $path = null, string $format = null)
    {

        if (isset($format)) {
            $this->format = $format;
        } else {
            $this->format = self::$defaulFormat;
        }


        $curl = curl_init("{$this->baseUrl}{$path}");

        $request = json_encode(array(
            'token'  => $this->token,
            'format' => $this->format,
        ));

        $options = array(
        //  CURLOPT_HTTPAUTH       => CURLAUTH_BASIC,
        //  CURLOPT_USERPWD        => $this->token . ':' . '',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_HTTPHEADER     => array(
          //    'X-Authorization' :$this->token',
                'Content-type: application/json',
                'User-Agent: IPfinder php-client',
            ),
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $request,
        );

        curl_setopt_array($curl, $options);

        // get body
        $this->raw_body = curl_exec($curl);

        // to array
        $this->response = json_decode($this->raw_body, true);


        // get status
        $this->status = curl_getinfo($curl, CURLINFO_HTTP_CODE);


        $curl_error = curl_error($curl);

        if ($this->status != 200) {
            // API error codes: https://ipfinder.io/docs/#api
            switch ($this->status) {
                case 104:
                    throw new IPfinderException($this->status."\e[0;37;41m  You have reached your usage limit. Upgrade your plan if necessary. \e[0m\n"."\e[0;37;43m $this->raw_body \e[0m\n");
                    break;
                case 105:
                    throw new IPfinderException($this->status."\e[0;37;41m  function_access_restricted \e[0m\n"."\e[0;37;43m $this->raw_body \e[0m\n");
                    break;
                case 401:
                    throw new IPfinderException($this->status."\e[0;37;41m  Unauthorized Your API key is wrong \e[0m\n"."\e[0;37;43m $this->raw_body \e[0m\n");
                    break;
                case 402:
                    throw new IPfinderException($this->status."\e[0;37;41m  non_paymant \e[0m\n"."\e[0;37;43m $this->raw_body \e[0m\n");
                    break;
                case 403:
                    throw new IPfinderException($this->status."\e[0;37;41m  Forbidden \e[0m\n"."\e[0;37;43m $this->raw_body \e[0m\n");
                    break;
                case 404:
                    throw new IPfinderException($this->status."\e[0;37;41m  Not Found \e[0m\n"."\e[0;37;43m $this->raw_body \e[0m\n");
                    break;
                case 500:
                    throw new IPfinderException($this->status."\e[0;37;41m  Internal Server Error \e[0m\n"."\e[0;37;43m $this->raw_body \e[0m\n");
                    break;
                default:
                    throw new IPfinderException($this->status."\e[0;37;41m curl error \e[0m\n"."\e[0;37;43m $curl_error \e[0m\n");
                    break;
            }
        }
        if (isset($format)) {
            return $this->raw_body;
        } else {
            return new Info($this->response);
        }

        curl_close($curl);
    }
    /**
     * Get details for an Your IP address.
     * @return Your IP address data.
     */
    public function Authentication()
    {
        return $this->call();
    }
    /**
     * Get details for an IP address.
     * @param string $path IP address.
     * @return IP address data.
     * @throws IPfinderException
     */
    public function getAddressInfo(string $path)
    {

        Ipvalidation::validate($path);
        return $this->call($path);
    }
    /**
     * Get details for an AS number.
     * @param string $path AS number.
     * @return AS number data.
     * @throws IPfinderException
     */
    public function getAsn(string $path)
    {
        Asnvalidation::validate($path);
        return $this->call($path);
    }
    /**
     * Get details for an API Token .
     * @param string $path IP address.
     * @return The Token data.
     */
    public function getStatus()
    {
        return $this->call(self::STATUS_PATH);
    }
    /**
     * Get details for an Organization name.
     * @param string $path Organization name.
     * @return Organization name data.
     */
    public function getRanges(string $path)
    {
        $this->urlencode = rawurlencode($path);

        return $this->call(self::RANGES_PATH .  $this->urlencode);
    }
    /**
     * Get Firewall data
     * @param string $path     AS number, alpha-2 country only.
     * @param string $formats  list formats supported
     * @return Firewall data.
     * @throws IPfinderException
     */
    public function getFirewall(string $path, string $formats)
    {
        Firewallvalidation::validate($path, $formats);
        return $this->call(self::FIREWALL_PATH . $path, $formats);
    }
    /**
     * Get Domain IP
     * @param  string $path The API supports passing in a single website name domain name
     * @return Domain to IP data.
     * @throws IPfinderException
     */
    public function getDomain(string $path)
    {
        Domainvalidation::validate($path);
        return $this->call(self::DOMAIN_PATH .$path);
    }
    /**
     * Get Domain IP history
     * @param  sting  $path The API supports passing in a single website name domain name
     * @return Domain History data.
     * @throws IPfinderException
     */
    public function getDomainHistory(string $path)
    {
        Domainvalidation::validate($path);
        return $this->call(self::DOMAIN_H_PATH .$path);
    }
    /**
     * Get list Domain By ASN, Country,Ranges
     * @param  string $by The API supports passing in a single ASN,Country,Ranges
     * @return Get list Domain By ASN, Country,Ranges
     */
    public function getDomainBy(string $by)
    {
        return $this->call(self::DOMAIN_BY_PATH .$by);
    }
}
