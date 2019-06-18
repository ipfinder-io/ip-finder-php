<?php 
require  'vendor/autoload.php';

use ipfinder\ipfinder\IPfinder;

// Token
$client = new IPfinder('b58aede30772d0b64cf5025a72a1d98ecd6e8292'); 

// domain name
$by = 'DZ';

// lookup Organization information
$details = $client->getDomainBy($by);

var_dump($details);
