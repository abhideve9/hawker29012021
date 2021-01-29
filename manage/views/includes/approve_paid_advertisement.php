<?php
include 'db.php';
require_once 'firebase.php';
require_once 'push.php';
require_once 'config.php';
$adminid=$_SESSION['adminID'];
$adminName=$_SESSION['adminName'];
  if(isset($_REQUEST['id']))
  {
  $id=$_REQUEST['id'];
    //$message=$_REQUEST['message'];
    
     $UpdateQuery="UPDATE paid_advertisement_by_merchant SET aproval_status='1', modified_user_name='$adminName' WHERE id='".$_REQUEST['id']."'";
      $UpdateResult=mysqli_query($db,$UpdateQuery);
      if($UpdateResult)
      {
        $ssql=mysqli_query($db,"SELECT hawker_code FROM paid_advertisement_by_merchant WHERE id='$id'");
        $fetchsql=mysqli_fetch_assoc($ssql);
        $hawker_code=$fetchsql['hawker_code'];
        $ssql=mysqli_query($db,"SELECT notification_id FROM login_manage_seller WHERE user_id='$hawker_code' AND active_status=1");
        $fetchNotifiation=mysqli_fetch_assoc($ssql);
        $notification_id=$fetchNotifiation['notification_id'];
	 			 $firebase = new Firebase();
			         $push = new Push();
			         $payload = array();
			         $payload['team'] = 'India';
			         $payload['score'] = '5.6';
			        // notification title
			         $title ='Hawkers';
			         $message ='Your advertisement published successfully.';
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
         ?>
        <script>
          alert("Paid ads approved successfully");
          location.href="advertisement.php?action=paid_pending_advertisement";
        </script>
        <?php  
        

      }
      else{
        ?>
        <script>
          alert("Some-thing went wrong please try again..");
          location.href="advertisement.php?action=paid_pending_advertisement";
        </script>
        <?php
      }
    }
?>
