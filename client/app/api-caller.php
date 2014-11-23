<?php

$data = json_decode(file_get_contents('php://input'), true);

$curl = curl_init();
$request_uri = $_SERVER['REQUEST_URI'];

$url = "http://neartutor-service".substr($request_uri, 15);

//echo $url;

$options = array(
               CURLOPT_RETURNTRANSFER => 1,
               CURLOPT_URL => $url,
               CURLOPT_USERAGENT => 'Neartutor API Requests'
           );

if( $_SERVER['REQUEST_METHOD'] == 'POST')
{
    $options[CURLOPT_POST] = 1;
    $options[CURLOPT_POSTFIELDS] = $data;
}
curl_setopt_array($curl, $options);


// Send the request & save response to $resp
$resp = curl_exec($curl);
// Close request to clear up some resources
curl_close($curl);

echo $resp;
?>