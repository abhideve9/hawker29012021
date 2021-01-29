<?php
include 'conn.php';
   error_reporting(0); 
  date_default_timezone_set('Asia/kolkata'); 
  $now = date('Y-m-d H:i:s');
  $nowss=date('Y-m-d');
  $count =0;
  $designation = [];
  $designation1 = [];
  $designation4=[];
  $salesArrayCOunt=0;
 // $designation3 = [];
  $start=[];

  function getdata($n,$designation1)
     {
     // $n=0;
      $arr = array();
      $arr['start'] = $designation1[$n];
    
      if($n < 0)
      {
      $arr['end'] = $designation1[$n-1];
    
      }
      else
      {
        $arr['end'] = $designation1[$n+1];
     
        if($designation1[$n+1] == '')
        {

        if(!empty($latitude_for_sales))
       {
          $arr['end'] = $latitude_for_sales .','.$longitude_for_sales; 
       }
       else
       {
           $arr['end'] ="28.40687271,77.04216008";
       }
        
        }

      }
      $arr['start1'] = $designation1[$n+1];
      if($designation1[$n+1] == '')
      {

        if(!empty($latitude_for_sales))
       {
          $arr['start1'] = $latitude_for_sales .','.$longitude_for_sales; 
       }
       else
       {
           $arr['start1'] = "28.40687271,77.04216008";
       }
      //$arr['start1'] = "28.40687271,77.04216008";
      }
      return $arr;
      }
  
      $querydata="SELECT * from registration_sales";
      $run_type2 = mysqli_query($db, $querydata);
      while($row_type2=mysqli_fetch_array($run_type2))
      { 
        array_push($designation4,$row_type2['sales_id']);
      }
       $salesArrayCOunt=count($designation4);
       for($salesArray=0; $salesArray<$salesArrayCOunt; $salesArray++)
        {
        $querydata1="SELECT latitude,longitude, on_time from duty_on_off_by_sales  where on_time LIKE '%$nowss%' and sales_id='$designation4[$salesArray]' order by on_time ASC";
   /* echo '<br>';*/
         $run_type3 = mysqli_query($db, $querydata1);
         $row_type3=mysqli_fetch_array($run_type3);
         $latitude_for_sales=$row_type3['latitude'];
         $longitude_for_sales=$row_type3['longitude'];
     

      $getUsers="SELECT * FROM registration_sellers where  date_time='$nowss' and sales_id='$designation4[$salesArray]' and (verification_status =1 or  verification_by_call = 1) order by registered_time ASC";
     /* echo '<br>';*/
     $runUsers=mysqli_query($db,$getUsers);
      $start=[];
     $designation=[];
     if(!empty($latitude_for_sales))
     {
       $start[] = $latitude_for_sales .','.$longitude_for_sales; 
     }
     else
     {
        $start = array('28.40687271,77.04216008');
     }
     $arr = array();
     $designation2 = [];
     while ($rowUsers=mysqli_fetch_array($runUsers))
     {
      $data= $rowUsers["shop_latitude"] .','.$rowUsers["shop_longitude"]; 
      $designation[] = $rowUsers["shop_latitude"] .','.$rowUsers["shop_longitude"]; 
      /* print_r($designation);*/
      $designation2[] = $rowUsers;
     }
     /*  print_r($designation);*/
     $designation1= array_merge($start,$designation);
    /* print_r($designation1);
     echo '<br>';*/
   /* print_r($designation1);
     echo '<br>';*/
    $count = count($designation1);

    $a =0;
   
    $srNo = 1;

    for($j=0; $j<$count; $j++)
    {
      //print_r($j)
      $a = $j;
      //print_r($a);
      $data = getdata($a,$designation1);
    /*print_r($data);*/
       $latLong = explode(",", $data['start']);
       
      $latLongEnd = explode(",", $data['end']);
        
      $newStart = explode(",", $data['start1']);
       
      $latLong = explode(",", $data['start']);
      
      if($j < 0)
      {
        $latLong = explode(",", $data['start1']);
      }
      
      $latitudeFrom = $latLong[0];
      /*echo 'start<br>';*/
      $longitudeFrom = $latLong[1]; 
       /*echo 'start <br>';*/
      $shop_latitude = $latLongEnd[0];
      /* echo 'end <br>';*/
       $shop_longitude = $latLongEnd[1];
      /*  echo 'end <br>';*/
       
       $rad = M_PI / 180;
   //Calculate distance from latitude and longitude
    $theta = $longitudeFrom - $shop_longitude;
    $dist = sin($latitudeFrom * $rad) 
   * sin($shop_latitude * $rad) +  cos($latitudeFrom * $rad)
   * cos($shop_latitude * $rad) * cos($theta * $rad);
    $distance= acos($dist) / $rad * 60 *  2.250;
    $distance_calculate =round($distance,2);
    $sales_id=$designation2[$j]['sales_id'];
    $mobile_no_contact=$designation2[$j]['mobile_no_contact'];
    $registered_time=$designation2[$j]['registered_time'];
    $date_time=$designation2[$j]['date_time'];
    
      $insertQuery="INSERT INTO tbl_add_distance_for_sale (sales_id,distance,mobile_no_contact,registered_time,date_time)VALUES ('$sales_id','$distance_calculate','$mobile_no_contact','$registered_time','$date_time')";
      $insertResult=mysqli_query($db,$insertQuery);
    
    }
  }
  /*.................................................*/

?>