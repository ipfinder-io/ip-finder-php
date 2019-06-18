<?php 
require  'vendor/autoload.php';

use ipfinder\ipfinder\IPfinder;

// Token
$client = new IPfinder('aac6070563e0d42ef5ca94fdc2b55fdd7546d7d6'); // YOUR_TOKEN_GOES_HERE


// lookup your IP address information

$details = $client->Authentication();

var_dump($details);