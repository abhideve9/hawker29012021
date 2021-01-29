<?php
include("/var/www/html/Hawker/conn.php");
 $user_check = "SELECT name,mobile_no_contact from registration_sellers where referral_status='1'";
 $money='10';
   //echo $user_check; die();
  $run=mysqli_query($db,$user_check);
  while($row_cats=mysqli_fetch_array($run))
  {
    $name=$row_cats['name'];
    $mobile_no = $row_cats['mobile_no_contact'];
    $query="select * FROM tbl_hawker_referal_code_for_customer  where referal_code='$mobile_no' and referral_flag_status='1' and limit_status!='1'";
    $runUsers=mysqli_query($db,$query);

    $query1="select * FROM tbl_hawker_referal_code_for_customer  where referal_code='$mobile_no' and (referral_flag_status='1' or referral_flag_status='0' )";
     $runUsers1=mysqli_query($db,$query1);

    //$num_rows1=$query1->num_rows();
    $num_rows1=mysqli_num_rows($runUsers1);
    //$num_rows=$query->num_rows();
    $num_rows=mysqli_num_rows($runUsers);


    $money_count=$num_rows *$money;
    $total_customer_referral=$num_rows1;

   


   if($run)
  {
    $insertQuery="UPDATE registration_sellers SET money_count='$money_count' ,total_customer_referral='$total_customer_referral' WHERE mobile_no_contact='".$mobile_no."'";
    /*echo $insertQuery;*/
    $insertResult=mysqli_query($db,$insertQuery);
    echo '1';
}
else
{
  echo '0';
}
             
   }
 
?>
