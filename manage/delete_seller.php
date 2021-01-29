<?php
include_once 'db.php';
session_start();
$adminid=$_SESSION['adminID'];
$adminName=$_SESSION['adminName'];
date_default_timezone_set('Asia/kolkata'); 
    $now = date('Y-m-d H:i:s');
  $status=2;
  mysqli_query($db,"UPDATE  registration_sellers SET active_status='0',duty_status='NULL',,modified_date='$now',modified_user_name='$adminName',admin_status='1'  WHERE id='".$_REQUEST['id']."'");
?>
<script>
  alert("Seller Deactivate Successfully");
  location.href="seller.php?action=activeseller";
</script>