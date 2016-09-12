<?php

// include keys
require_once "settings.php";
$instagramApiUrl = 'https://api.instagram.com/v1/';


// query string with default parameter (client_id)
$queryString = array(
    "access_token" => INSTAGRAM_ACCESS_TOKEN
//    "q" => "17566509",
);

// method I use to get my data
$methods = array(
    "users/@replace/media/recent",
);

// array which contains the data
$myData = [];

// dit moet ik gebruiken anders geeft mijn php een fout
$arrContextOptions = array(
    "ssl" => array(
        "verify_peer" => false,
        "verify_peer_name" => false,
    ),
);

$method = str_replace("@replace", "1755076463", $methods[0]);
$data = json_decode(file_get_contents($instagramApiUrl . $method . "?" . http_build_query($queryString), false, stream_context_create($arrContextOptions)));

// filter the data to what is necessary
foreach ($data->data as $element){
    $myData[] = [
        'url' => $element->images->standard_resolution->url,
        'location' => [
            "latitude"=>$element->location->latitude,
            "longitude"=>$element->location->longitude
        ]
    ];
}

// this is so that your browser knows it's getting json
header('Content-Type: application/json');
echo json_encode($myData);
