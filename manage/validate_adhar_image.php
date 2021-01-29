<?php
	include_once 'db.php';
	if(isset($_REQUEST['mobile_no']))
	{
	$status=1;
	mysqli_query($db,"UPDATE registration_sellers SET  adhar_image_validation_status ='$status' WHERE mobile_no_contact='".$_REQUEST['mobile_no']."'");
	  ?>
	<script>
	alert(" Image Validate successfully");
	location.href="seller.php?action=activeseller";
    </script>
     <?php
    }
  
    else if(isset($_REQUEST['mobile_no1']))
    {
    $status=2;
	mysqli_query($db,"UPDATE registration_sellers SET adhar_image_validation_status='$status' WHERE mobile_no_contact='".$_REQUEST['mobile_no1']."'");
	  ?>
   
	 <script>
	 alert("Image Unvalidate successfully");
	location.href="seller.php?action=activeseller";
  </script>
   <?php
    }
   else if(isset($_REQUEST['mobile_no2']))
   {
   	 $status=3;
	 mysqli_query($db,"UPDATE registration_sellers SET adhar_image_validation_status='$status' WHERE mobile_no_contact='".$_REQUEST['mobile_no2']."'");
	 ?>
	  <script>
	 alert(" Upload Image validate successfully");
	location.href="seller.php?action=activeseller";
</script>
<?php
   }
   ?>
   
  
	

