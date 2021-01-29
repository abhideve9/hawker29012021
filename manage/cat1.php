<?php
include 'db.php';
 $sub1=$_POST['postdata1'];
  $get_cats = "select * from fixer_sub_category where category = '$sub1' and status='1'";
 
 $run_cats = mysqli_query($db, $get_cats);

 
 while($row_cats=mysqli_fetch_array($run_cats))
 {
 	echo "<option value=''>Select Options</option>";
   $sub_cat_id=$row_cats['id'];
   $sub_cat_name = $row_cats['sub_cat_name'];
   echo "<option value='$sub_cat_id'>$sub_cat_name</option>";
 }
 ?>


