<?php 
require  'vendor/autoload.php';
$data  = include 'data.php';

use ipfinder\ipfinder\IPfinder;

// Token
$client = new IPfinder('ent'); // YOUR_TOKEN_GOES_HERE

$ip_address = $data['ip_address']; // 216.239.36.21

// lookup IP address information

$details = $client->getAddressInfo($ip_address);

var_dump($client);