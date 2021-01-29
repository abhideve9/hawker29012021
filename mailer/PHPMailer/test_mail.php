<?php
include("/var/www/html/hawker/conn.php");
require 'PHPMailerAutoload.php';
$mail = new PHPMailer;
//$mail->SMTPDebug = 3;
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.ipage.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'admin@goolean.com';                 // SMTP username
$mail->Password = 'Abcd1234';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;  

   date_default_timezone_set('Asia/kolkata'); 
   $now = date('Y-m-d');
    $nowss= date('Y-m-d H:i:s');
   $email='hawkers.nearby@gmail.com';
   $user_check = "SELECT * from registration_sellers where registered_time like '$now%' and (verification_status ='1' or  verification_by_call = '1')";
   $user_check1 = "SELECT * from registration_sellers where (verification_status ='1' or  verification_by_call = '1')";

   $user_check2 = "SELECT * from registration_sellers where (verification_status ='1' or  verification_by_call = '1') and  sales_id='SAL_00008' and registered_time like '$now%'";

   $user_check3 = "SELECT * from registration_sellers where (verification_status ='1' or  verification_by_call = '1') and  sales_id='SAL_000010' and registered_time like '$now%'";
   $user_check4 = "SELECT * from registration_sellers where (verification_status ='1' or  verification_by_call = '1') and  sales_id='SAL_00007' and registered_time like '$now%'";

   $user_check5 = "SELECT * from registration_sellers where (verification_status ='1' or  verification_by_call = '1') and  sales_id='SAL_00007'";
   $user_check6 = "SELECT * from registration_sellers where (verification_status ='1' or  verification_by_call = '1') and  sales_id='SAL_00008'";
   $user_check7 = "SELECT * from registration_sellers where(verification_status ='1' or  verification_by_call = '1') and  sales_id='SAL_000010'";
   //$user_check12 = "SELECT * from registration_sellers where(verification_status ='1' or  verification_by_call = '1') and  sales_id='SAL_000019'";
   $user_check11 = "SELECT * from registration_sellers where (verification_status ='1' or  verification_by_call = '1') and  sales_id='SAL_000019' and registered_time like '$now%'";
  
   $Hawker='Hawker list';
   //echo $user_check; die();
   $run=mysqli_query($db,$user_check);
   $run1=mysqli_query($db,$user_check1);
   $run2=mysqli_query($db,$user_check2);
   $run3=mysqli_query($db,$user_check3);
   $run4=mysqli_query($db,$user_check4);
   $run5=mysqli_query($db,$user_check5);
   $run6=mysqli_query($db,$user_check6);
   $run7=mysqli_query($db,$user_check7);
   //$run10=mysqli_query($db,$user_check12);
   $run11=mysqli_query($db,$user_check11);

   $count=mysqli_num_rows($run);
   $count1=mysqli_num_rows($run1);

   $count2=mysqli_num_rows($run2);
   $count3=mysqli_num_rows($run3);
   $count4=mysqli_num_rows($run4);
   $count5=mysqli_num_rows($run5);
   $count6=mysqli_num_rows($run6);
   $count7=mysqli_num_rows($run7);
  
   //$count10=mysqli_num_rows($run10);
   $count11=mysqli_num_rows($run11);
   if($run)
   {

  $mail->From = 'hawkers.nearby@goolean.com';
  $mail->FromName = 'Hawker Admin';
  //$mail->addAddress('ashish@goolean.tech','Ashish Puri');
  $mail->addAddress('rachna.bhatia@goolean.tech','Rachna');
  //$mail->addCC('raman.varshney@goolean.tech');
 // $mail->addBCC('siddharth@goolean.tech');
  //$mail->addBCC('renuka.kumari@goolean.tech');
  $mail->isHTML(true);
  $mail-> Subject= 'Hawker list';
  $mail-> Body="<table align=left cellpadding=3 cellspacing=0 border=1>
       <tr><td colspan='2'>Hawker Registration</td></tr>
       <tr><td><b>Today Hawker Registration : </b></td><td>".$count."</td></tr>
       <tr><td><b>Total Hawker : </b></td><td>".$count1."</td></tr>
        <tr><td><b>Today Hawker add by Anuj Pratap : </b></td><td>".$count2."</td></tr>
        <tr><td><b>Today Hawker add by Mohit Kumar : </b></td><td>".$count3."</td></tr>
         <tr><td><b>Today Hawker add by Narinder singh : </b></td><td>".$count4."</td></tr>
         <tr><td><b>Today Hawker add by Harpreet : </b></td><td>".$count11."</td></tr>
      

        <tr><td><b>Total Hawker add by Anuj Pratap : </b></td><td>".$count6."</td></tr>
         <tr><td><b>Total Hawker add by Narinder singh : </b></td><td>".$count5."</td></tr>
         <tr><td><b>Total Hawker add by Mohit Kumar : </b></td><td>".$count7."</td></tr>





       </table>";
 if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
//    echo 'Message has been sent';

  
   // $insertQuery="INSERT INTO tbl_history_for_mail SET count='1',date_time='$nowss'";
             //  $insertResult=mysqli_query($db,$insertQuery);
}
             
   }        
   

   
   
  
?>
