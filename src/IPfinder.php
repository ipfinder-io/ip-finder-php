<?php namespace ipfinder\ipfinder;
/**
 *
 * All rights reserved.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package   ipfinder
 * @author    Mohamed Benrebia <mohamed@ipfinder.io>
 * @copyright 2019 Mohamed Benrebia
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
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
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
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
       //   Tokenvalidation::validate($token);
            $this->token = $token;
        }

         else {
             $this->token = self::$defaultToken;
         }
           
        
        if (isset($baseUrl)) {
            $this->baseUrl = $baseUrl;
        }
         else {
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
     * Get Firewall data
     * @param string $path     AS number, alpha-2 country only.
     * @param string $formats  list formats supported
     * @return Firewall data.
     * @throws IPfinderException
     */
    public function getFirewall(string $path, string $formats)
    {
        Firewallvalidation::validate($path,$formats);
        return $this->call('firewall/' . $path, $formats);
    }
    /**
     * [getDomain description]
     * @param  string $path The API supports passing in a single website name domain name
     * @return Domain to IP data.
     * @throws IPfinderException
     */
    public function getDomain(string $path) 
    {
        Domainvalidation::validate($path);
        return $this->call('domain/' .$path);
    }
    /**
     * [getDomainHistory description]
     * @param  sting  $path The API supports passing in a single website name domain name
     * @return Domain History data.
     * @throws IPfinderException
     */
    public function getDomainHistory(sting $path)
    {
        Domainvalidation::validate($path);
        return $this->call('domainhistory/' .$path);
    }
    /**
     * [getDomainBy description]
     * @param  string $by The API supports passing in a single ASN,Country,Ranges
     * @return Get list Domain By ASN, Country,Ranges
     */
    public function getDomainBy(string $by)
    {
        return $this->call('domainby/' .$by);
    }
}
