<?php
include("db.php");
require 'PHPMailer/PHPMailerAutoload.php';

   date_default_timezone_set('Asia/kolkata'); 
   $now = date('Y-m-d');
  $nowss = date('Y-m-d H:i:s');
   $email='hawkers.nearby@gmail.com';
   $user_check = "SELECT * from registration_sellers where registered_time like '$now%' and verification_status='1'";
   $user_check1 = "SELECT * from registration_sellers where verification_status='1'";

   $user_check2 = "SELECT * from registration_sellers where verification_status='1' and  sales_id='SAL_00008' and registered_time like '$now%'";

   $user_check3 = "SELECT * from registration_sellers where verification_status='1' and  sales_id='SAL_000010' and registered_time like '$now%'";

   $user_check4 = "SELECT * from registration_sellers where verification_status='1' and  sales_id='SAL_00007' and registered_time like '$now%'";

   $user_check5 = "SELECT * from registration_sellers where verification_status='1' and  sales_id='SAL_00007'";
    $user_check6 = "SELECT * from registration_sellers where verification_status='1' and  sales_id='SAL_00008'";
    $user_check7 = "SELECT * from registration_sellers where verification_status='1' and  sales_id='SAL_000010'";


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

   $count=mysqli_num_rows($run);
   $count1=mysqli_num_rows($run1);

   $count2=mysqli_num_rows($run2);
   $count3=mysqli_num_rows($run3);
   $count4=mysqli_num_rows($run4);
   $count5=mysqli_num_rows($run5);
   $count6=mysqli_num_rows($run6);
   $count7=mysqli_num_rows($run7);
   if($run)
   {

    $mail = new PHPMailer;      
    //$mail->SMTPDebug = 2; 
    $mail->CharSet = 'UTF-8'; 
    //$mail->SMTPSecure = 'ssl';                           // Enable verbose debug output
   //$mail->isSMTP();    
    $mail->isHTML(true);                                   // Set mailer to use SMTP
    $mail->Host = 'smtp.ips.com';                       // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                              // Enable SMTP authentication
    $mail->Username = 'admin@goolean.com';    // SMTP username
    $mail->Password = 'Abcd1234';               // SMTP password
   // $mail->SMTPSecure = 'tls'; 
    $mail->Port = 587;
    $mail->setFrom($email);
    //$mail->addReplyTo($email);

    // Add a recipient
    $mail->addAddress('raman.varshney@goolean.tech');

    // Add cc or bcc 
    //$mail->addCC('sunita.katheria94@gmail.com');

    // Add cc or bcc 
    //$mail->addCC('yogecs@gmail.com');
   // $mail->addBCC('bcc@example.com');


    $mail->Subject = 'Hawker list';

    $mailContent = "<table align=left cellpadding=3 cellspacing=0 border=1>
       <tr><td colspan='2'>Hawker Registration</td></tr>
       <tr><td><b>Today Hawker Registration : </b></td><td>".$count."</td></tr>
       <tr><td><b>Total Hawker : </b></td><td>".$count1."</td></tr>
       <tr><td><b>Today Hawker add by Anuj Pratap : </b></td><td>".$count2."</td></tr>
       <tr><td><b>Today Hawker add by Narinder singh : </b></td><td>".$count4."</td></tr>
       <tr><td><b>Today Hawker add by Mohit Kumar : </b></td><td>".$count3."</td></tr>
       <tr><td><b>Total Hawker add by Anuj Pratap : </b></td><td>".$count6."</td></tr>
       <tr><td><b>Total Hawker add by Narinder singh : </b></td><td>".$count5."</td></tr>
       <tr><td><b>Total Hawker add by Mohit Kumar : </b></td><td>".$count7."</td></tr>
       </table>"; //content of mail
      $mail->Body = $mailContent;

      if(!$mail->send()){
    echo "2";
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}else
{
  $insertQuery="INSERT INTO tbl_history_for_mail SET count='1',date_time='$nowss'";
  $insertResult=mysqli_query($db,$insertQuery);

    echo "1";
             
}


    /*
    $sender_mail = $email;
    $headers4sender  = "MIME-Version: 1.0\r\n";
    $headers4sender .= "Content-type: text/html; charset=iso-8859-1\r\n";
   // $headers4sender .= "From: ".$Hawker."<".$sender_mail.">\r\n";
    $headers4sender .= 'Reply-To: '.$email.''."\r\n";
    //$headers4sender .= 'Cc: hr@tofarch.com'."\r\n";
    $to='ramanvarshney1990@gmail.com';
    $subject= 'Hawker list';
    $body="<table align=left cellpadding=3 cellspacing=0 border=1>
       <tr><td colspan='2'>Hawker Registration</td></tr>
       <tr><td><b>Today Hawker Registration : </b></td><td>".$count."</td></tr>
       <tr><td><b>Total Hawker : </b></td><td>".$count1."</td></tr>
       <tr><td><b>Today Hawker add by Anuj Pratap : </b></td><td>".$count2."</td></tr>
       <tr><td><b>Today Hawker add by Narinder singh : </b></td><td>".$count4."</td></tr>
       <tr><td><b>Today Hawker add by Mohit Kumar : </b></td><td>".$count3."</td></tr>
       <tr><td><b>Total Hawker add by Anuj Pratap : </b></td><td>".$count6."</td></tr>
       <tr><td><b>Total Hawker add by Narinder singh : </b></td><td>".$count5."</td></tr>
       <tr><td><b>Total Hawker add by Mohit Kumar : </b></td><td>".$count7."</td></tr>
       </table>";
       if(@mail($to,$subject,$body,$headers4sender))
           {
             $insertQuery="INSERT INTO tbl_history_for_mail SET count='1',date_time='$nowss'";
               $insertResult=mysqli_query($db,$insertQuery);

              echo "1";
             
           }else
                {
                echo "2";
                                     
                }
*/   }

   
   
  
?>
