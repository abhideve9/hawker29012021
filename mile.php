<?php 
$address_customer = "Sohna Rd, Sector 50, Gurugram, Haryana 122018";
$address_branch="Tower A, 808, Sohna Rd, Sector 48, Gurugram, Haryana 122018";
$address_customer = str_replace(" ", "+", $address_customer);
$address_branch = str_replace(" ", "+", $address_branch);
$region = "India";
$key = "AIzaSyBFopKombxX7GqBDEh4eo0RTgEtxkANLis";
$json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address_customer&sensor=true&region=$region&key={$key}");
$json = json_decode($json);
$json1 = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address_branch&sensor=true&region=$region&key={$key}");
$json1 = json_decode($json1);
$lat1 = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
$long1 = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
$lat2 = $json1->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
$long2 = $json1->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
echo $lat1."</br>".$long1;
echo $lat2."</br>".$long2;
die();
$theta = $long1 - $long2;
$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
$dist = acos($dist);
$dist = rad2deg($dist);
$miles = $dist * 60 * 1.1515;
$kilometer=$miles * 1.609344;
//9.4930730546311E-5 km
//5.8987221219523E-5 miles

echo $kilometer;
?>