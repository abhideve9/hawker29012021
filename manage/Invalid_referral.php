<?php
include_once 'db.php';
	if(isset($_REQUEST['mobile_no']))
	{
        /// inactivate ................//
	$status=2;
	$mobile_no=$_REQUEST['mobile_no'];
	mysqli_query($db,"UPDATE registration_sellers SET  referral_status ='$status' WHERE mobile_no_contact='".$_REQUEST['mobile_no']."'");
     }
	 ?>
	<script>
	alert("You Have successfully inactivated hawker for referral");
	location.href="seller.php?action=seller_user_referral";
    </script>
     <?php
    
  
  
   ?>
   
  
	

