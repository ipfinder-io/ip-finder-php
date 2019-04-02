<?php 
require  'vendor/autoload.php';

use ipfinder\ipfinder\IPfinder;

// Token
$client = new IPfinder('YOUR_TOKEN_GOES_HERE');


// lookup your IP address information

$details = $client->Authentication();

var_dump($details);