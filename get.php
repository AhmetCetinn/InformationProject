<?php

header('Access-Control-Allow-Origin: *');

if (!empty($_GET['ship']))
	$ship = $_GET['ship'];

$url = 'http://maac.xyz/webServiceLayer/request.php?ship=' . $ship;

//  Initiate curl
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL,$url);
$result=curl_exec($ch);
curl_close($ch);

print_r(json_decode($result, true));