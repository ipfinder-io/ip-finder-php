<?php
require  'vendor/autoload.php';
$data  = include 'data.php';

use ipfinder\ipfinder\IPfinder;

// Token
$client = new IPfinder('f67f788f8a02a188ec84502e0dff066ed4413a85'); // YOUR_TOKEN_GOES_HERE

$asn = 'as1'; // as36947
// $asn = 'ssss';
// lookup Asn information
//$details = $client->getFirewall($asn,'nginx_deny');

$details = $client->getFirewall($asn, 'nginx_deny');

var_dump($details);
