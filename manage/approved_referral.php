<?php
include_once 'db.php';
require_once'firebase.php';
require_once 'push.php';
require_once 'config.php';
	if(isset($_REQUEST['mobile_no']))
	{
	$status=1;
	$mobile_no=$_REQUEST['mobile_no'];
	mysqli_query($db,"UPDATE registration_sellers SET  referral_status ='$status' WHERE mobile_no_contact='".$_REQUEST['mobile_no']."'");

	$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://2factor.in/API/V1/c43867a9-ba7e-11e9-ade6-0200cd936042/ADDON_SERVICES/SEND/TSMS",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "{\"From\": \"HAWKER\",\"To\": \"".$mobile_no."\",\"TemplateName\": \"Trans_SMS_2\", \"Msg\": \"Cngratulation\", \"SendAt\": \"\"}",
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}

	 $getUsers="SELECT notification_id FROM login_manage_seller where mobile_no='".$_REQUEST['mobile_no']."'";
	  $runUsers=mysqli_query($db,$getUsers);
	  $rowUsers=mysqli_fetch_array($runUsers);
	  $notification_id=$rowUsers['notification_id'];
	    $firebase = new Firebase();
        $push = new Push();
        // optional payload
        $payload = array();
        $payload['team'] = 'India';
        $payload['score'] = '5.6';
        // notification title
        $title ='Hawkers';
        
        // notification message
        $message ='Congratulations! Now you can avail referral and earn facility.';
        
        // push type - single user / topic
        $push_type = 'individual';
        
        // whether to include to image or not
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
	 ?>
	<script>
	alert("You Have successfully activate hawker for referral");
	location.href="seller.php?action=seller_user_referral";
    </script>
     <?php
    
  
  
   ?>
   
  
	

