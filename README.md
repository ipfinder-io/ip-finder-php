[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Fipfinder-io%2Fphp.svg?type=shield)](https://app.fossa.io/projects/git%2Bgithub.com%2Fipfinder-io%2Fphp?ref=badge_shield)
# <a href='https://ipfinder.io/'><img src='https://camo.githubusercontent.com/46886c3e689a0d4a3f6c0733d1cab5d9f9a3926d/68747470733a2f2f697066696e6465722e696f2f6173736574732f696d616765732f6c6f676f732f6c6f676f2e706e67' height='60' alt='IP Finder'></a>
#  IPFinder PHP Client Library

The official PHP client library for the [IPFinder.io](https://ipfinder.io) get details for :
-  IP address details (city, region, country, postal code, latitude and more ..)
-  ASN details (Organization name, registry,domain,comany_type, and more .. )
-  Firewall by supported formats details (apache_allow,  nginx_deny, CIDR , and more ..)
-  IP Address Ranges by the Organization name  details (list_asn, list_prefixes , and more ..)
-  service status details (queriesPerDay, queriesLeft, key_type, key_info)

## Getting Started
singing up for a free account at [https://ipfinder.io/auth/signup](https://ipfinder.io/auth/signup), for Free IPFinder API access token.

The free plan is limited to 4,000 requests a day, and doesn't include some of the data fields
To enable all the data fields and additional request volumes see [https://ipfinder.io/pricing](https://ipfinder.io/pricing).

## Documentation

See the [official documentation](https://ipfinder.io/docs).

## Installation

```shell
composer require ipfinder/ipfinder
```

## Authentication

```php

$client = new ipfinder\ipfinder\IPfinder('YOUR_TOKEN_GOES_HERE');

// lookup your IP address information
$details = $client->Authentication();

var_dump($details);

```

## Get IP address

```php
$client = new ipfinder\ipfinder\IPfinder('YOUR_TOKEN_GOES_HERE');

// GET Get details for 1.0.0.0
$ip_address = '1.0.0.0';

// lookup IP address information

$details = $client->getAddressInfo($ip_address);

var_dump($details);

```

## Get ASN
This API available as part of our Pro and enterprise [https://ipfinder.io/pricing](https://ipfinder.io/pricing).

```php
$client = new ipfinder\ipfinder\IPfinder('YOUR_TOKEN_GOES_HERE');

$asn = 'as36947';

// lookup Asn information
$details = $client->getAsn($asn);

var_dump($details);


// get and print continent name
echo $details->continent_name."\n";

// get and print speed
echo $details->speed['ping']."\n";

```

## Firewall
This API available as part of our  enterprise [https://ipfinder.io/pricing](https://ipfinder.io/pricing).
formats supported are :  `apache_allow`, `apache_deny`,`nginx_allow`,`nginx_deny`, `CIDR`, `linux_iptables`, `netmask`, `inverse_netmask`, `web_config_allow `, `web_config_deny`, `cisco_acl`, `peer_guardian_2`, `network_object`, `cisco_bit_bucket`, `juniper_junos`, `microtik`

```php
$client = new ipfinder\ipfinder\IPfinder('YOUR_TOKEN_GOES_HERE');

$asn = 'as36947';

// lookup Asn information
$details = $client->getFirewall($asn,'nginx_deny');

var_dump($details);

```

## Get IP Address Ranges
This API available as part of our  enterprise [https://ipfinder.io/pricing](https://ipfinder.io/pricing).
> Make sure to convert Organization name  into URL encoding
```php
$client = new ipfinder\ipfinder\IPfinder('YOUR_TOKEN_GOES_HERE');

// Organization name
$org = 'Telecom Algeria';

// lookup Organization information
$details = $client->getRanges($org);

var_dump($client);

// print Organization name url encode
echo $client->urlencode;


```

## Get service status

```php
$client = new ipfinder\ipfinder\IPfinder('YOUR_TOKEN_GOES_HERE');

// lookup IP TOKEN information

$details = $client->getStatus();

var_dump($details);

// get and print Number of IP address queries left for the day
echo $details->queriesLeft."\n";

```

## Get Domain IP


```php
use ipfinder\ipfinder\IPfinder;

// Token
$client = new IPfinder('YOUR_TOKEN_GOES_HERE');

// domain name
$name = 'google.com';

$details = $client->getDomain($name);

var_dump($details);

```

## Get Domain IP history



```php
use ipfinder\ipfinder\IPfinder;

// Token
$client = new IPfinder('YOUR_TOKEN_GOES_HERE');

// domain name
$name = 'google.com';

$details = $client->getDomainHistory($name);

var_dump($details);

```

## Get list Domain By ASN, Country,Ranges


```php
use ipfinder\ipfinder\IPfinder;

// Token
$client = new IPfinder('YOUR_TOKEN_GOES_HERE');

// list live domain by country DZ,US,TN,FR,MA
$by = 'DZ';

$details = $client->getDomainBy($by);

var_dump($details);

```

## Add proxy
```php
$client = new ipfinder\ipfinder\IPfinder('YOUR_TOKEN_GOES_HERE', 'https://ipfinder.yourdomain.com');

```

## Error handling

```php
$client = new IPfinder('YOUR_TOKEN_GOES_HERE');
try {
$by = 'DZ';

$details = $client->getDomainBy($by);

} catch (IPfinderException $e) {

print $e->getMessage();

}

```

## Contact

Contact Us With Additional Questions About Our API, if you would like more information about our API that isn’t available in our IP geolocation API developer documentation, simply [contact](https://ipfinder.io/contact) us at any time and we’ll be able to help you find what you need.

License
----

MIT
<a href="https://app.fossa.com/projects/git%2Bgithub.com%2Fipfinder-io%2Fphp?ref=badge_large" alt="FOSSA Status"><img src="https://app.fossa.com/api/projects/git%2Bgithub.com%2Fipfinder-io%2Fphp.svg?type=large"/></a>
