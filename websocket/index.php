<?php
error_reporting(E_ALL);
//Make sure that the content type of the POST request has been set to application/json
try{
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

}catch  (Exception $e) { 
        echo 'Caught Exception: ',  $e->getMessage(), "\n"; 
    } 
 
//print_r($_POST);
//echo $_SERVER['REQUEST_METHOD'];
//Receive the RAW post data.
$content = trim(file_get_contents("php://input"));
$mpower=-43;
$myfile = fopen("raw_data.txt", "w") or die("Unable to open file!");
fwrite($myfile, $content);
fclose($myfile);

	if (function_exists('date_default_timezone_set'))
	{
	date_default_timezone_set('Asia/Kolkata');
	}
$con = mysqli_connect("localhost", "root", "", "school");
$jsondata = file_get_contents('raw_data.txt');
$json_decode = json_decode($jsondata,true);
//print_r($json_decode);

$gateway_id= $json_decode['route_mac'];
$logfile = file_put_contents("data_log.txt", $content, FILE_APPEND | LOCK_EX);
foreach($json_decode['devices'] as $result){
	$id_card= $result['mac'];
	$data= $result['data'];
	$rssi=$result['rssi'];
	$distance= round(pow(10,(($mpower-$rssi)/25)),2);
	 $sql="insert into raw_records set id_card='".$id_card."', gateway_id='".$gateway_id."', rssi='".$rssi."', distance='".$distance."', time='".date('Y-m-d H:i:s')."', date_time='".date('Y-m-d H:i:s')."'  ";
	
	$insert=mysqli_query($con,$sql);
	
	}
