<?php

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../model/leads.php';

// init & execute curl
$ch = curl_init($INIT_URL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CAINFO, $CERTIFICATION_URL); // specify the path to the CA certificate bundle
$response = curl_exec($ch);

// check for curl errors
if (curl_errno($ch)) {
    var_dump('Curl error: ' . curl_error($ch));
}
curl_close($ch);

$dummyData = json_decode($response, true);


if (!isset($dummyData)) {
    return var_dump('Error decoding dummy data');
}

// iterating creation in database instead of batch, 
// because of the low data count, and should be only ran once
foreach ($dummyData as $dummyDatum) {
    $lead = [];

    // handling firstName and lastName (firstName is the first word, lastName the rest, in-case more than 2 strings)
    $names = explode(' ', $dummyDatum['name']);
    $lead['firstName'] = $names[0];

    unset($names[0]);
    $names = implode($names);
    $lead['lastName'] = $names;

    $lead['email'] = $dummyDatum['email'];
    $lead['phoneNumber'] = $dummyDatum['phone'];
    $lead['country'] = $dummyDatum['address']['city'];

    // randomize ip;
    $lead['ip'] = long2ip(rand(0, 255 * 255) * rand(0, 255 * 255));
    $lead['sub1'] = 'search engine';
    $lead['note'] = 'random information';

    // TODO add url when done in the front-end
    $lead['url'] = 'temp';

    // catching incase of an error (also validates that the data has been put in the DB, if data exists it won't be created cause of the unique email)
    try {
        $createdId = create_lead($lead);
        print_r($createdId);

    } catch (Exception $e) {
        var_dump($e->getMessage());
    }
}