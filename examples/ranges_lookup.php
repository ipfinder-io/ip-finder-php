<?php
require  'vendor/autoload.php';

use ipfinder\ipfinder\IPfinder;

// Token
$client = new IPfinder('aac6070563e0d42ef5ca94fdc2b55fdd7546d7d6'); // YOUR_TOKEN_GOES_HERE

// Organization name
$org = 'Telecom Algeria';

// lookup Organization information
$details = $client->getRanges($org);

var_dump($client);

// print Organization name url encode
echo $client->urlencode;
