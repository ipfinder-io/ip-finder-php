<?php 
require  'vendor/autoload.php';
$data  = include 'data.php';

use ipfinder\ipfinder\IPfinder;

// Token
$client = new IPfinder('ent'); // YOUR_TOKEN_GOES_HERE

$asn = 'as1'; // as36947

// lookup Asn information
$details = $client->getFirewall($asn,'nginx_deny');

var_dump($details);


