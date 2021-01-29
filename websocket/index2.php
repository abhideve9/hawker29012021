<?php
error_reporting(E_ALL);
//Make sure that the content type of the POST request has been set to application/json
try{
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

}catch (Exception $e) { 
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
$con = mysqli_connect("localhost", "root", "", "door_unlock");
$jsondata = file_get_contents('raw_data.txt');
$json_decode = json_decode($jsondata,true);
//print_r($json_decode);
$gateway_id= $json_decode['route_mac'];
$count=$json_decode['allCount'];
$logfile = file_put_contents("data_log.txt", $content, FILE_APPEND | LOCK_EX);
foreach($json_decode['devices'] as $result){
	$id_card1= $result['mac'];
        $id_card= str_replace(":","", $id_card1);
	//$data= $result['data'];
	$rssi=$result['rssi'];
        $battery=$result['battery'];
        if($battery ==''){
                $battery=0;
        }
	$distance= round(pow(10,(($mpower-$rssi)/25)),2);
	$sql="insert into raw_records_mw set id_card='".$id_card."', gateway_id='".$gateway_id."', rssi='".$rssi."', battery='".$battery."',distance='".$distance."', time='".date('Y-m-d H:i:s')."', date_time='".date('Y-m-d H:i:s')."',count='".$count."'";
    
	$myfile1 = fopen("log_test.txt", "w") or die("Unable to open file!");
        fwrite($myfile1, $sql);
        $logfile = file_put_contents("log_test.txt", $sql, FILE_APPEND | LOCK_EX);
        $insert=mysqli_query($con,$sql);
        }
