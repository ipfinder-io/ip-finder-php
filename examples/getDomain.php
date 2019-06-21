<?php
require  'vendor/autoload.php';

use ipfinder\ipfinder\IPfinder;

// Token
$client = new IPfinder('f67f788f8a02a188ec84502e0dff066ed4413a85');

// domain name
$name = 'google.com';

// lookup Organization information
$details = $client->getDomain($name);

var_dump($details);
