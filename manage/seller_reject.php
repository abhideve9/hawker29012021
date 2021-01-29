<?php
include 'db.php';
require_once'firebase.php';
require_once 'push.php';
require_once 'config.php';

 $saleID=$_GET['saleID'];
 $getUsers="SELECT * FROM login_manage_sales WHERE user_id='$saleID'";
 $runUsers=mysqli_query($db,$getUsers);
 while($rowUsers=mysqli_fetch_array($runUsers))
 {
   $notification_id=$rowUsers['notification_id'];
 }

$getseller="SELECT name FROM registration_seller WHERE id='".$_REQUEST['id']."'";
 $runseller=mysqli_query($db,$getseller);
 while($rowseller=mysqli_fetch_array($runseller))
 {
   $name=$rowUsers['name'];
 }

 $status=0;
 mysqli_query($db,"UPDATE registration_sellers SET active_status='$status' WHERE id='".$_REQUEST['id']."'");


        $firebase = new Firebase();
        $push = new Push();

        // optional payload
        $payload = array();
        $payload['team'] = 'India';
        $payload['score'] = '5.6';

        // notification title
        $title ='Your Request has been Rejected';
        
        // notification message
        $message ='Seller Name : '.$name;
        
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
            $regId = /*isset($_GET['regId']) ? $_GET['regId']*/ $notification_id;
            $response = $firebase->send($regId, $json);
        }

?>
<script>
 	alert("Seller Rejected Successfully");

	location.href="seller.php?action=ListingSeller";
</script>