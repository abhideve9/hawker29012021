<?php
include 'conn.php';
      date_default_timezone_set('Asia/kolkata'); 
      $now = date('Y-m-d H:i:s');
      $nowss=date('Y-m-d');
      $latitudeFrom='28.40687271';
      $longitudeFrom='77.04216008';
      $querydata="SELECT * from login_manage_sales";
      $run_type2 = mysqli_query($db, $querydata);
     // $run_date=date("Y-m-d", strtotime("$nowss -1 day" ));

      while($row_type2=mysqli_fetch_array($run_type2))
      { 
      $sales_id=$row_type2['user_id'];

      $getUsers="SELECT shop_latitude,shop_longitude,sales_id,registered_time FROM registration_sellers where date_time='2020-01-05' and sales_id='$sales_id' and (verification_status =1 or  verification_by_call = 1) order by registered_time DESC limit 1";

      $runUsers=mysqli_query($db,$getUsers);

      $getUsers1="SELECT shop_latitude,shop_longitude,sales_id,registered_time FROM registration_sellers where date_time='2020-01-05' and sales_id='$sales_id' and (verification_status =1 or  verification_by_call = 1) order by registered_time ASC limit 1";



     // $getUsers="SELECT shop_latitude,shop_longitude,sales_id,registered_time FROM registration_sellers where date_time='$run_date' and sales_id='$sales_id' and (verification_status =1 or  verification_by_call = 1) order by registered_time DESC limit 1";

      //$runUsers=mysqli_query($db,$getUsers);

      //$getUsers1="SELECT shop_latitude,shop_longitude,sales_id,registered_time FROM registration_sellers where date_time='$run_date' and sales_id='$sales_id' and (verification_status =1 or  verification_by_call = 1) order by registered_time ASC limit 1";

      $runUsers1=mysqli_query($db,$getUsers1);

      $rowUsers1=mysqli_fetch_array($runUsers1);
      $registered_time=$rowUsers1['registered_time'];
      $sum = 0;
       while($rowUsers=mysqli_fetch_array($runUsers))
      {
      $shop_latitude=$rowUsers['shop_latitude'];
      $shop_longitude=$rowUsers['shop_longitude'];
      $sales_id=$rowUsers['sales_id'];
      $registered_time1=$rowUsers['registered_time'];

      $datetime1 = new DateTime($registered_time);
      $datetime2 = new DateTime($registered_time1);

      $interval = $datetime1->diff($datetime2);
      $elapsed = $interval->format(' %h hours %i minutes');
      $details=array_intersect_key((array)$interval,array_flip(['h']));
     $detail =array_intersect_key((array)$interval,array_flip(['i']));
     $hurs=implode(",", $details);
     $hours=$hurs*60;
     $minutes=implode(",", $detail);
     $sumdata=$hours+$minutes;
     $rad = M_PI / 180;
      //Calculate distance from latitude and longitude
      $theta = $longitudeFrom - $rowUsers['shop_longitude'];
      $dist = sin($latitudeFrom * $rad) 
             * sin($rowUsers['shop_latitude'] * $rad) +  cos($latitudeFrom * $rad)
             * cos($rowUsers['shop_latitude'] * $rad) * cos($theta * $rad);
      $distance= acos($dist) / $rad * 60 *  2.250;
      $sum += (float)$distance;
     $insertQuery="INSERT INTO tbl_add_distance_per_days (sales_id,distance,time_interval,date_time,create_date)VALUES ('$sales_id','$sum','$sumdata','$now','$nowss')";
     echo $insertQuery;
     exit();
     
      $insertResult=mysqli_query($db,$insertQuery);
       }}

        

?>