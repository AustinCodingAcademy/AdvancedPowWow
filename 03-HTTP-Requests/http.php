<?php

// First, include Requests
include('./Requests/library/Requests.php');

// Next, make sure Requests can load internal classes
Requests::register_autoloader();

$response = Requests::get('https://httpbin.org/get');

$json = $response->body;
$data = json_decode($json);  // The actual data representation of the JSON string

//echo "The host was " . $data['headers']['Host'];
echo "The host was " . $data->headers->Host;


?>
