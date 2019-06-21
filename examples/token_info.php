<?php
require  'vendor/autoload.php';

use ipfinder\ipfinder\IPfinder;

// Token
$client = new IPfinder('f67f788f8a02a188ec84502e0dff066ed4413a85'); // YOUR_TOKEN_GOES_HERE


// lookup IP address information

$details = $client->getStatus();

var_dump($details);

// get and print Number of IP address queries left for the day
echo $details->queriesLeft."\n";
