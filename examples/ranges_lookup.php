<?php 
require  'vendor/autoload.php';

use ipfinder\ipfinder\IPfinder;

// Token
$client = new IPfinder('ent'); // YOUR_TOKEN_GOES_HERE

// Organization name
$org = 'Telecom Algeria';

// lookup Organization information
$details = $client->getRanges($org);

var_dump($client);

// print Organization name url encode  
echo $client->urlencode;
