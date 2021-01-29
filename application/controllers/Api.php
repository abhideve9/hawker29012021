<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

 class Api extends CI_Controller {
  function __construct($config = 'rest')
  {  
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Max-Age: 1000');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    ini_set('error_reporting', E_STRICT);
    parent::__construct($config);
    $this->load->helper('date');
    $this->load->helper('text');
    $this->load->library('upload');
    $this->load->helper('url');
    $this->load->helper('main_helper');
  }

  /////////////////////////  Cron job ///////////////////////////////
   public function notification_by_customer()
   {
    $notifieddata = $this->User->near_by_hawker_notified_data();
   
    if(!empty($notifieddata))
    {
     foreach ($notifieddata as $rowdata)
    {
    $cus_id=$rowdata['cus_id'];
    $mobile_no=$rowdata['mobile_no'];
    $get_mobile_no_for_notifieddata = $this->User->get_mobile_no_for_notified_data($mobile_no);
    foreach ($get_mobile_no_for_notifieddata as $rowdata1)
    {
    $latitudeFrom=$rowdata1['latitude'];
    $longitudeFrom=$rowdata1['longitude'];
    $notification_id=$rowdata['notification_id'];
    $cat_id=$rowdata['cat_id'];
    $sub_cat_id=$rowdata['sub_cat_id'];
    $super_sub_cat_id=$rowdata['super_sub_cat_id'];
    $radius=$rowdata['radius'];
    $city=$rowdata['city'];
    $status=$rowdata['status'];
    $date_time=$rowdata['date_time'];
    $set_time=$rowdata['date_time'];
    $status=$rowdata['status'];
    if($sub_cat_id=='' or $sub_cat_id=='0')
    {
    $getcatdata = $this->Customer->get_cat_id_data($cat_id);
    $array = array_column($getcatdata, 'id'); //Get an array of just the app_subject_id column
    $array = implode(',', $array); //creates a string of the id's separated by commas

    $getdata = $this->User->check_data_by_registerseller($array,$city);
    $cat_data2=$this->User->customer_cat_data($array);
    $cat_data=$cat_data2->cat_name;
    }
    else
    {
      $getsubcatdata = $this->Customer->get_subcat_id_data($sub_cat_id);
      $array = array_column($getsubcatdata, 'id'); //Get an array of just the app_subject_id column
      $array = implode(',', $array); //creates a string of the id's separated by commas

     $getdata = $this->User->check_data_by_registerseller1($array,$city);
     $sub_cat_data=$this->User->customer_sub_cat_data($array);
     $cat_data=$sub_cat_data->sub_cat_name;
    }

    if($sub_cat_id=='' or $sub_cat_id=='0')
    {
    $getcatdata = $this->Customer->get_cat_id_data($cat_id);
    $array = array_column($getcatdata, 'id'); //Get an array of just the app_subject_id column
    $array = implode(',', $array); //creates a string of the id's separated by commas

    $getdata1 = $this->User->check_data_by_registerseller2($array,$city);
    $cat_data3=$this->User->customer_cat_data($array);
    $cat_data=$cat_data3->cat_name;
    }
    else
    {
     $getsubcatdata = $this->Customer->get_subcat_id_data($sub_cat_id);
     $array = array_column($getsubcatdata, 'id'); //Get an array of just the app_subject_id column
     $array = implode(',', $array); //creates a string of the id's separated by commas

     $getdata1 = $this->User->check_data_by_registerseller3($array,$city);
      $sub_cat_data=$this->User->customer_sub_cat_data($array);
      $cat_data=$sub_cat_data->sub_cat_name;
    }
    if($sub_cat_id=='' or $sub_cat_id=='0')
    {
    $getcatdata = $this->Customer->get_cat_id_data($cat_id);
    $array = array_column($getcatdata, 'id'); //Get an array of just the app_subject_id column
    $array = implode(',', $array); //creates a string of the id's separated by commas

    $getdata_temp = $this->User->check_data_by_registerseller_temp_fix($array,$city);
    $cat_data=$this->User->customer_cat_data($array);
    $cat_data=$cat_data->cat_name;
    }
    else
    {
     $getsubcatdata = $this->Customer->get_subcat_id_data($sub_cat_id);
     $array = array_column($getsubcatdata, 'id'); //Get an array of just the app_subject_id column
     $array = implode(',', $array); //creates a string of the id's separated by commas

     $getdata_temp = $this->User->check_data_by_registerseller1_temp_fix($array,$city);
     $sub_cat_data=$this->User->customer_sub_cat_data($array);
     $cat_data=$sub_cat_data->sub_cat_name;
    }
    if($sub_cat_id=='' or $sub_cat_id=='0')
    {
    $getcatdata = $this->Customer->get_cat_id_data($cat_id);
    $array = array_column($getcatdata, 'id'); //Get an array of just the app_subject_id column
    $array = implode(',', $array); //creates a string of the id's separated by commas
    $getdata_seasonal = $this->User->check_data_by_registerseller_seasonal_fix($array,$city);
    $cat_data=$this->User->customer_cat_data($array);
    $cat_data=$cat_data->cat_name;
    }
    else
    {
     $getsubcatdata = $this->Customer->get_subcat_id_data($sub_cat_id);
     $array = array_column($getsubcatdata, 'id'); //Get an array of just the app_subject_id column
     $array = implode(',', $array); //creates a string of the id's separated by commas
     $getdata_seasonal = $this->User->check_data_by_registerseller1_seasonal_fix($array,$city);
     $sub_cat_data=$this->User->customer_sub_cat_data($array);
     $cat_data=$sub_cat_data->sub_cat_name;
    }
    if($sub_cat_id=='' or $sub_cat_id=='0')
    {
    $getcatdata = $this->Customer->get_cat_id_data($cat_id);
    $array = array_column($getcatdata, 'id'); //Get an array of just the app_subject_id column
    $array = implode(',', $array); //creates a string of the id's separated by commas
    $getdata_temp_moving = $this->User->check_data_by_registerseller_temp_moving($array,$city);
    $cat_data=$this->User->customer_cat_data($array);
    $cat_data=$cat_data->cat_name;
    }
    else
    {
     $getsubcatdata = $this->Customer->get_subcat_id_data($sub_cat_id);
     $array = array_column($getsubcatdata, 'id'); //Get an array of just the app_subject_id column
     $array = implode(',', $array); //creates a string of the id's separated by commas
     $getdata_temp_moving = $this->User->check_data_by_registerseller1_temp_moving($array,$city);
     $sub_cat_data=$this->User->customer_sub_cat_data($array);
     $cat_data=$sub_cat_data->sub_cat_name;
    }
    if($sub_cat_id=='' or $sub_cat_id=='0')
    {
    $getcatdata = $this->Customer->get_cat_id_data($cat_id);
    $array = array_column($getcatdata, 'id'); //Get an array of just the app_subject_id column
    $array = implode(',', $array); //creates a string of the id's separated by commas
    $getdata_seasonal_moving = $this->User->check_data_by_registerseller_seasonal_moving($array,$city);
    $cat_data=$this->User->customer_cat_data($array);
    $cat_data=$cat_data->cat_name;
    }
   else
   {
    $getsubcatdata = $this->Customer->get_subcat_id_data($sub_cat_id);
     $array = array_column($getsubcatdata, 'id'); //Get an array of just the app_subject_id column
     $array = implode(',', $array); //creates a string of the id's separated by commas
     $getdata_seasonal_moving = $this->User->check_data_by_registerseller1_seasonal_moving($array,$city);
     $sub_cat_data=$this->User->customer_sub_cat_data($array);
     $cat_data=$sub_cat_data->sub_cat_name;
   }
   if(!empty($getdata))
   {
    foreach ($getdata as $row)
    {
      $userType=$row['user_type'];
      $rad = M_PI / 180;
     //Calculate distance from latitude and longitude
     $theta = $longitudeFrom - $row['shop_longitude'];
     $dist = sin($latitudeFrom * $rad) 
             * sin($row['shop_latitude'] * $rad) +  cos($latitudeFrom * $rad)
             * cos($row['shop_latitude'] * $rad) * cos($theta * $rad);

     $distance= acos($dist) / $rad * 60 *  2.250;
      if($distance<=$radius)
     {
      require APPPATH . 'firebase.php';
      require APPPATH . 'push.php';
      require APPPATH . 'config.php';
      $firebase = new Firebase();
      $push = new Push();
      // optional payload
      $payload = array();
      $payload['team'] = 'India';
      $payload['score'] = '5.6';
      // notification title
      $title ='Hawkers';
      // notification message
      $message ='We have found '. $cat_data .' hawker near by you';
      // push type - single user / topic
      $push_type = 'individual';
      $push->setTitle($title);
      $push->setMessage($message);
      $push->setIsBackground(FALSE);
      $push->setPayload($payload);
      $json = '';
      $response = '';
      if ($push_type == 'topic') {
      $json = $push->getPush();
      $response = $firebase->sendToTopic('global', $json);
      } else if ($push_type == 'individual') {
      $json = $push->getPush();
      $regId =$notification_id;
      $data2 = $firebase->send($regId, $json);
      date_default_timezone_set('Asia/kolkata'); 
      $now = date('Y-m-d H:i:s');
      $data->cus_id = $cus_id;
      $data->latitude = $latitudeFrom;
      $data->longitude = $longitudeFrom;
      $data->notification_id = $notification_id;
      $data->cat_id = $cat_id;
      $data->sub_cat_id = $sub_cat_id;
      $data->super_sub_cat_id = $super_sub_cat_id;
      $data->radius = $radius;
      $data->city = $city;
      $data->status = $status;
      $data->date_time = $date_time;
      $data->set_time = $set_time;
      $data1->cus_id = $cus_id;
      $data1->notification_id = $notification_id;
      $data1->title = $title;
      $data1->message = $message;
      $data1->date_time = $now;
      $data1->status = '1';
      $notifiedbycustomer = $this->User->notifiedcustomerdata($data1);

      $notifiedbackupdata = $this->User->backup_notified_data($data);

      $removenotifieddata = $this->User->remove_notified_data($cus_id,$notification_id,$cat_id,$sub_cat_id,$super_sub_cat_id);
      echo '1';
     }
    }
    else
    {
      echo '2';
    }
    
    }
   }
    else if(!empty($getdata_temp))
    {
       foreach ($getdata_temp as $row_temp)
    {
      $rad = M_PI / 180;
     //Calculate distance from latitude and longitude
     $theta = $longitudeFrom - $row_temp['shop_longitude'];
     $dist = sin($latitudeFrom * $rad) 
             * sin($row_temp['shop_latitude'] * $rad) +  cos($latitudeFrom * $rad)
             * cos($row_temp['shop_latitude'] * $rad) * cos($theta * $rad);
     $distance= acos($dist) / $rad * 60 *  2.250;
     if($distance<=$radius)
     {
      require APPPATH . 'firebase.php';
      require APPPATH . 'push.php';
      require APPPATH . 'config.php';
      $firebase = new Firebase();
      $push = new Push();
      // optional payload
      $payload = array();
      $payload['team'] = 'India';
      $payload['score'] = '5.6';
      // notification title
      $title ='Hawkers';
      // notification message
      $message ='We have found '. $cat_data .' hawker near by you';
      // push type - single user / topic
      $push_type = 'individual';
      $push->setTitle($title);
      $push->setMessage($message);
      $push->setIsBackground(FALSE);
      $push->setPayload($payload);
      $json = '';
      $response = '';
      if ($push_type == 'topic') {
      $json = $push->getPush();
      $response = $firebase->sendToTopic('global', $json);
      } else if ($push_type == 'individual') {
      $json = $push->getPush();
      $regId =$notification_id;
      $data2 = $firebase->send($regId, $json);
      date_default_timezone_set('Asia/kolkata'); 
      $now = date('Y-m-d H:i:s');
      $data->cus_id = $cus_id;
      $data->latitude = $latitudeFrom;
      $data->longitude = $longitudeFrom;
      $data->notification_id = $notification_id;
      $data->cat_id = $cat_id;
      $data->sub_cat_id = $sub_cat_id;
      $data->super_sub_cat_id = $super_sub_cat_id;
      $data->radius = $radius;
      $data->city = $city;
      $data->status = $status;
      $data->date_time = $date_time;
      $data->set_time = $set_time;
      $data1->cus_id = $cus_id;
      $data1->notification_id = $notification_id;
      $data1->title = $title;
      $data1->message = $message;
      $data1->date_time = $now;
      $data1->status = '1';
      $notifiedbycustomer = $this->User->notifiedcustomerdata($data1);

      $notifiedbackupdata = $this->User->backup_notified_data($data);

      $removenotifieddata = $this->User->remove_notified_data($cus_id,$notification_id,$cat_id,$sub_cat_id,$super_sub_cat_id);
      echo '1';
      }
     }
    else
    {
      echo '2';
    }
    }
   } 
   else if(!empty($getdata_seasonal))
    {
       foreach ($getdata_seasonal as $row_seasonal)
    {
      $rad = M_PI / 180;
     //Calculate distance from latitude and longitude
     $theta = $longitudeFrom - $row_seasonal['shop_longitude'];
     $dist = sin($latitudeFrom * $rad) 
             * sin($row_seasonal['shop_latitude'] * $rad) +  cos($latitudeFrom * $rad)
             * cos($row_seasonal['shop_latitude'] * $rad) * cos($theta * $rad);

     $distance= acos($dist) / $rad * 60 *  2.250;
     if($distance<=$radius)
     {
      require APPPATH . 'firebase.php';
      require APPPATH . 'push.php';
      require APPPATH . 'config.php';
      $firebase = new Firebase();
      $push = new Push();
      // optional payload
      $payload = array();
      $payload['team'] = 'India';
      $payload['score'] = '5.6';
      // notification title
      $title ='Hawkers';
      // notification message
      $message ='We have found '. $cat_data .' hawker near by you';
      // push type - single user / topic
      $push_type = 'individual';
      $push->setTitle($title);
      $push->setMessage($message);
      $push->setIsBackground(FALSE);
      $push->setPayload($payload);
      $json = '';
      $response = '';
      if ($push_type == 'topic') {
      $json = $push->getPush();
      $response = $firebase->sendToTopic('global', $json);
      } else if ($push_type == 'individual') {
      $json = $push->getPush();
      $regId =$notification_id;
      $data2 = $firebase->send($regId, $json);
      date_default_timezone_set('Asia/kolkata'); 
      $now = date('Y-m-d H:i:s');
      $data->cus_id = $cus_id;
      $data->latitude = $latitudeFrom;
      $data->longitude = $longitudeFrom;
      $data->notification_id = $notification_id;
      $data->cat_id = $cat_id;
      $data->sub_cat_id = $sub_cat_id;
      $data->super_sub_cat_id = $super_sub_cat_id;
      $data->radius = $radius;
      $data->city = $city;
      $data->status = $status;
      $data->date_time = $date_time;
      $data->set_time = $set_time;
      $data1->cus_id = $cus_id;
      $data1->notification_id = $notification_id;
      $data1->title = $title;
      $data1->message = $message;
      $data1->date_time = $now;
      $data1->status = '1';
      $notifiedbycustomer = $this->User->notifiedcustomerdata($data1);

      $notifiedbackupdata = $this->User->backup_notified_data($data);

      $removenotifieddata = $this->User->remove_notified_data($cus_id,$notification_id,$cat_id,$sub_cat_id,$super_sub_cat_id);
      echo '1';
     }
    }
    else
    {
      echo '2';
    }
    }
    }
    if(!empty($getdata1))
    {
     foreach ($getdata1 as $row1)
    {
     $hawker_code=$row1['hawker_code'];
     $getdevicedata = $this->User->get_device_data($hawker_code);
     foreach ($getdevicedata as $getdevice)
    {
      $gps_id=$getdevice['device_id'];
      $getdata2 = $this->User->check_data_by_location($gps_id);
      foreach ($getdata2 as $row2)
      {
      $userType=$row1['user_type'];
      if($userType=='Moving')
    {
      $rad = M_PI / 180;
     //Calculate distance from latitude and longitude
     $theta = $longitudeFrom - $row2['longitude'];
     $dist = sin($latitudeFrom * $rad) 
             * sin($row2['latitude'] * $rad) +  cos($latitudeFrom * $rad)
             * cos($row2['latitude'] * $rad) * cos($theta * $rad);

     $distance= acos($dist) / $rad * 60 *  2.250;
     if($distance<$radius)
     {
      require APPPATH . 'firebase.php';
      require APPPATH . 'push.php';
      require APPPATH . 'config.php';
      $firebase = new Firebase();
      $push = new Push();
      // optional payload
      $payload = array();
      $payload['team'] = 'India';
      $payload['score'] = '5.6';
      // notification title
      $title ='Hawkers';
      // notification message
      $message ='We have found '. $cat_data .' hawker near by you';
      // push type - single user / topic
      $push_type = 'individual';
      $push->setTitle($title);
      $push->setMessage($message);
      $push->setIsBackground(FALSE);
      $push->setPayload($payload);
      $json = '';
      $response = '';
      if ($push_type == 'topic') {
      $json = $push->getPush();
      $response = $firebase->sendToTopic('global', $json);
      } else if ($push_type == 'individual') {
      $json = $push->getPush();
      $regId =$notification_id;
      $data2 = $firebase->send($regId, $json);
      date_default_timezone_set('Asia/kolkata'); 
      $now = date('Y-m-d H:i:s');
      $data->cus_id = $cus_id;
      $data->latitude = $latitudeFrom;
      $data->longitude = $longitudeFrom;
      $data->notification_id = $notification_id;
      $data->cat_id = $cat_id;
      $data->sub_cat_id = $sub_cat_id;
      $data->super_sub_cat_id = $super_sub_cat_id;
      $data->radius = $radius;
      $data->city = $city;
      $data->status = $status;
      $data->date_time = $date_time;
      $data->set_time = $set_time;
      $data1->cus_id = $cus_id;
      $data1->notification_id = $notification_id;
      $data1->title = $title;
      $data1->message = $message;
      $data1->date_time = $now;
      $data1->status = '1';
      $notifiedbycustomer = $this->User->notifiedcustomerdata($data1);

      $notifiedbackupdata = $this->User->backup_notified_data($data);

      $removenotifieddata = $this->User->remove_notified_data($cus_id,$notification_id,$cat_id,$sub_cat_id,$super_sub_cat_id);
      echo '1';
       }
      }
      else
      {
        echo '2';
      }
     }
    }
    }
   }
   }
    else if(!empty($getdata_temp_moving))
    {
     foreach ($getdata_temp_moving as $row_temp_moving)
    {
    $hawker_code=$row_temp_moving['hawker_code'];
    $getdevicedata = $this->Customer->get_device_data($hawker_code);
    foreach ($getdevicedata as $getdevice)
    {
    $gps_id=$getdevice['device_id'];
    $getdata2 = $this->User->check_data_by_location($gps_id);
    foreach ($getdata2 as $row2)
    {
      $rad = M_PI / 180;
     //Calculate distance from latitude and longitude
     $theta = $longitudeFrom - $row2['longitude'];
     $dist = sin($latitudeFrom * $rad) 
             * sin($row2['latitude'] * $rad) +  cos($latitudeFrom * $rad)
             * cos($row2['latitude'] * $rad) * cos($theta * $rad);

     $distance= acos($dist) / $rad * 60 *  2.250;
      if($distance<$radius)
    {
      require APPPATH . 'firebase.php';
      require APPPATH . 'push.php';
      require APPPATH . 'config.php';
      $firebase = new Firebase();
      $push = new Push();
      // optional payload
      $payload = array();
      $payload['team'] = 'India';
      $payload['score'] = '5.6';
      // notification title
      $title ='Hawkers';
      // notification message
      $message ='We have found '. $cat_data .' hawker near by you';
      // push type - single user / topic
      $push_type = 'individual';
      $push->setTitle($title);
      $push->setMessage($message);
      $push->setIsBackground(FALSE);
      $push->setPayload($payload);
      $json = '';
      $response = '';
      if ($push_type == 'topic') {
      $json = $push->getPush();
      $response = $firebase->sendToTopic('global', $json);
      } else if ($push_type == 'individual') {
      $json = $push->getPush();
      $regId =$notification_id;
      $data2 = $firebase->send($regId, $json);
      date_default_timezone_set('Asia/kolkata'); 
      $now = date('Y-m-d H:i:s');
      $data->cus_id = $cus_id;
      $data->latitude = $latitudeFrom;
      $data->longitude = $longitudeFrom;
      $data->notification_id = $notification_id;
      $data->cat_id = $cat_id;
      $data->sub_cat_id = $sub_cat_id;
      $data->super_sub_cat_id = $super_sub_cat_id;
      $data->radius = $radius;
      $data->city = $city;
      $data->status = $status;
      $data->date_time = $date_time;
      $data->set_time = $set_time;
      $data1->cus_id = $cus_id;
      $data1->notification_id = $notification_id;
      $data1->title = $title;
      $data1->message = $message;
      $data1->date_time = $now;
      $data1->status = '1';
      $notifiedbycustomer = $this->User->notifiedcustomerdata($data1);

      $notifiedbackupdata = $this->User->backup_notified_data($data);

      $removenotifieddata = $this->User->remove_notified_data($cus_id,$notification_id,$cat_id,$sub_cat_id,$super_sub_cat_id);
      echo '1';
     }
     }
      else
      {
      echo '2';
      }
      }
     }
     }
    }
    else if(!empty($getdata_seasonal_moving))
    {
     foreach ($getdata_seasonal_moving as $row_seasonal_moving)
    {
    $hawker_code=$row_seasonal_moving['hawker_code'];
    $getdevicedata = $this->User->get_device_data($hawker_code);
    foreach ($getdevicedata as $getdevice)
    {
    $gps_id=$getdevice['device_id'];
    $getdata2 = $this->User->check_data_by_location($gps_id);
    foreach ($getdata2 as $row2)
    {
      $rad = M_PI / 180;
     //Calculate distance from latitude and longitude
     $theta = $longitudeFrom - $row2['longitude'];
     $dist = sin($latitudeFrom * $rad) 
             * sin($row2['latitude'] * $rad) +  cos($latitudeFrom * $rad)
             * cos($row2['latitude'] * $rad) * cos($theta * $rad);

     $distance= acos($dist) / $rad * 60 *  2.250;
      if($distance<$radius)
     {
      require APPPATH . 'firebase.php';
      require APPPATH . 'push.php';
      require APPPATH . 'config.php';
      $firebase = new Firebase();
      $push = new Push();
      // optional payload
      $payload = array();
      $payload['team'] = 'India';
      $payload['score'] = '5.6';
      // notification title
      $title ='Hawkers';
      // notification message
      $message ='We have found '. $cat_data .' hawker near by you';
      // push type - single user / topic
      $push_type = 'individual';
      $push->setTitle($title);
      $push->setMessage($message);
      $push->setIsBackground(FALSE);
      $push->setPayload($payload);
      $json = '';
      $response = '';
      if ($push_type == 'topic') {
      $json = $push->getPush();
      $response = $firebase->sendToTopic('global', $json);
      } else if ($push_type == 'individual') {
      $json = $push->getPush();
      $regId =$notification_id;
      $data2 = $firebase->send($regId, $json);
      date_default_timezone_set('Asia/kolkata'); 
      $now = date('Y-m-d H:i:s');
      $data->cus_id = $cus_id;
      $data->latitude = $latitudeFrom;
      $data->longitude = $longitudeFrom;
      $data->notification_id = $notification_id;
      $data->cat_id = $cat_id;
      $data->sub_cat_id = $sub_cat_id;
      $data->super_sub_cat_id = $super_sub_cat_id;
      $data->radius = $radius;
      $data->city = $city;
      $data->status = $status;
      $data->date_time = $date_time;
      $data->set_time = $set_time;
      $data1->cus_id = $cus_id;
      $data1->notification_id = $notification_id;
      $data1->title = $title;
      $data1->message = $message;
      $data1->date_time = $now;
      $data1->status = '1';
      $notifiedbycustomer = $this->User->notifiedcustomerdata($data1);

      $notifiedbackupdata = $this->User->backup_notified_data($data);

      $removenotifieddata = $this->User->remove_notified_data($cus_id,$notification_id,$cat_id,$sub_cat_id,$super_sub_cat_id);
      echo '1';
      }
     }
      else
      {
      echo '2';
      }
      }
     }
     }
    }
   }
   }
   }
    else
    {
       echo '0';
    } 
    }
  //////////////////////////////////  Cron job ///////////////////////////////
  
    



    /*.....  Cron job for notification by after end time Seasonal and Temporary Hawker  ---- */

    
    /*...... Dump Data in history table after set time out ....... */

   public function move_data_after_set_time()
   {
    $notifieddata = $this->User->near_by_hawker_notified_data();
    if(!empty($notifieddata))
    {
     foreach ($notifieddata as $rowdata)
    {
    $cus_id=$rowdata['cus_id'];
    $mobile_no=$rowdata['mobile_no'];
    $latitudeFrom=$rowdata['latitude'];
    $longitudeFrom=$rowdata['longitude'];
    $notification_id=$rowdata['notification_id'];
    $cat_id=$rowdata['cat_id'];
    $sub_cat_id=$rowdata['sub_cat_id'];
    $super_sub_cat_id=$rowdata['super_sub_cat_id'];
    $radius=$rowdata['radius'];
    $city=$rowdata['city'];
    $set_time=$rowdata['set_time'];
    $date_time=$rowdata['date_time'];
    $f = date('H:i', strtotime($date_time));
    $data->cus_id = $cus_id;
    $data->mobile_no = $mobile_no;
    $data->latitude = $latitudeFrom;
    $data->longitude = $longitudeFrom;
    $data->notification_id = $notification_id;
    $data->cat_id = $cat_id;
    $data->sub_cat_id = $sub_cat_id;
    $data->super_sub_cat_id = $super_sub_cat_id;
    $data->radius = $radius;
    $data->city = $city;
    $data->date_time = $date_time;
    $data->set_time = $set_time;
    $data->status = '2';
    date_default_timezone_set('Asia/kolkata'); 
    $now = date('H:i');
    
    $setdata=date('H:i',strtotime('+'.$set_time.' minutes',strtotime($f)));
    
    if($now >$setdata)
   {    

     $move_data_in_history_table = $this->User->move_data_in_history_table($data);
     $remove_notification_data_in_notification_table = $this->User->remove_notification_data_in_notification_table($cus_id,$latitudeFrom,$longitudeFrom,$notification_id,$cat_id,$sub_cat_id,$super_sub_cat_id,$radius,$city,$set_time,$date_time,$status);
     echo '1';
   }
  else
  {
    echo '0';
  }
   
   }
  }
    else
    {
       echo '0';
    } 
  }

  
    /*.....  Cron job for notification by after end time Seasonal and Temporary Hawker  ---- */
  public function notification_by_duty_on_for_all_hawker()
   {
   $notifiedhawker_by_duty_on_data_all = $this->User->notifiedhawker_by_duty_on_all();

   $notifiedhawker_by_duty_on__Seasonal = $this->User->notifiedhawker_by_duty_on_Seasonals();

   foreach($notifiedhawker_by_duty_on_data_all as $rowdata)
    {
    $business_start_time=$rowdata['business_start_time'];
    $duty_status=$rowdata['duty_status'];
    $hawker_code=$rowdata['hawker_code'];
    $latitude=$rowdata['shop_latitude'];
    $longitude=$rowdata['shop_longitude'];
    date_default_timezone_set('Asia/Kolkata');
    $now = date('Y-m-d H:i:s');

    if($duty_status=='0' or $duty_status=='NULL')
    {
      $get_hawker_data = $this->User->fetch_hawker_data_for_customer($hawker_code);
      $cat_id=$get_hawker_data->cat_id;
      $sub_cat_id=$get_hawker_data->sub_cat_id;
      $super_sub_cat_id=$get_hawker_data->super_sub_cat_id;
      $string = explode(',', $cat_id);
     /* $resultcatdata = $this->User->update_catstatus_data($string);
      if($sub_cat_id!='')
      {
      $string1=explode(',', $sub_cat_id);
      $resultcatdata1 = $this->User->update_sub_cat_status_data($string1);
      }*/
    /*if($now == $ )
    { */
      $now11 =date('Y-m-d H:i:s');
      $data->seller_id = $hawker_code;
      $data->duty_status = '1';
      $data->on_time = $now11;
      $data->latitude = $latitude;
      $data->longitude = $longitude;
      $data->status='1';
      $duty_status='1';
      $duty_on_by_hawker= $this->User->turn_on_duty_by_hawker($data);
      $update_duty_status_for_hawker= $this->User->update_duty_status_hawker($hawker_code,$duty_status);
       
     /*  }*/
      }
     }

     foreach($notifiedhawker_by_duty_on__Seasonal as $rowdata1)
    {
    $business_start_time=$rowdata1['business_start_time'];
    $duty_status=$rowdata1['duty_status'];
    $hawker_code=$rowdata1['hawker_code'];
    $latitude=$rowdata1['shop_latitude'];
    $longitude=$rowdata1['shop_longitude'];
    $start_date=$rowdata1['start_date'];
    date_default_timezone_set('Asia/Kolkata');
    $nows =date('d/M/Y');
    if($nows>$start_date)
    {
    if($duty_status=='0')
    {
      $now11 =date('Y-m-d H:i:s');
      $data->seller_id = $hawker_code;
      $data->duty_status = '1';
      $data->on_time = $now11;
      $data->latitude = $latitude;
      $data->longitude = $longitude;
      $data->status='1';
      $duty_status='1';
      $duty_on_by_hawker= $this->User->turn_on_duty_by_hawker($data);
      $update_duty_status_for_hawker= $this->User->update_duty_status_hawker($hawker_code,$duty_status);
       
     /*  }*/
      }
    }
     }
    }

   public function notification_for_duty_off_by_all_hawker()
   {
   $notifiedhawker_by_duty_off_data_all = $this->User->notifiedhawker_by_duty_off_all();

   $notifiedhawker_by_duty_off_Seasonal = $this->User->notifiedhawker_by_duty_off_Seasonals();

   foreach($notifiedhawker_by_duty_off_data_all as $rowdata)
    {
    $business_close_time=$rowdata['business_close_time'];

    $duty_status=$rowdata['duty_status'];
    $hawker_code=$rowdata['hawker_code'];
    $latitude=$rowdata['shop_latitude'];
    $longitude=$rowdata['shop_longitude'];
    if($duty_status=='1' or $duty_status=='NULL')
    {
      date_default_timezone_set('Asia/Kolkata');
      $now11 =date('Y-m-d H:i:s');
      $data->seller_id = $hawker_code;
      $data->duty_status = '0';
      $data->out_time = $now11;
      $data->latitude = $latitude;
      $data->longitude = $longitude;
      $data->status='1';
      $duty_status='0';
      $duty_on_by_hawker= $this->User->turn_off_duty_by_hawker($data);
       $update_duty_status_for_hawker_off= $this->User->update_duty_status_hawker_off($hawker_code,$duty_status);
     }
     }
    foreach($notifiedhawker_by_duty_off_Seasonal as $rowdata1)
    {
    $end_date=$rowdata1['end_date'];
    $duty_status=$rowdata1['duty_status'];
    $hawker_code=$rowdata1['hawker_code'];
    $latitude=$rowdata1['shop_latitude'];
    $longitude=$rowdata1['shop_longitude'];
    $nows =date('d/M/Y');
    if($nows<$end_date)
    {
    if($duty_status=='1')
    {
      date_default_timezone_set('Asia/Kolkata');
      $now11 =date('Y-m-d H:i:s');
      $data->seller_id = $hawker_code;
      $data->duty_status = '0';
      $data->out_time = $now11;
      $data->latitude = $latitude;
      $data->longitude = $longitude;
      $data->status='1';
      $duty_status='0';
      $duty_on_by_hawker= $this->User->turn_off_duty_by_hawker($data);
       $update_duty_status_for_hawker_off= $this->User->update_duty_status_hawker_off($hawker_code,$duty_status);
     }
     }
   }
    }
  /*........................Dump Data in history table after set time out......................*/

  /*........................Activate Category after set time for hawker seacsnal......................*/

  public function tempory_hawker_category_activate_data()
   {
   $fetch_data_for_seasnal_category = $this->User->data_for_seasnal_category();
   foreach($fetch_data_for_seasnal_category as $rowdata)
    {
    $start_date=$rowdata['start_date'];
    date_default_timezone_set('Asia/Kolkata');
    $now =date('d/M/Y');
    $hawker_code=$rowdata['hawker_code'];
    $latitude=$rowdata['shop_latitude'];
    $longitude=$rowdata['shop_longitude'];
    $duty_status=$rowdata['duty_status'];
    $cat_id=$rowdata['cat_id'];
    $sub_cat_id=$rowdata['sub_cat_id'];
    if($now==$start_date)
    {
      $string = explode(',', $cat_id);
     /* $resultcatdata = $this->User->update_catstatus_data($string);
      if($sub_cat_id!='')
      {
      $string1=explode(',', $sub_cat_id);
      $resultcatdata1 = $this->User->update_sub_cat_status_data($string1);
      }*/
      $now11 =date('Y-m-d H:i:s');
      $data->seller_id = $hawker_code;
      $data->duty_status = '1';
      $data->on_time = $now11;
      $data->latitude = $latitude;
      $data->longitude = $longitude;
      $data->status='1';
      $duty_status='1';
      $duty_on_by_hawker= $this->User->turn_on_duty_by_hawker($data);
      $update_duty_status_for_hawker_off= $this->User->update_duty_status_hawker_off($hawker_code,$duty_status);
      echo '1';

     }
     }
    } 
    /*........................Activate Category after set time for hawker seacsnal......................*/ 

    /*........................deactivate Category after set time for hawker seacsnal......................*/

  public function tempory_hawker_category_deactivate_data()
   {
   $fetch_data_for_seasnal_category = $this->User->data_for_seasnal_category();
   foreach($fetch_data_for_seasnal_category as $rowdata)
    {
    $end_date=$rowdata['end_date'];
    date_default_timezone_set('Asia/Kolkata');
    $now =date('d/M/Y');
    $hawker_code=$rowdata['hawker_code'];
    $latitude=$rowdata['shop_latitude'];
    $longitude=$rowdata['shop_longitude'];
    $duty_status=$rowdata['duty_status'];
    $cat_id=$rowdata['cat_id'];
    $sub_cat_id=$rowdata['sub_cat_id'];
    if($now==$end_date)
    {
      /*$string = explode(',', $cat_id);
      $resultcatdata = $this->User->update_catstatus_data_for_deactivate($string);*/

      /*if($sub_cat_id!='')
      {
      $string1=explode(',', $sub_cat_id);
      $resultcatdata1 = $this->User->update_sub_cat_status_data_for_deactivate($string1);
      }*/
      $now11 =date('Y-m-d H:i:s');
      $data->seller_id = $hawker_code;
      $data->duty_status = '0';
      $data->out_time = $now11;
      $data->latitude = $latitude;
      $data->longitude = $longitude;
      $data->status='1';
      $duty_status='0';
      $duty_on_by_hawker= $this->User->turn_on_duty_by_hawker($data);
      $update_duty_status_for_hawker_off= $this->User->update_duty_status_hawker_off($hawker_code,$duty_status);
      $update_hawker_deactivate= $this->User->hawker_deactivate($hawker_code);

      echo '1';

     }
     }
    } 
    /*........................deactivate Category after set time for hawker seacsnal......................*/ 

    public function tempory_notification_by__duty_on_for_all_hawker()
   {
   $tempory_notifiedhawker_by_duty_on_data_all = $this->User->tempoary_notifiedhawker_by_duty_on_all();

   $tempory_notifiedhawker_by_duty_on__Seasonal = $this->User->tempory_notifiedhawker_by_duty_on_Seasonals();

   foreach($tempory_notifiedhawker_by_duty_on_data_all as $rowdata)
    {
    $business_start_time=$rowdata['business_start_time'];
    $duty_status=$rowdata['duty_status'];
    $hawker_code=$rowdata['hawker_code'];
    $latitude=$rowdata['shop_latitude'];
    $longitude=$rowdata['shop_longitude'];
    date_default_timezone_set('Asia/Kolkata');
    $now = date('Y-m-d H:i:s');

    if($duty_status=='0' or $duty_status=='NULL')
    {
      $get_hawker_data = $this->User->fetch_hawker_data_for_customer($hawker_code);
      $cat_id=$get_hawker_data->cat_id;
      $sub_cat_id=$get_hawker_data->sub_cat_id;
      $super_sub_cat_id=$get_hawker_data->super_sub_cat_id;
      $string = explode(',', $cat_id);
     /* $resultcatdata = $this->User->update_catstatus_data($string);
      if($sub_cat_id!='')
      {
      $string1=explode(',', $sub_cat_id);
      $resultcatdata1 = $this->User->update_sub_cat_status_data($string1);
      }*/
    /*if($now == $ )
    { */
      $now11 =date('Y-m-d H:i:s');
      $data->seller_id = $hawker_code;
      $data->duty_status = '1';
      $data->on_time = $now11;
      $data->latitude = $latitude;
      $data->longitude = $longitude;
      $data->status='1';
      $duty_status='1';
      $duty_on_by_hawker= $this->User->turn_on_duty_by_hawker($data);
      $update_duty_status_for_hawker= $this->User->update_duty_status_hawker($hawker_code,$duty_status);
       
     /*  }*/
      }
     }

     foreach($tempory_notifiedhawker_by_duty_on__Seasonal as $rowdata1)
    {
    $business_start_time=$rowdata1['business_start_time'];
    $duty_status=$rowdata1['duty_status'];
    $hawker_code=$rowdata1['hawker_code'];
    $latitude=$rowdata1['shop_latitude'];
    $longitude=$rowdata1['shop_longitude'];
    $start_date=$rowdata1['start_date'];
    date_default_timezone_set('Asia/Kolkata');
    $nows =date('d/M/Y');
    if($nows>$start_date)
    {
    if($duty_status=='0')
    {
      $now11 =date('Y-m-d H:i:s');
      $data->seller_id = $hawker_code;
      $data->duty_status = '1';
      $data->on_time = $now11;
      $data->latitude = $latitude;
      $data->longitude = $longitude;
      $data->status='1';
      $duty_status='1';
      $duty_on_by_hawker= $this->User->turn_on_duty_by_hawker($data);
      $update_duty_status_for_hawker= $this->User->update_duty_status_hawker($hawker_code,$duty_status);
       
     /*  }*/
      }
    }
     }
    }

    /*.....  Cron job for notification by after end time Seasonal and Temporary Hawker  ---- */
   }
