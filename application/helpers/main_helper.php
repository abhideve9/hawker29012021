<?php
defined('BASEPATH') OR exit('No direct script access allowed');
function json_output($data)
{
    $ci = & get_instance();
    $ci->output->set_status_header(200)->set_content_type(CONTENT_TYPE_JSON,'utf-8')->set_output(json_encode($data,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))->_display();
    exit;
    
}

function calculateDistance($lat1, $lon1, $lat2, $lon2) {
  if (($lat1 == $lat2) && ($lon1 == $lon2)) {
     return 0;
  }
  else {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    return (round($miles * 1.609344*1000,2));
  }
}
function calculateDistanceNew($lat1, $lon1, $lat2, $lon2) {
  if (($lat1 == $lat2) && ($lon1 == $lon2)) {
     return 0;
  }
  else {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    return (round($miles * 1.609344,2));
  }

}
function txnLogs($payment_id,$hawker_code,$payment_status,$amount,$plan_type,$device_id,$ads_id)
{
    date_default_timezone_set('Asia/kolkata');
    $ci=& get_instance();
    $ci->load->database();
    $logArray=array(
                    'payment_id'        =>$payment_id,
                    'payment_status'    =>$payment_status,
                    'amount'            =>$amount,
                    'plan_type'         =>$plan_type,
                    'hawker_code'       =>$hawker_code,
                    'device_id'         =>$device_id,
	            'ads_id'            =>$ads_id,
                    'created_on'        =>date('Y-m-d H:i:s')
                );
    $ci->db->insert('ads_payment_logs', $logArray);
}
function pushNotification($notification_id,$clicks,$searchedCat,$totalCalls)
{

     $firebase = new Firebase();
     $push = new Push();
     $payload = array();
     $payload['team'] = 'India';
     $payload['score'] = '5.6';
    // notification title
     $title ='Hawkers';
     //$message ='Total calls:'.$totalCalls.' Total clicks:'.$clicks.' Total searched category:'.$searchedCat;
     //$message ="Your Today's Adv.clicks-calls-searches:".$clicks."-".$totalCalls."-".$searchedCat;
     $message ="Your Adv.clicks\calls\searches today:".$clicks."\ ".$totalCalls."\ ".$searchedCat;
     $push_type = 'individual';
     $include_image = 'http://api.androidhive.info/images/minion.jpg' ? TRUE : FALSE;
     $push->setTitle($title);
     $push->setMessage($message);
     if ($include_image) {
        $push->setImage('http://api.androidhive.info/images/minion.jpg');
    } else {
        $push->setImage('');
    }
    $push->setIsBackground(FALSE);
    $push->setPayload($payload);
    $json = '';
    $response = '';

    if ($push_type == 'topic') {
        $json = $push->getPush();
        $response = $firebase->sendToTopic('global', $json);
    } else if ($push_type == 'individual') {
        $json = $push->getPush();
        $regId = $notification_id;
        $response = $firebase->send($regId, $json);
    }
}
function logErr($data,$file){
  $logPath = __DIR__. "/../$file";
  $mode ='a';
  $logfile = fopen($logPath, $mode);
  fwrite($logfile, "\r\n". $data);
  fclose($logfile);
}

?>