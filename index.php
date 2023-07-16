<?php

require_once __DIR__ . '/vendor/autoload.php';

use Salesforce\SalesforceConfig;
use Salesforce;

$client_id     = '';
$client_secret = '';
$domain        = '';
$redirect_uri  = '';

try
{
    $salesforce = new Salesforce(new SalesforceConfig($domain, $client_id, $client_secret, $redirect_url));
}
catch(\Exception $e)
{
    file_put_contents('errors.txt', "[" . date('Y-m-d H:i:s') . "]: " . $e->getMessage() . PHP_EOL, FILE_APPEND);
    die('Something gone wrong: ' . $e->getMessage() . ' -- Date: ' . date('Y-m-d H:i:s'));
}


