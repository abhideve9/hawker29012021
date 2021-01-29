<?php
session_start();
  include_once 'db.php';
  
  $adminid=$_SESSION['adminID'];
$adminName=$_SESSION['adminName'];
  if(isset($_REQUEST['id']))
  {

 date_default_timezone_set('Asia/kolkata'); 
  $now = date('Y-m-d H:i:s');
  $status=1;
  mysqli_query($db,"UPDATE fixer_sub_category SET status='$status',modified_user_name='$adminName',modified_date='$now',admin_status='1' WHERE id='".$_REQUEST['id']."'");
    }
    else if(isset($_REQUEST['ids']))
    {
      date_default_timezone_set('Asia/kolkata'); 
  $now = date('Y-m-d H:i:s');
    $status=0;
  mysqli_query($db,"UPDATE fixer_sub_category SET status='$status',modified_user_name='$adminName',modified_date='$now',admin_status='1' WHERE id='".$_REQUEST['ids']."'");
    }
  
?>
<script>
  location.href="category.php?action=ActiveSubCat";
</script>
