<?php
include("/var/www/html/Hawker/conn.php");

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
   $user_check = "SELECT name,mobile_no_contact from registration_sellers where referral_status='1'";
   $Hawker='Hawker list';
   $money='10';
   //echo $user_check; die();
  $run=mysqli_query($db,$user_check);
   if($run)
  {
  $mail->From = 'hawkers.nearby@goolean.com';
  $mail->FromName = 'Hawker Admin';
  $mail->addAddress('raman.varshney@goolean.tech');
  //$mail->addCC('raman.varshney@goolean.tech');
   $mail->addBCC('sanat.bhardwaj@goolean.tech');
  //$mail->addBCC('renuka.kumari@goolean.tech');
  $mail->isHTML(true);
  $mail-> Subject= 'Hawker Referral Count Status';
  
   $mail-> Body="<h2>Hawker<small> Referral Report</small></h2><table align=left cellpadding=3 cellspacing=0 border=1> <thead><tr>
      <th>Name</th>
       <th>Mobile Number</th>
       <th>Today Registered Customer</th>
        <th>Today Referral Money</th>
        <th>Total Registered Customer</th>      
      <th>Total Referral Money</th>
     
      </tr></thead>";
  while($row_cats=mysqli_fetch_array($run))
  {
    $name=$row_cats['name'];
    $mobile_no = $row_cats['mobile_no_contact'];
    $query="select device_id FROM tbl_hawker_referal_code_for_customer  where referal_code='$mobile_no' and referral_flag_status='1' and limit_status!='1'";
    $runUsers=mysqli_query($db,$query);

    $query1="select device_id FROM tbl_hawker_referal_code_for_customer  where referal_code='$mobile_no' and (referral_flag_status='1' or referral_flag_status='0' )";
    $runUsers1=mysqli_query($db,$query1);

    $query2="select device_id FROM tbl_hawker_referal_code_for_customer  where referal_code='$mobile_no' and date='$now' and (referral_flag_status='1' or referral_flag_status='0' )";
    $runUsers2=mysqli_query($db,$query2);

    $query3="select device_id FROM tbl_hawker_referal_code_for_customer  where referal_code='$mobile_no' and date='$now' and referral_flag_status='1' and limit_status!='1'";
    $runUsers3=mysqli_query($db,$query3);

    //$num_rows1=$query1->num_rows();
    $num_rows1=mysqli_num_rows($runUsers1);
    //$num_rows=$query->num_rows();
    $num_rows=mysqli_num_rows($runUsers);

    $num_rows2=mysqli_num_rows($runUsers2);

    $num_rows3=mysqli_num_rows($runUsers3);

  $mail-> Body.=" <tbody><tr class='odd gradeX'><td>".$name."</td><td>".$mobile_no."</td><td>".$num_rows2."</td><td>".$num_rows3 *$money."</td> <td>".$num_rows1."</td><td>".$num_rows *$money."</td>
                 </tr>";
        }
 }
       ?>

       </table>
  <?php

  if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
       echo 'Message has been sent';

  
   /* $insertQuery="INSERT INTO tbl_history_for_mail SET count='1',date_time='$nowss'";
               $insertResult=mysqli_query($db,$insertQuery);*/
}
             
  
?>
