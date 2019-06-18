<?php 
require  'vendor/autoload.php';
$data  = include 'data.php';

use ipfinder\ipfinder\IPfinder;

// Token
$client = new IPfinder('aac6070563e0d42ef5ca94fdc2b55fdd7546d7d6'); // YOUR_TOKEN_GOES_HERE

$asn = $data['asn']; // as36947

// lookup Asn information
$details = $client->getAsn($asn);

var_dump($details);


// get and print continent name  
echo $details->continent_name."\n"; 

// get and print speed
echo $details->speed['ping']."\n"; 