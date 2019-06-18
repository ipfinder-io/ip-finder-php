<?php 
require  'vendor/autoload.php';
$data  = include 'data.php';

use ipfinder\ipfinder\IPfinder;

// Token
$client = new IPfinder('aac6070563e0d42ef5ca94fdc2b55fdd7546d7d6'); // YOUR_TOKEN_GOES_HERE

$asn = 'as1'; // as36947
// $asn = 'ssss';
// lookup Asn information
//$details = $client->getFirewall($asn,'nginx_deny');

$details = $client->getFirewall($asn,'nginx_deny');

var_dump($details);


