<?php

	$status=2;
	mysqli_query($db,"DELETE FROM  registration_sellers  WHERE id='".$_REQUEST['id']."'");
?>
<script>
 	alert("Seller delete Successfully");
	location.href="Seller.php?action=listingseller";
</script>