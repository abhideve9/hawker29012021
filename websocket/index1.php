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
$myfile = fopen("raw_data_mw.txt", "w") or die("Unable to open file!");
fwrite($myfile, $content);
fclose($myfile);

	if (function_exists('date_default_timezone_set'))
	{
	date_default_timezone_set('Asia/Kolkata');
	}
$con = mysqli_connect("localhost", "root", "", "door_unlock");
$jsondata = file_get_contents('raw_data_mw.txt');
$data = json_decode($jsondata,true);
$count= sizeof($data);
$count1=$count-1;
$myfile2 = file_put_contents("count_mw.txt",PHP_EOL.$count1,FILE_APPEND | LOCK_EX);
$mpower=-43;
$i=0;
//print_r($data);
if(is_array($data))
{
$gateway_id = $data[0]['mac'];
for($i=0;$i<=$count;$i++)	
{	
	if ($data[$i]['type']=="Gateway")
	{
	$gateway_id= $data[$i]['mac'];
//	$type=$data[$i]['type'];
	$myfile2 = file_put_contents("array_mw.txt",PHP_EOL .$count1 .  $gateway_id. $type,FILE_APPEND | LOCK_EX);
	}
       elseif($data[$i]['type']=='iBeacon')
	{
	$id_card= $data[$i]['mac'];
        $battery= $data[$i]['battery'];
        $rssi=$data[$i]['rssi'];
	$txpower=$data[$i]['ibeaconTxPower'];
	$distance= round(pow(10,(($mpower-$rssi)/25)),2);
	
	 $sql="insert into raw_records_mw set id_card='".$id_card."', gateway_id='".$gateway_id."', rssi='".$rssi."', battery='".$battery."',distance='".$distance."',time='".date('Y-m-d H:i:s')."', date_time='".date('Y-m-d H:i:s')."',count='".$count1."'  ";
	
	$insert=mysqli_query($con,$sql);
	$myfile4 = file_put_contents("stat_mw.txt",PHP_EOL.$sql. $count1,FILE_APPEND | LOCK_EX);
//	$i++;
}
}	
}
else
{
$myfile1 = file_put_contents("error_mw.txt","Not an Array",FILE_APPEND | LOCK_EX);
}
$logfile = file_put_contents("data_log_mw.txt", $content, FILE_APPEND | LOCK_EX);

