<?php
session_start();
$adminid=$_SESSION['adminID'];
$adminName=$_SESSION['adminName'];
  include_once 'db.php';
  if(isset($_REQUEST['id']))
  {

  $status=0;
  date_default_timezone_set('Asia/kolkata'); 
    $now = date('Y-m-d H:i:s');
  mysqli_query($db,"UPDATE hawker_type SET status='$status',modified_date='$now',modified_user_name='$adminName',admin_status='1' WHERE id='".$_REQUEST['id']."'");
    }
    else if(isset($_REQUEST['ids']))
    {
      date_default_timezone_set('Asia/kolkata'); 
    $now = date('Y-m-d H:i:s');
    $status=1;
  mysqli_query($db,"UPDATE hawker_type SET status='$status',modified_date='$now',modified_user_name='$adminName',admin_status='1' WHERE id='".$_REQUEST['ids']."'");
    }
  
?>
<script>
  location.href="hawker.php?action=ActiveHawkerType";
</script>
