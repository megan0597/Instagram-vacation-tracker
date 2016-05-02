<?php

// include keys
require_once "settings.php";
$instagramApiUrl = 'https://api.instagram.com/v1/';


// query string with default parameter (client_id)
$queryString = array(
    "client_id" => INSTAGRAM_CLIENT_ID,
    "q" => "1755076463",
);

// method I use to get my data
$methods = array(
    "users/@replace/media/recent",
);

// array which contains the data
$myData = [];

// Users media
//https://api.instagram.com/v1/users/1755076463/media/recent/?client_id=2ab050e5d05543eba938edc078eeb5cd

// dit moet ik gebruiken anders geeft mijn php een fout
$arrContextOptions = array(
    "ssl" => array(
        "verify_peer" => false,
        "verify_peer_name" => false,
    ),
);

$method = str_replace("@replace", "1755076463", $methods[0]);
$data = json_decode(file_get_contents($instagramApiUrl . $method . "?" . http_build_query($queryString), false, stream_context_create($arrContextOptions)));
                                                                                                       // dit stuk hoort bij hetgene hierboven
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
