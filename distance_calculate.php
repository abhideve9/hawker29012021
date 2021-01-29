<?php
/*$address = 'BTM 2nd Stage,Bengaluru,Karnataka,560076';
$encode = urlencode($address);
$key = "AIzaSyChKniIN58_YEQOlqOTdzFjY7o8hLqKaX8";
$url = "https://maps.googleapis.com/maps/api/geocode/json?address={$encode}&key={$key}";
print_r($url);
die();
$json = file_get_contents($url);
$data = json_decode($json);
print_r($data);
die();

echo ($data->results[0]->geometry->location->lat);    */

$address = "Tower A, 808, Sohna Rd, Sector 48, Gurugram, Haryana 122018";
$address = str_replace(" ", "+", $address);
$region = "India";
$key = "AIzaSyBFopKombxX7GqBDEh4eo0RTgEtxkANLis";
$json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=true&region=$region&key={$key}");

$json = json_decode($json);

$lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
$long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
echo $lat."</br>".$long;
?>