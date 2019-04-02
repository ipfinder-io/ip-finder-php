<?php
namespace ipfinder\ipfinder;

use ipfinder\ipfinder\Exception\IPfinderException;
use ipfinder\ipfinder\Info;
use ipfinder\ipfinder\Validation\Asnvalidation;
use ipfinder\ipfinder\Validation\Ipvalidation;

const DEFAULT_BASE_URL  = "http://api.sample.com/v1/"; // or add proxy pass with your domain
const DEFAULT_API_TOKEN = "free"; // The free token is limited to 4,000 requests a day for all 
const FORMAT            = 'json';

/**
 * the IPinfo library to client code.
 */
class IPfinder
{
    private $baseUrl;
    private $token;
    private $format;
    private static $defaultBaseUrl = DEFAULT_BASE_URL;
    private static $defaultToken   = DEFAULT_API_TOKEN;
    private static $defaulFormat   = FORMAT;

    public function __construct(string $token = null, string $baseUrl = null)
    {

        if (isset($token)) 
        //  Tokenvalidation::validate($token);
            $this->token = $token;
         else 
            $this->token = self::$defaultToken;
        
        if (isset($baseUrl)) 
            $this->baseUrl = $baseUrl;
         else 
            $this->baseUrl = self::$defaultBaseUrl;
        
    }

    /**
     *  get details for a specific asn, IP address, ranges, Firewall,Token status
     *  @param  string $path asn, IP address, ranges, Firewall
     *  @param  string $format json,list Firewall formats supported
     *  @return data body
     *  @throws IPfinderException
     **/
    public function call(string $path = null, string $format = null)
    {

        if (isset($format)) 
            $this->format = $format;
         else 
            $this->format = self::$defaulFormat;
        

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
                    throw new IPfinderException('usage_limit_reached');
                    break;
                case 105:
                    throw new IPfinderException('function_access_restricted');
                    break;
                case 401:
                    throw new IPfinderException('Unauthorized Your API key is wrong');
                    break;
                case 402:
                    throw new IPfinderException('non_paymant');
                    break;
                case 403:
                    throw new IPfinderException('Forbidden');
                    break;
                case 404:
                    throw new IPfinderException('Not Found');
                    break;
                case 500:
                    throw new IPfinderException('Internal Server Error');
                    break;
                default:
                    throw new IPfinderException('curl error');
                    break;
            }
        }
        if (isset($format)) 
            return $this->raw_body;
         else 
            return new Info($this->response);
        
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
        return $this->call('info');
    }
    /**
     * Get details for an Organization name.
     * @param string $path Organization name.
     * @return Organization name data.
     */
    public function getRanges(string $path)
    {
        $this->urlencode = rawurlencode($path);

        return $this->call('ranges/' .  $this->urlencode);
    }
    /**
     * Get details for an IP address.
     * @param string $path AS number, alpha-2 country only.
     * @param string $formats list formats supported
     * @return Firewall data.
     */
    public function getFirewall(string $path, string $formats)
    {
        return $this->call('firewall/' . $path, $formats);
    }
}
