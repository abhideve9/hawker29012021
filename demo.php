<?php
include("conn.php");

   date_default_timezone_set('Asia/kolkata'); 
   $now = date('Y-m-d');
    $nowss= date('Y-m-d H:i:s');
   $email='hawkers.nearby@gmail.com';
   /* $user_check = "SELECT * from registration_sellers where registered_time like '$now%' and verification_status='1'";*/
   $user_check1 = "SELECT * from registration_sellers where verification_status='1'";

   /*$user_check2 = "SELECT * from registration_sellers where verification_status='1' and  sales_id='SAL_00008' and registered_time like '$now%'";

   $user_check3 = "SELECT * from registration_sellers where verification_status='1' and  sales_id='SAL_000010' and registered_time like '$now%'";

   $user_check4 = "SELECT * from registration_sellers where verification_status='1' and  sales_id='SAL_00007' and registered_time like '$now%'";

   $user_check5 = "SELECT * from registration_sellers where verification_status='1' and  sales_id='SAL_00007'";
    $user_check6 = "SELECT * from registration_sellers where verification_status='1' and  sales_id='SAL_00008'";
    $user_check7 = "SELECT * from registration_sellers where verification_status='1' and  sales_id='SAL_000010'";*/


   $Hawker='Hawker list';
   //echo $user_check; die();
 /* $run=mysqli_query($db,$user_check);*/
   $run1=mysqli_query($db,$user_check1);
 /* $run2=mysqli_query($db,$user_check2);
   $run3=mysqli_query($db,$user_check3);
   $run4=mysqli_query($db,$user_check4);
   $run5=mysqli_query($db,$user_check5);
   $run6=mysqli_query($db,$user_check6);
   $run7=mysqli_query($db,$user_check7);

   $count=mysqli_num_rows($run);*/
   $count1=mysqli_num_rows($run1);
 
  /* $count2=mysqli_num_rows($run2);
   $count3=mysqli_num_rows($run3);
   $count4=mysqli_num_rows($run4);
   $count5=mysqli_num_rows($run5);
   $count6=mysqli_num_rows($run6);
   $count7=mysqli_num_rows($run7);*/
   /*print_r($count);
   die();*/
   if($run1)
   {
    $sender_mail = $email;
    $headers4sender  = "MIME-Version: 1.0\r\n";
    $headers4sender .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $headers4sender .= "From: ".$Hawker."<".$sender_mail.">\r\n";
    $headers4sender .= 'Reply-To: '.$email.''."\r\n";
    $headers4sender .= 'Cc: ramanvarshney1990@gmail.com'."\r\n";
    $to='goolean.tech@gmail.com';

    $subject= 'Hawker list';
    $body="<table align=left cellpadding=3 cellspacing=0 border=1>
       <tr><td colspan='2'>Hawker Registration</td></tr>
  
       <tr><td><b>Total Hawker : </b></td><td>".$count1."</td></tr>
      
       </table>";
       if(@mail($to,$subject,$body,$headers4sender))
           {

              echo "1";
               /*$insertQuery="INSERT INTO tbl_history_for_mail SET count='1',date_time='$nowss'";
               $insertResult=mysqli_query($db,$insertQuery);
*/
             
           }else
           {
            echo "2";                
           }
   }

   
   
  
?>
