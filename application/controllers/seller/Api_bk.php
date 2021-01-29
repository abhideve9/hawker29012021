<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
 class Api extends REST_Controller {

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

  /*......... Login Api For Hawker ---- */
   public function login_post()
    {
       $response = new StdClass();
       $result = new StdClass();
       $mobile_no = $this->input->post('mobile_no');
       $device_id=$this->input->post('device_id');
       $city=$this->input->post('city');
       $sPin=$this->input->post('sPin');
       $notification_id=$this->input->post('notification_id');
       date_default_timezone_set('Asia/kolkata'); 
       $now = date('Y-m-d H:i:s');
       $result2->city=$city;
       $result2->Pincode=$sPin;
       $res2 = $this->Seller->check_city_status_seller($result2);
	   $getdata2  =  $this->db
        ->select('*')
        ->from("registration_sellers")
        ->where(['mobile_no_contact'=>$mobile_no])
        ->get()->result_array();
        if(!empty($mobile_no))
        {
        if(!empty($getdata2))
		{
       foreach ($getdata2 as $rowdata1)
        {
	  /* if($rowdata1['active_status']=='1')
        {*/
          $otpValue=mt_rand(1000, 9999);
          $data1->device_id = $device_id;
		  $data1->notification_id = $notification_id;
		  $data1->login_time=$now;
		  $data1->hawker_code=$rowdata1['hawker_code'];
		  $data1->name=$rowdata1['name'];
		  $data1->mobile_no=$rowdata1['mobile_no_contact'];
		  $data1->otp=$otpValue;
		  $data2->hawker_code=$rowdata1['hawker_code'];
		  $result2->city=$city;
          $res = $this->Seller->Add_registration_seller_data($data1);
          $res1 = $this->Seller->check_login_validate_data($data2);
          $res2 = $this->Seller->check_city_status_seller($result2);
         /* $res3 = $this->Seller->check_history_servicable_area($mobile_no); 
          $res4 = $this->Seller->check_history__not_servicable_area($mobile_no); */
          $device_id1=$res1->device_id;
          if($device_id1!=$device_id)
          {
             $data['status']  ='3';
             $data['msg']  ='Do you want to logout from other devices?';
            array_push($result,$data);
          }
          else
          {
          $res3 = $this->Seller->send_otp($mobile_no,$otpValue);
          if($res3!='')
          {
            $res4 = $this->Seller->otpgetdata($data1);
          }
          $user_type=$rowdata1['user_type'];


          if($user_type=='Moving')
          {
            $data['user_type'] =$user_type;
          	$data['Show_status'] ='1';
          }
          else if($user_type=='Seasonal')
          {
          	$seasonal_temp_fixer_type=$rowdata1['seasonal_temp_fixer_type'];
          	if($seasonal_temp_fixer_type=='Moving')
          	{
          		$data['user_type'] =$seasonal_temp_fixer_type;
          		$data['Show_status'] ='1';
          	}
          	else
          	{
          		$data['user_type'] =$seasonal_temp_fixer_type;
          		$data['Show_status'] ='0';
          	}
          }
          else if($user_type=='Temporary')
          {
             $seasonal_temp_fixer_type=$rowdata1['seasonal_temp_fixer_type'];
             	if($seasonal_temp_fixer_type=='Moving')
             	{
             		 $data['user_type'] =$seasonal_temp_fixer_type;
             		$data['Show_status'] ='1';
             	}
             	else 
             	{
             		$data['user_type'] =$seasonal_temp_fixer_type;
             		$data['Show_status'] ='0';
             	}
          }
          else if($user_type=='Fix')
          {
          	$category=$rowdata1['cat_id'];
          	if($category=='4')
          	{
          		$data['user_type'] =$user_type;
          		$data['Show_status'] ='1';
          	}
          	else
          	{	$data['user_type'] =$user_type;
          		$data['Show_status'] ='0';
          	}
          }

          $data['hawker_code'] =  $rowdata1['hawker_code'];
          $data['name'] =  $rowdata1['name'];
          $data['active_status']='1';
          $data['type']=$rowdata1['type'];
          $data['status']  ='1';
          $data['msg']  ='Your Application has been approved';
          array_push($result,$data);
        }  
       }

       $response->data = $result;
      }

      else if(empty($res2) and empty($getdata2))
         {
         $data12->device_id = $device_id;
		 $data12->mobile_no = $mobile_no;
		 $data12->notification_id = $notification_id;
		 $data12->city = $city;
		 $data12->login_time=$now;
		 $historydata_for_not_servicable_area = $this->Seller->history_data_for_not_servicable_area($data12);

      	 $data['status']  ='4';
		 $data['message'] = 'You are not servicable area';

	     array_push($result , $data);
	       $response->data = $data;
         }
       else if(!empty($res2) and empty($getdata2))
         {
	       $data13->device_id = $device_id;
		   $data13->mobile_no = $mobile_no;
		   $data13->notification_id = $notification_id;
		   $data13->city = $city;
		   $data13->login_time=$now;
		   $historydata_servicable_area_and_not_register = $this->Seller->historydata_servicable_area_and_not_register($data13);
		  /* print_r($historydata_servicable_area_and_not_register);
		   die()*/

	       $data['status']  ='2';
		  //$data['message'] = 'You are not registered user.';

	     array_push($result , $data);
	    
         }
          $response->data = $data;
     }
       else
         {
            $data['status']  ='0';
			array_push($result , $data);
         }
           $response->data = $data;
           echo json_output($response);
        }
    
		
      /*.........Login Api For Hawker ---- */



  /*.........GPS moves seller latitude and longitude  Api for moving basket ---- */

     public function seller_location_by_gps_post()
	 {
		 $response = new StdClass();
		 $result = new StdClass();
		 $latitude  = $this->input->post('latitude');
		 $longitude = $this->input->post('longitude');
		 $device_id  = $this->input->post('device_id');
		 $battery_status  = $this->input->post('battery_status');
		 date_default_timezone_set('Asia/kolkata'); 
         $now = date('Y-m-d H:i:s');
		 $data->latitude  = $latitude;
		 $data->longitude = $longitude;
		 $data->shop_gps_id = $device_id;
		 $data->battery_status = $battery_status;
		 $data->registered_time = $now;
		 $data->active_status='1';
		 $res = $this->Seller->seller_location_add_data($data);
	     if(!empty($res))
		  {
			$data1->status ='1';
			$data1->message = 'success';
			array_push($result,$data1);
			$response->data = $data1;
		  }
		  else
		  {
			$data1->status ='0';
			$data1->message = 'failed';
			 array_push($result,$data1);
			  $response->data = $data1;
		  }

		echo json_output($response);
	 }

    /*.......GPS moves seller latitude and longitude Api for moving basket  ---- */

    /*.........Notified Hawker   Api for moving basket ---- */

     public function notified_hawker_post()
	 {
		 $response = new StdClass();
		 $result = new StdClass();
		 $mobile_no  = $this->input->post('mobile_no');
		 $notification_id = $this->input->post('notification_id');
		 $device_id  = $this->input->post('device_id');
		 date_default_timezone_set('Asia/kolkata'); 
         $now = date('Y-m-d H:i:s');
		 $data1->device_id = $device_id;
		 $data1->notification_id = $notification_id;
		 $data1->date_time=$now;
		 $data1->mobile_no=$mobile_no;
		 $check_notify_data = $this->Seller->check_notified_data($mobile_no);
		 if(!empty($mobile_no))
		 {
		 if(!empty($check_notify_data))
		 {
		 	$data->status ='2';
			array_push($result,$data);
			$response->data = $data;
		 }
		 else
		  {
		  	$notifiednotregistration = $this->Seller->notified_data($data1);
			$data->status ='1';
			$data->message = 'success';
			array_push($result,$data);
			$response->data = $data;
		  }
		}
		  else
		  {
			$data->status ='0';
			$data->message = 'failed';
			 array_push($result,$data);
			  $response->data = $data;
		  }

		echo json_output($response);
	 }


    /*.......Notified Hawker   Api for moving basket  ---- */


	/*.........Category   Api For Fixer  ---- */
	/*public function category_post()
	 {
	  	$response   =   new StdClass();
		$result       =   array();
        $teachers       =  $this->db->where(['status'=>'1'])
          ->get('fixer_category')->result_array();
			if(!empty($teachers))
		   {
             foreach ($teachers as $row)
           {

            $data['id'] =   $row['id'];
            $data['cat_name']       =   $row['cat_name'];
            $data['cat_icon_image']   =   $row['cat_icon_image'];
            $data['image_url']  =   $this->User->get_image_url( 'fixer_category' , $row['cat_icon_image']);
            $data['status']  ='1';
             array_push($result,$data);
           } 
			  $response->data = $result;
         }
         else
         {
            $data['status']  ='0';
			array_push($result , $data);
         }
           $response->data = $result;
           echo json_output($response);
        }*/

      /*.........Category   Api For Fixer  ---- */

     /*.........get fixer registartion data by sales_id   Api For Fixer  ---- */
	  public function get_fixer_list_data_post()
	  {
	  	$response   =   new StdClass();
		$result       =   array();
		$sales_id =$this->input->post('sales_id');
        $getdata       =  $this->db->where(['sales_id'=>$sales_id])
                         ->get('registration_fixer')->result_array();
         
	    if(!empty($getdata))
	    {
          foreach ($getdata as $row)
        {

            $data['shop_name'] =   $row['shop_name'];
            $data['shop_city']       =   $row['shop_city'];
            $data['shop_address']   =   $row['shop_address'];
            $data['shop_id']   =   $row['shop_id'];
            $data['shop_number']   =   $row['shop_number'];
            $data['shop_latitude']   =   $row['shop_latitude'];
            $data['shop_longitude']   =   $row['shop_longitude'];
            $data['registered_time']   =   $row['registered_time'];
            $data['status']  ='1';
            array_push($result,$data);
         } 
		   $response->data = $result;
        }
        else
          {
             $data['status']  ='0';
			 $data['message'] = 'failed';
			 array_push($result , $data);
          }
           $response->data = $result;
           echo json_output($response);
        }

     /*........get fixer registartion data by sales_id  Api For Fixer  ---- */

    /*......... Get Category Api For Fixer  ---- */
	public function get_cat_data_post()
	 {
		$response = new StdClass();
		$result2 = new StdClass();
		$id = $this->input->post('fixer_id');
		$cat_id = $this->input->post('fixer_cat_id');
		$shop_id =$this->input->post('fixer_shop_id');
		if(!empty($id))
		{
			$result->id = $id;
		    $result->cat_id = $cat_id;
		    $result->shop_id =$shop_id;
		    $res = $this->Seller->Validate_catdata($result);
			$data1->status ='1';
			$data1->message = 'success';
			array_push($result2,$data1);
			$response->data = $data1;
		}
		else
		{
			$data1->status ='0';
			$data1->message = 'failed';
			array_push($result2,$data1);
			$response->data = $data1;
		}
		echo json_output($response);
	 }
      /*......... Get Category Api For Fixer  ---- */

  /*......... Get Validate fixerUser Api For Fixer  ---- */
	public function validate_active_hawker_user_post()
	 {
		$response = new StdClass();
		$result       =  new StdClass();
		$hawker_code = $this->input->post('hawker_code');
		$device_id=$this->input->post('device_id');
		$city=$this->input->post('city');
	    $result->hawker_code = $hawker_code;
	    $result1->device_id=$device_id;
	    $result2->city=$city;
		$res = $this->Seller->Validate_fixer_user($result);
		$res1 = $this->Seller->check_device_for_seller($result);
		$res2 = $this->Seller->check_city_status_seller($result2);
		$active_status=$res->active_status;
		$devicedata=$res1->device_id;
		$active_status1=$res2->active_status;
		if(!empty($res2))
		{
		  if($devicedata!=$device_id)
		 {
		 	$data1->city_status=$active_status1;
		 	$data1->active_status ='3';
		 	$data1->status ='1';
			$data1->message = 'Do you want to logout from other devices?';
			 array_push($result,$data1);
			 $response->data = $data1;
		 }
	     else if($active_status=='1')
		  {
		  	$data1->city_status=$active_status1;
		  	$data1->active_status='1';
			$data1->status ='1';
			$data1->message = 'Active';
			 array_push($result,$data1);
			 $response->data = $data1;
		  }
		  else if($active_status=='0')
		  {
		  	$data1->city_status=$active_status1;
		  	$data1->active_status='0';
		  	$data1->status ='1';
			$data1->message = $message;
			 array_push($result,$data1);
			 $response->data = $data1;
		  }
		   else if($active_status=='2')
		  {
		  	$data1->city_status=$active_status1;
		  	$data1->active_status='1';
		  	$data1->status ='1';
			$data1->message = 'pending';
			 array_push($result,$data1);
			 $response->data = $data1;
		  }
		  else 
		  {
		  	$data1->city_status ='0';
		  	$data1->active_status =$active_status;
			$data1->status ='1';
			$data1->message = 'failed';
			 array_push($result,$data1);
			 $response->data = $data1;
		  }
		 
		}
		  else
		  {
		  	$data1->city_status ='0';
		  	if($active_status=='1')
		  	{
		  	$data1->active_status =$active_status;
		    }
		    else
		    {
		    $data1->active_status ='0';
		    }
			$data1->status ='0';
			$data1->message = 'failed';
			 array_push($result,$data1);
			 $response->data = $data1;
		  }
		  echo json_output($response);
	 }

   /*......... Get Validate fixerUser Api For Fixer  ---- */

     /*.........send  Dieloge box message  Api For hawker  ---- */
	 public function send_message_post()
	  {
	  	$response   =   new StdClass();
		$result       =   array();
        $sendmessage       =  $this->db->where(['status'=>'1'])
          ->get('message_dialogue')->result_array();
			if(!empty($sendmessage))
			{
            foreach ($sendmessage as $row)
           {
            $data['id'] =   $row['id'];
            $data['message'] =   $row['message'];
            $data['type']   =   $row['type'];
            $data['status']  = $row['status'];
            array_push($result,$data);
           } 
			  $response->data = $result;
         }
           else
            {
              $data['status']  ='0';
			  array_push($result , $data);
            }
             $response->data = $result;
             echo json_output($response);
         }

     /*.........send  Dieloge box message  Api For hawker  ---- */
      /*......... duty on/off Api For hawker  ---- */
	 public function duty_on_off_by_seller_post()
	 {
		$response = new StdClass();
		$result       =  new StdClass();
		$hawker_code = $this->input->post('hawker_code');
		$longitude =$this->input->post('longitude');
		$latitude=$this->input->post('latitude');
		$duty_status=$this->input->post('duty_status');
		$notification_id =$this->input->post('notification_id');
		date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
		if($duty_status=='1')
		{
	  
		require APPPATH . 'libraries/firebase.php';
		require APPPATH . 'libraries/push.php';
		require APPPATH . 'libraries/config.php';
		$firebase = new Firebase();
        $push = new Push();
        // optional payload
        $payload = array();
        $payload['team'] = 'India';
        $payload['score'] = '5.6';
        // notification title
        $title ='Duty';
        // notification message
        $message ='ON';
        
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
        $data4 = $firebase->send($regId, $json);
        }

        function notification()
        {
        require APPPATH . 'libraries/firebase.php';
		require APPPATH . 'libraries/push.php';
		require APPPATH . 'libraries/config.php';
		$firebase = new Firebase();
        $push = new Push();
        // optional payload
        $payload = array();
        $payload['team'] = 'India';
        $payload['score'] = '5.6';
        // notification title
        $title ='Duty';
        // notification message
        $message ='ON';
        
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
        $data4 = $firebase->send($regId, $json);
        }
         setTimeout(notification(), 15000);
        }
	    $data->seller_id=$hawker_code;
		$data->longitude=$longitude;
		$data->latitude=$latitude;
		$data->duty_status=$duty_status;
		$data->on_time=$now;
		$data->status='1';
		$resvaluse = $this->Seller->Validate_fixer_user_data($hawker_code);
        $active_status=$resvaluse->active_status;
        if($active_status=='1')
        {
		$res = $this->Seller->duty_data_by_seller($data);
		$duty_statusdata = $this->Seller->update_duty_status_data($hawker_code,$duty_status);

	    }
		}
		else if($duty_status==0)
		{
	    $data->seller_id=$hawker_code;
		$data->longitude=$longitude;
		$data->latitude=$latitude;
		$data->duty_status=$duty_status;
		$data->out_time=$now;
		$data->status='1';
		$resvaluse = $this->Seller->Validate_fixer_user_data($hawker_code);
        $active_status=$resvaluse->active_status;
        if($active_status=='1')
        {
		$res = $this->Seller->duty_data_by_seller($data);
		$duty_statusdata = $this->Seller->update_duty_status_data($hawker_code,$duty_status);
	    }
		}
		else if($duty_status==2)
		 {
		    $hawker_code = $this->input->post('hawker_code');
		  	$resdata = $this->Seller->check_duty_data_by_seller($hawker_code);
		  	$duty_status1 = $resdata->duty_status;
		 }
	    if(!empty($data))
		 {	
		 	$resvaluse = $this->Seller->Validate_fixer_user_data($hawker_code);
            $active_status=$resvaluse->active_status;
           if($active_status=='2')
       { 
            $data1->duty_status=$duty_status;
		 	$data1->messagedata=$data4;
		    $data1->active_status=$active_status;
			$data1->status ='1';
			$data1->message = 'success';
			$data1->active_message  ='Your application has not been verified yet. Please wait for some time';
			 array_push($result,$data1);
			 $response->data = $data1;
		}
       
       else if($active_status=='0')
        { 
            $data1->duty_status=$duty_status;
		 	$data1->messagedata=$data4;
		    $data1->active_status=$active_status;
			$data1->status ='1';
			$data1->message = 'success';
			$data1->active_message ='Your Application has been rejected';
			 array_push($result,$data1);
			 $response->data = $data1;
        }
        else
        {
        	$resultdata->hawker_code = $hawker_code;
		    $get_hawker_data = $this->Seller->fetch_hawker_data_for_customer($resultdata);
		    $cat_id=$get_hawker_data->cat_id;
		    $sub_cat_id=$get_hawker_data->sub_cat_id;
		    $super_sub_cat_id=$get_hawker_data->super_sub_cat_id;
		    $string = explode(',', $cat_id);
            $resultcatdata = $this->Seller->update_catstatus_data($string);
            if($sub_cat_id!='')
            {
            $string1=explode(',', $sub_cat_id);
            $resultcatdata = $this->Seller->update_sub_cat_status_data($string1);
            }

        	$data1->duty_status=$duty_status;
		 	$data1->messagedata=$data4;
		    $data1->active_status=$active_status;
			$data1->status ='1';
			$data1->message = 'success';
			$data1->active_message ='Your Application has been approved';
			 array_push($result,$data1);
			 $response->data = $data1;
        }	
		 
		}
		 else if(!empty($resdata))
		 {
		 	$resvaluse = $this->Seller->Validate_fixer_user_data($hawker_code);
            $active_status=$resvaluse->active_status;
            if($active_status=='2')
         { 
		 	$data1->duty_status=$duty_status1;
		 	$data1->active_status =$active_status;
			$data1->status ='1';
			$data1->message = 'success';
			$data1->active_message  ='Your application has not been verified yet. Please wait for some time';
			 array_push($result,$data1);
			 $response->data = $data1;
			}
			else if($active_status=='0')
			{
			$data1->duty_status=$duty_status1;
		 	$data1->active_status =$active_status;
			$data1->status ='1';
			$data1->message = 'success';
			$data1->active_message  ='Your Application has been rejected';
			 array_push($result,$data1);
			 $response->data = $data1;

			}
			else
			{
		    $resultdata->hawker_code = $hawker_code;
		    $get_hawker_data = $this->Seller->fetch_hawker_data_for_customer($resultdata);
		    $cat_id=$get_hawker_data->cat_id;
		    $sub_cat_id=$get_hawker_data->sub_cat_id;
		    $super_sub_cat_id=$get_hawker_data->super_sub_cat_id;
		    $string = explode(',', $cat_id);
            $resultcatdata = $this->Seller->update_catstatus_data($string);
            if($sub_cat_id!='')
            {
            $string1=explode(',', $sub_cat_id);
            $resultcatdata = $this->Seller->update_sub_cat_status_data($string);
            }
			$data1->duty_status=$duty_status1;
		 	$data1->active_status =$active_status;
			$data1->status ='1';
			$data1->message = 'success';

			$data1->active_message  ='Your Application has been approved';
			 array_push($result,$data1);
			 $response->data = $data1;

			}
		 }
		 else
		  {
		   $data1->duty_status='0';
			$data1->status ='0';
			$data1->message = 'failed';
			 array_push($result,$data1);
			 $response->data = $data1;
		  }

		echo json_output($response);
	 }
   /*.........  duty on/off Api For hawker  ---- */
    

   /*.........Profile data for seller Api For hawker  ---- */
	 public function seller_profile_post()
	  {
	    $response =   new StdClass();
		$result       =  new StdClass();
		$hawker_code =$this->input->post('hawker_code');
		$city=$this->input->post('city');
		$sPin=$this->input->post('sPin');
		$version_name = $this->input->post('version_name');
		$version_code =$this->input->post('version_code');
		$result2->city=$city;
		$result2->Pincode=$sPin;
		$data->hawker_code=$hawker_code;
		$versiondata->version_name = $version_name;
		$versiondata->version_code = $version_code;
		/*$data23->hawker_code=$hawker_code;
		$data23->city=$city;
		$history_profile_data=$this->Seller->history_profile($data23);*/
	    $resdata = $this->Seller->check_data_seller_profile($data);
	    $res2 = $this->Seller->check_city_status_seller($result2);
	    $res = $this->Seller->Validate_version_data($versiondata);
		$active_status1=$res2->status;
		if($active_status1=='')
		{
			$active_status1='0';
		}
	    $id = $resdata->id;
	    $shop_id1=$resdata->hawker_code;
	    $name=$resdata->name;
	    $address=$resdata->address;
		$shop_name=$resdata->shop_name;
		$business_name=$resdata->business_name;
		$city_address=$resdata->city_address;
		$business_mobile_number=$resdata->business_mobile_no;
		$hawker_register_address=$resdata->hawker_register_address;
		$type=$resdata->type;
	    if(!empty($resdata))
		{
		    $resdata = $this->Seller->check_duty_data_by_seller($hawker_code);
		    $duty_status1 = $resdata->duty_status;
		    $resdata = $this->Seller->check_total_count_call($hawker_code);
		    $bannerClickResult = $this->Seller->check_total_count_bannerClick($hawker_code);
		   // print_r($bannerClickResult);exit;
		    $bannerClickResultFree = $this->Seller->check_total_count_bannerClickFree($hawker_code);
		    $categoryResult=$this->Seller->getFixerCategoryCountRecord($hawker_code);
		    	
		    //print_r($bannerClickResultFree);exit;
		if(!empty($categoryResult))
		    {
		    	foreach($categoryResult AS $value)
		    	{
		    		$catString .=','."" . implode ( "','", $value ) . "";
                                  //$catString .=','."'" . implode ( "', '", $value ) . "'";

		    	}

		    	$catStringString=ltrim($catString,',');
		    	
		    }
		   //print_r($catStringString);exit;
                    $catReesult=$this->Seller->getFixerCategoryCountRecord2($catStringString);

		    if($resdata>0)
		    { 
		     $data1->total_call=$resdata;
	             $data1->totalclick=MAX($bannerClickResult,$bannerClickResultFree);
                     $data1->totalCategoryclick=$catReesult;
                    
		    }
	else if($resdata==0)
            {
             $data1->total_call ='0';
             $data1->totalclick=MAX($bannerClickResult,$bannerClickResultFree);
              $data1->totalCategoryclick=$catReesult;

            }
            if($duty_status1!='')
            {
            $data1->duty_status=$duty_status1;
            //$data1->totalclick=$duty_status1;
            }
            else
            {
            	$data1->duty_status='0';
                //$data1->totalclick='0';
            }
           	//print_r( $data1->totalclick);exit;

			$data1->id=$id;
		  	$data1->hawker_code=$shop_id1;
		  	$data1->name=$name;
		  	$data1->business_name=$business_name;
		  	$data1->city_status=$active_status1;
		  	if($active_status1=='0')
		  	{
		  		$data1->city_message='You are not in serviceable area.';
		  	}
		  	/*$data1->fix_address=$address;*/
		  	//$data1->image_url=base_url().'assets/upload/Profile_image/'.$shop_id1.'.jpeg';
		  	$data1->image_url='http://10.0.0.15/fixer_goolean/assets/upload/Profile_image/'.$name.'.jpeg';

		 if($res!='')
	         {
	           $data1->version_status ='1';
	         }
	         else
	         {
	         	$data1->version_status ='0';
	         }
		  	$data1->city_address=$city_address;
		  	$data1->business_mobile_no=$business_mobile_number;
		  	$data1->hawker_register_address=$hawker_register_address;
		  	$data1->type=$type;
			$data1->status ='1';
			//print_r( $data1->totalclick);exit;
			//print_r($data1);exit;
			array_push($result,$data1);
			$response->data = $data1;
        }
          else
           {
             $data1->status ='0';
			 $data1->message = 'failed';
			 array_push($result,$data1);
			 $response->data = $data1;
           }	
           echo json_output($response);
       }

      /*.........Profile data for seller Api For hawker  ---- */

       /*......... logout Api For Door hawker ---- */
    	public function data_logout_for_seller_post()
     {
		$response = new StdClass();
		$result = array();
		$device_id =$this->input->post('device_id');
		$hawker_code =$this->input->post('hawker_code');
		date_default_timezone_set('Asia/kolkata'); 
		$longitude =$this->input->post('longitude');
		$latitude=$this->input->post('latitude');
        $now = date('Y-m-d H:i:s');
        $data3->latitude = $latitude;
        $data3->longitude = $longitude;
        $data3->seller_id = $hawker_code;
	    $data3->duty_status ='0';
	    $data3->status ='1';
	    $data3->out_time =$now;
        $data->hawker_code = $hawker_code;
		$data->logout_time=$now;
		$resdata1 = $this->Seller->check_logout_data_seller($hawker_code);
		$device_id1 = $resdata1->device_id;
	     if($hawker_code!='')
	    {
	    $data4->hawker_code = $hawker_code;
	    $data4->duty_status ='0';
	    $data->hawker_code = $hawker_code;
		$data->logout_time=$now;
	    $data2 = $this->Seller->logout_seller_data($data);
	    $resdata1 = $this->Seller->insert_duty_status__for_seller($data3);
	    $resdata2 = $this->Seller->update_duty_status__for_seller($data4);
        $data1->status ='1';
		$data1->message='logout success';
		array_push($result,$data1);
		$response->data = $data1;
	    }
        else
        {
        	$data1->status ='0';
        	$data1->message ='logout failed';
			array_push($result,$data1);
		   $response->data = $data1;
        }
		 echo json_output($response);
	 }
    /*......... logout data From Wifi-module Api For Door Unlock ---- */
     /*......... status check api for  hawker ---- */
    	public function status_check_data_post()
     {
		$response = new StdClass();
		$result = array();
		$status =$this->input->post('status');
		$mobile_no =$this->input->post('mobile_no');
		$device_id =$this->input->post('device_id');
		$notification_id =$this->input->post('notification_id');
	    date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
		if($status=='1')
		{
		require APPPATH . 'libraries/firebase.php';
		require APPPATH . 'libraries/push.php';
		require APPPATH . 'libraries/config.php';
	    $data->mobile_no = $mobile_no;
	    $data->device_id = $device_id;
	    $data->notification_id = $notification_id;
	    $data->login_time=$now;
	    $res1 = $this->Seller->fetch_login_data($data);
	    $res2 = $this->Seller->fetch_hawker_data($data);
        $name=$res1->name;
        $seller_id=$res1->user_id;
        $hawker_code=$res2->hawker_code;
        $user_type=$res2->user_type;
        $otpValue=mt_rand(1000, 9999);
	    $data1->device_id = $device_id;
	   
		$data1->notification_id = $notification_id;
        $data1->mobile_no=$mobile_no;
        $data1->hawker_code=$seller_id;
        $data1->otp=$otpValue;
        $res3 = $this->Seller->send_otp($mobile_no,$otpValue);
        if($res3!='')
        {
          $res4 = $this->Seller->otpgetdata($data1);
        }
        $type=$res2->type;
        $notificationdata=$res1->notification_id;
        $data2 = $this->Seller->update_login_data($data);
        $firebase = new Firebase();
        $push = new Push();
        // optional payload
        $payload = array();
        $payload['team'] = 'India';
        $payload['score'] = '5.6';
        // notification title
        $title ='logout';
        // notification message
        $message ='hello';
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
            $regId =$notificationdata;
            $data4 = $firebase->send($regId, $json);
            $data5->messagedata=$data4;
            $data5->status ='1';
            $data5->Show_status='1';
            $data5->name =$name;
            $data5->user_type =$user_type;
            $data5->hawker_code =$hawker_code;
            $data5->type =$type;
            $data5->active_status ='1';
		    array_push($result,$data5);
		    $response->data = $data5;
        }
	    }
        else
        {
        	$data1->status ='0';
			array_push($result,$data1);
		   $response->data = $data1;
        }
		echo json_output($response);
	 }
	 /* ---------------status check api for  hawker --------------*/
	   /*.........Total call for  seller Api For hawker  ---- */
	 public function total_call_seller_post()
	  {
	    $response =   new StdClass();
		$result       =  new StdClass();
		$hawker_code =$this->input->post('hawker_code');
	    $resdata = $this->Seller->check_total_count_call($hawker_code);
	    $hawker_code = $resdata->hawker_code;
	    if($resdata>0)
		{    
           	$data1->total_call=$resdata;
			$data1->status ='1';
			array_push($result,$data1);
			$response->data = $data1;
        }
        else if($resdata==0)
         {
            $data1->total_call ='0';
			$data1->status = '1';
			array_push($result,$data1);
			$response->data = $data1;
         }
          else 
           {
              $data1->status ='0';
			  $data1->message = 'failed';
			  array_push($result,$data1);
			  $response->data = $data1;
           }
            	
           echo json_output($response);
       }

      /*.........Total call for  seller Api For hawker  ---- */

       /*.........Verification OTP Api For Hawker  ---- */
	 public function verification_otp_data_post()
	  {
	  	$response   =   new StdClass();
		$result       =  new StdClass();
		$mobile_no =$this->input->post('mobile_no');
		$device_id =$this->input->post('device_id');
	    $otp =$this->input->post('otp');
	    $data1->device_id = $device_id;
	    $data1->mobile_no = $mobile_no;
        $data1->otp=$otp;
		$dataotp = $this->Seller->verification_otp($data1);
	    if(!empty($dataotp))
	    {	
			$data->status = '1';
			array_push($result,$data);
			$response->data = $data;
        }
        else
        {
             $data->status = '0';
			array_push($result,$data);
			$response->data = $data;
          
        }
           
           echo json_output($response);
        }

       /*.........Verification OTP Api For Hawker  ---- */

      /*.........Resend OTP Api For Hawker  ---- */
	 public function resend_otp_data_post()
	  {
	  	$response   =   new StdClass();
	    $result       =  new StdClass();
		$device_id =$this->input->post('device_id');
	    $mobile_no =$this->input->post('mobile_no');
	    $otpValue=mt_rand(1000, 9999);
	    $data1->device_id = $device_id;
        $data1->mobile_no=$mobile_no;
        $data1->otp=$otpValue;
		$res = $this->Seller->send_otp($mobile_no,$otpValue);
        if(!empty($mobile_no))
        {
            $res1 = $this->Seller->resend_otp($data1);
            $data->status = '1';
			array_push($result,$data);
			$response->data = $data;
        }

        else
        {
             $data->status = '0';
			array_push($result,$data);
			$response->data = $data;
        }  
           echo json_output($response);
        }

       /*.........Resend OTP Api For Hawker  ---- */

       /*.........Remove OTP Api For Hawker  ---- */
	 public function otp_expire_post()
	  {
	  	$response   =   new StdClass();
		$result       =  new StdClass();
		$device_id =$this->input->post('device_id');
	    $mobile_no =$this->input->post('mobile_no');
	    $data1->device_id = $device_id;
        $data1->mobile_no=$mobile_no;
		$res = $this->Seller->remove_otp($data1);
        if(!empty($mobile_no))
        {
            $data->status = '1';
			array_push($result,$data);
			$response->data = $data;
        }

        else
        {
           $data->status = '0';
			array_push($result,$data);
			$response->data = $data;
        }
        
           
           echo json_output($response);
        }

       /*.........Remove OTP Api For Hawker  ---- */

     /*......... Get Check Version data   ---- */
	public function app_check_version_post()
	 {
		$response = new StdClass();
		$result2 = new StdClass();
		/*$id = $this->input->post('fixer_id');*/
		$version_name = $this->input->post('version_name');
		$version_code =$this->input->post('version_code');
	    $result->version_name = $version_name;
		$result->version_code = $version_code;
	    $res = $this->Seller->Validate_version_data($result);

	    $version_name_data=$res->version_name;
        $version_code_data=$res->version_code;
        $update_code_status=$res->update_code_status;

	    if($version_code_data==$version_code)
        {
         $data1->status ='1';
         $data1->message = 'success';
         array_push($result2,$data1);
         $response->data = $data1;
        }

        else if($version_code_data<$version_code)
        {
        $res2 = $this->Seller->update_version_data($result);
        $data1->status ='1';
        $data1->message = 'success';
        array_push($result2,$data1);
        $response->data = $data1;

        }
        else if($version_code_data>$version_code)
       {
        $data1->status ='0';
        $data1->update_status =$update_code_status;
        $data1->message = 'A new update is available on the Play Store.
If you want to update press press button.';
        array_push($result2,$data1);
        $response->data = $data1;
       }
      else
      {
      /*$res2 = $this->Customer->update_version_data($result);*/
      $data1->status ='0';
      $data1->message = 'Update Your Application';
      array_push($result2,$data1);
      $response->data = $data1;
      }
      echo json_output($response);
		
		
	 }
      /*......... Get Check Version data  ---- */


      /*.........Show data for navigate customer ---- */
	  public function navigate_customer_data_post()
	  {
	  	$response   =   new StdClass();
		$result       =   array();
		$hawker_code =$this->input->post('hawker_code');
		$customer_mobile_no =$this->input->post('customer_mobile_no');
        $getdata       =  $this->db->where(['hawker_code'=>$hawker_code,'close_status'=>'0'])
                         ->get('tbl_show_location_by_hawker')->result_array();
         
	    if(!empty($getdata))
	    {
         foreach ($getdata as $row)
	    
        {
        $customer_mobile_no=$row['customer_mobile_no'];

         $getdata1     =  $this->db->where(['mobile_no'=>$customer_mobile_no])
                         ->get('registration_customer')->result_array();
          foreach ($getdata1 as $row1)
        {           
        	$customer_name=$row1['name'];
        	if(!empty($customer_name))
        	{
        		$data['customer_name'] = $customer_name;
        	}
        	else
        	{
        		$data['customer_name'] = '';
        	}

            $data['customer_mobile_no'] =   $row['customer_mobile_no'];
            $data['latitude']       =   $row['latitude'];
            $data['longitude']   =   $row['longitude'];
            $data['location_name'] =   $row['location_name'];
            $data['date_time']   =   $row['date_time'];
            $data['status']  ='1';
            array_push($result,$data);
         } 
       }
		   $response->data = $result;
        }
        else
          {
             $data['status']  ='0';
			 $data['message'] = 'failed';
			 array_push($result , $data);
          }
           $response->data = $result;
           echo json_output($response);
        }

     /*........get fixer registartion data by sales_id  Api For Fixer  ---- */


     /*.........close_share_location_by_customerr ---- */

	  public function close_share_location_by_customer_post()
	  {
	  	$response   =   new StdClass();
		$result       =   array();
		$hawker_code =$this->input->post('hawker_code');
		$hawker_mobile_no =$this->input->post('hawker_mobile_no');
		$customer_mobile_no =$this->input->post('customer_mobile_no');
		$close_status =$this->input->post('close_status');
		$description =$this->input->post('description');
		$close_latitude =$this->input->post('close_latitude');
		$close_longitude =$this->input->post('close_longitude');
		$data->hawker_code = $hawker_code;
	    $data->hawker_mobile_no = $hawker_mobile_no;
	    $data->customer_mobile_no = $customer_mobile_no;
	    $data->close_status = $close_status;
	    $data->description = $description;
	    $data->close_latitude = $close_latitude;
	    $data->close_longitude = $close_longitude;
        $res = $this->Seller->close_share_location_by_customer($data);
        if(!empty($hawker_code))
        {
        $data1->status ='1';
        $data1->message ='Your data update successfully.';
        array_push($result,$data1);
        $response->data = $data1;
        }
       else
       {
	      $data1->status ='0';
	      $data1->message ='failed';
	      array_push($result,$data1);
	      $response->data = $data1;
       }
    echo json_output($response);
        }

     /*........close_share_location_by_customer   ---- */


     /*.........Show data for navigate customer ---- */
	  public function navigate_customer_history_data_post()
	  {
	  	$response   =   new StdClass();
		$result       =   array();
		$hawker_code =$this->input->post('hawker_code');
		$customer_mobile_no =$this->input->post('customer_mobile_no');
	    $getdata = $this->Seller->history_data_for_hawker($hawker_code);

		/*          
        $getdata       =  $this->db
		                  ->select('*')
		                  ->from("tbl_show_location_by_hawker_history")
		                  ->where(['hawker_code'=>$hawker_code,'description'!=>''])
		                   ->order_by('date_time', 'DESC')
		                  ->get()->result_array();*/
         
	    if(!empty($getdata))
	    {
         foreach ($getdata as $row)
	    
        {
        $customer_mobile_no=$row['customer_mobile_no'];

         $getdata1     =  $this->db->where(['mobile_no'=>$customer_mobile_no])
                         ->get('registration_customer')->result_array();
         foreach ($getdata1 as $row1)
         {           
        	$customer_name=$row1['name'];
        	if(!empty($customer_name))
        	{
        		$data['customer_name'] = $customer_name;
        	}
        	else
        	{
        		$data['customer_name'] = '';
        	}

            $data['customer_mobile_no'] =   $row['customer_mobile_no'];
            $data['latitude']       =   $row['latitude'];
            $data['longitude']   =   $row['longitude'];
            $data['location_name'] =   $row['location_name'];
            $data['description']   =   $row['description'];
            $data['date_time']   =   $row['close_date_time'];
            $data['close_status']   =   $row['close_status'];
            $data['status']  ='1';
            array_push($result,$data);
         } 
       }
		   $response->data = $result;
        }
        else
          {
             $data['status']  ='0';
			 $data['message'] = 'failed';
			 array_push($result , $data);
          }
           $response->data = $result;
           echo json_output($response);
        }

     /*........get fixer registartion data by sales_id  Api For Fixer  ---- */

     /*.........Request for Offer advertisement Api for fixer ---- */

     public function request_for_hawker_advertisement_post()
	 {
		 
		 $response = new StdClass();
		 $result = new StdClass();
		 $hawker_code = $this->input->post('hawker_code');
		 $mobile_no = $this->input->post('mobile_no');
		 $advertisement_title = $this->input->post('advertisement_title');
		 $detail_of_advertisement = $this->input->post('detail_of_advertisement');
		 $start_date  = date("Y-m-d",strtotime(str_replace('/','-',$this->input->post('start_date'))));
		 $end_date  =date("Y-m-d",strtotime(str_replace('/','-',$this->input->post('end_date'))));
		 $image_1  = $this->input->post('image_1');
		 $image_2  = $this->input->post('image_2');
		
		// $latitude  = $this->input->post('latitude');
		 //$longitude  = $this->input->post('longitude');
		// $address  = $this->input->post('address');

		 date_default_timezone_set('Asia/kolkata'); 
         $now = date('Y-m-d H:i:s');
         $data->hawker_code  = $hawker_code;
       	 $data->mobile_no  = $mobile_no;
		 $data->advertisement_title  = $advertisement_title;
		 $data->detail_of_advertisement = $detail_of_advertisement;
		 $data->start_date = $start_date;
	         $duration=$this->Seller->getFreePlanDays();
		 $data->end_date =  date("Y-m-d", strtotime("$start_date +$duration day" ));
		 $data->image_1 = $image_1;
		 $data->image_2 = $image_2;
		 //$data->latitude = $latitude;
		 //$data->longitude = $longitude;
		 //$data->address = $address;

		 $data->date_time = $now;
		 $data->status='1';
		 $checkHawker=$this->Seller->checkFreeHawker($hawker_code);
		 if(!empty($checkHawker))
		 {
		 			$data1->status ='0';
					$data1->message = 'Only one time service';
					array_push($result,$data1);
					$response->data = $data1;
		 }else
		 {
		 	 $this->Seller->updateHawkers($hawker_code);
		 	 $res = $this->Seller->request_for_hawker_advertisements($data);
			     if(!empty($res))
				  {
					$data1->status ='1';
					$data1->message = 'success';
					array_push($result,$data1);
					$response->data = $data1;
				  }
				  else
				  {
					$data1->status ='0';
					$data1->message = 'failed';
					array_push($result,$data1);
					$response->data = $data1;
				  }
		 }

		echo json_output($response);
	 }

    /*.......GPS moves seller latitude and longitude Api for moving basket  ---- */

    /*.........count_hawker_referral_code ---- */

     public function count_hawker_referral_code_post()
	 {
		 $response = new StdClass();
		 $result = new StdClass();
		 $mobile_no = $this->input->post('mobile_no');
		 $money='10';
		 date_default_timezone_set('Asia/kolkata'); 
         $now = date('Y-m-d');

		$query=$this->db->query("select * FROM tbl_hawker_referal_code_for_customer  where referal_code='$mobile_no' and referral_flag_status='1' and limit_status!='1'");

		$query1=$this->db->query("select * FROM tbl_hawker_referal_code_for_customer  where referal_code='$mobile_no' and date='$now' and (referral_flag_status='1' or referral_flag_status='0' )");
        $num_rows1=$query1->num_rows();
        $num_rows=$query->num_rows();
	      if($num_rows>0)
		  {
		  	$data1->total_count =$num_rows1;
			$data1->count =$num_rows *$money;
			$data1->status = '1';
			$data1->message = 'success';
			array_push($result,$data1);
			$response->data = $data1;
		  }
		  else
		  {
		  	$data1->total_count =$num_rows1;
		  	$data1->count =$num_rows;
			$data1->status ='0';
			$data1->message = 'failed';
			 array_push($result,$data1);
			  $response->data = $data1;
		  }

		echo json_output($response);
	 }

    /*......count_hawker_referral_code  ---- */

    /*.........Received Referral money API for Hawker Merchant ---- */

     public function received_referral_money_post()
	 {
		$response = new StdClass();
		$result = new StdClass();
		$mobile_no = $this->input->post('mobile_no');
		$money=$this->input->post('money');
		$res = $this->Seller->referral_money_data($mobile_no);
	    if($res==1)
		{
		 date_default_timezone_set('Asia/kolkata'); 
         $now = date('Y-m-d H:i:s');

         $data->hawker_referral_money  = $money;
         $data->hawker_mobile_no  = $mobile_no;
		 $data->date_time = $now;
		 $res = $this->Seller->history_for_received_money($data);
		 $data1->status = '1';
		 $data1->message = 'success';
		 array_push($result,$data1);
		 $response->data = $data1;
		 }
		else
		{
			$data1->status ='0';
			$data1->message = 'failed';
			array_push($result,$data1);
			$response->data = $data1;
		}

		echo json_output($response);
	 }

    /*......Received Referral money API for Hawker Merchant ---- */

    /*.........history detail of received referral money for merchant hawker  ---- */
	 public function history_detail_for_received_money_hawker_post()
	  {
	  	$response   =   new StdClass();
		$result       =   array();
		$mobile_no = $this->input->post('mobile_no');


/*$this->db1->where('tennant_id', $tennant_id);
$this->db1->order_by('id', 'DESC');
return $this->db1->get('courses')->result();*/


        $moneydetail       =$this->db
                  ->select('*')
                  ->from("tbl_history_for_received_money_by_hawker")
                  ->where(['hawker_mobile_no'=>$mobile_no])
                  ->order_by("date_time", "DESC")
                  ->get()->result_array();
         /* $this->db->where(['hawker_mobile_no'=>$mobile_no]);
        					  $this->db->order_by("date_time", "DESC");
                              ->get('tbl_history_for_received_money_by_hawker')->result_array();*/
			if(!empty($moneydetail))
			{
            foreach ($moneydetail as $row)
           {
            $data['money'] =   $row['hawker_referral_money'];
            $data['date_time'] =   $row['date_time'];
            $data['status']  = '1';
            array_push($result,$data);
           } 
			  $response->data = $result;
         }
           else
            {
              $data['status']  ='0';
			  array_push($result , $data);
            }
             $response->data = $result;
             echo json_output($response);
         }
     /*.........history detail of received referral money for merchant hawker  ---- */


public function insert_paid_advertisement_post()
{
// print_r('expression');exit;
	try
	{
		 date_default_timezone_set('Asia/kolkata'); 
 		 $hawker_code 					                   =$this->input->post('hawker_code');
		 $mobile_no 					                     =$this->input->post('mobile_no');
		 $advertisement_title 			               =$this->input->post('advertisement_title');
		 $detail_of_advertisement 		             =$this->input->post('detail_of_advertisement');
		 $start_date  					                   =$this->input->post('start_date');
		 $end_date  					                     =$this->input->post('end_date');
		 $image_1  						                     =$this->input->post('image_1');
		 $image_2  						                     =$this->input->post('image_2');
		 $image_3  						                     =$this->input->post('image_3');
		 $image_4  						                     =$this->input->post('image_4');
		 $banner_img 					                     =$this->input->post('banner_img');
		$is_editable 					                     =$this->input->post('choice');
     $now 							                       =date('Y-m-d H:i:s');

     if(!empty($hawker_code) && !empty($banner_img) && !empty($advertisement_title) && !empty($detail_of_advertisement))
     {
           $max_id=$this->Seller->getMax($hawker_code);
   
            // print_r($max_id);exit;

           $checkMerchant=$this->Seller->checkHawker($hawker_code);

           if(!empty($checkMerchant))
           {
             //$payment_status   ='Pending';
             //$ads_status       ='Waiting';
		$payment_status   ='Paid';
               $ads_status       ='Ongoing';

             $user_type        ='First';
	     //$end_date         ='';
 	     $duration=$this->Seller->getPaidPlanDays();
	     $end_date         =date("Y-m-d", strtotime("$new_date +$duration day" ));


           }else
           {
	    $new_date=date("Y-m-d",strtotime(str_replace('/','-',$start_date)));
            $payment_status   ='Paid';
            $ads_status       ='Ongoing';
            $user_type        ='First';
	    $duration=$this->Seller->getPaidPlanDays();
	    $end_date         =date("Y-m-d", strtotime("$new_date +$duration day" ));
           }

          $paid_array=array(

                  'hawker_code'               =>$hawker_code,
                  'mobile_no'                 =>$mobile_no,
                  'advertisement_title'       =>$advertisement_title,
                  'detail_of_advertisement'   =>$detail_of_advertisement,
                  'start_date'                =>date("Y-m-d",strtotime(str_replace('/','-',$start_date))),
                  'image_1'                   =>$image_1,
                  'image_2'                   =>$image_2,
                  'image_3'                   =>$image_3,
                  'image_4'                   =>$image_4,
                  'banner_img'                =>$banner_img,
                  'ads_id'                    =>empty($max_id)?'1':$max_id,
                  'payment_status'            =>$payment_status,
                  'ads_status'                =>$ads_status,
		   'end_date'                  =>$end_date,
		'is_editable'			 =>$is_editable,
                  'date_time'                 =>$now
           );
          $result =$this->Seller->paid_advertisement($paid_array);

          if(!empty($result))
          {   

            $res_array['data']=array('status'=>'1','message'=>'success','user_type'=>$user_type,'max_id'=>empty($max_id)?'1':$max_id);
            $this->response($res_array, 200);

          }else
          {
            $res_array['data']=array('status'=>'0','message'=>'failed');
            $this->response($res_array, 200);
          }
     }else
     {
        $res_array['data']=array('status'=>'0','message'=>'failed');
        $this->response($res_array, 200);
     }
      
	}catch (Exception $e){
                        echo $e->getMessage();
                        $error = array('status' => 0, "msg" => "Internal Server Error - Please try Later.","StatusCode"=> "HTTP405");
                        $this->response($error, 200);
                }

	}
  function getNearByhawker_post()
   {
    // print_r('expression');exit;
    $lat1=$this->input->post('cust_latitude');
    $lon1=$this->input->post('cust_longitude');
    $result=$this->Seller->getMerchant();
    // print_r($result);exit;
    for($i=0;$i<count($result);$i++)
    {
    	$lat2=$result[$i]['shop_latitude'];
	    $lon2=$result[$i]['shop_longitude'];
	    $distance=calculateDistance($lat1, $lon1, $lat2, $lon2);
	    // echo '<br>';echo $distance;
	    if($distance <= 500)
	    {

	    	$hawker_code=$result[$i]['hawker_code'];

	    	$imgResult=$this->Seller->getNearByMerchantImages($hawker_code);

	    	if(!empty($imgResult))
	    	{
	    		$finalResult['img']=$imgResult;
	    		$finalResult['hawker_code']=$hawker_code;
	    	}
	     
	    }

    }
    if(empty($finalResult)) {
    	 $res_array['data']=array('status'=>'0','message'=>'failed');
								$this->response($res_array, 200);
    }
    else{
    	//$res_array['data']=array('status'=>'1','message'=>$finalResult);
								$this->response(array('Api_status'=>'1','data'=>$finalResult), 200);
    }
     //print_r($finalResult);exit;

   }


// This fun is used for showing offer images on click banner for ads in customer app
public	function getMerchnatImage_post()
		{
           try
			{
			$hawker_code=$this->input->post('hawker_code');

			if(!empty($hawker_code))
			{
				$checkMerchant=$this->Seller->checkMerchant($hawker_code);
				if(!empty($checkMerchant))
				{
						$result=$this->Seller->getMerchantImage($hawker_code);
						 //print_r($result);exit;
						if(!empty($result))
						{   
							$result_array=array(
											'status'	=>'1',
											'image_1'	=>$result[0]['image_1'],
											'image_2'	=>$result[0]['image_2'],
											'image_3'	=>$result[0]['image_3'],
											'image_4'	=>$result[0]['image_4'],
											//'mobile_no'	=>$result[0]['mobile_no'],
											'title' 	=>$result[0]['advertisement_title']
											);
							$res_array['data']=$result_array;
							$this->response($res_array, 200);
						}else
						{
								$res_array['data']=array('status'=>'0','message'=>'failed');
								$this->response($res_array, 200);
						}
				}else
				{
								$res_array['data']=array('status'=>'0','message'=>'Please register merchant');
								$this->response($res_array, 200);
				}
				

			}else
			{
				$res_array['data']=array('status'=>'0','message'=>'failed');
				$this->response($res_array, 200);
			}


			}

			//Handling Exception in case problem of network or data loading
			catch (Exception $e){
                        echo $e->getMessage();
                        $error = array('status' =>'0', "message" => "Internal Server Error - Please try Later.","StatusCode"=> "HTTP405");
                        $this->response($error, 200);
                }

		}

public function paymentTxn_post()
{
	try
	{
		// echo'<pre>';print_r($_POST);exit;
		date_default_timezone_set('Asia/kolkata');
		$payment_id			=$this->input->post('payment_id');
		$hawker_code 			=$this->input->post('hawker_code');
		$payment_status			=$this->input->post('payment_status');
		$amount 			=$this->input->post('amount');
		$plan_type			=$this->input->post('ad_type');
		$device_id			=$this->input->post('device_id');
    		$ads_id      			=$this->input->post('max_id');
    		$days      			=$this->input->post('days');

    // $ads_id       =1;
    // echo  $ads_id ;exit;
		txnLogs($payment_id,$hawker_code,$payment_status,$amount,$plan_type,$device_id,$ads_id);

	if(!empty($payment_id) && ($payment_status=='success') && !empty($amount) && !empty($device_id) && !empty($plan_type)&& !empty($ads_id))
		{



			$payload=array(
							'payment_id'		 =>$payment_id,
							'payment_status'	=>$payment_status,
							'amount'			=>$amount,
							'plan_type'			=>$plan_type,
							'hawker_code'		=>$hawker_code,
							'device_id'		    =>$device_id,
               						'ads_id'         =>$ads_id,
							'created_on'		=>date('Y-m-d H:i:s')
						);

			$result=$this->Seller->paymentSuccess($payload);

			if($result)
			{
       				 $getdata=$this->Seller->getDate($hawker_code,$ads_id);

       				 //if(strtolower($plan_type=='month'))
      					 // {
      				   // $end_date=date("Y-m-d", strtotime("$getdata +30 day" ));
        			//}else if(strtolower($plan_type=='day'))
      				 // {
      			   // $end_date=date("Y-m-d", strtotime("$getdata +1 day" ));
       				 //}else if(strtolower($plan_type=='halfyearly'))
       				// {
        			 // $end_date=date("Y-m-d", strtotime("$getdata +180 day" ));
        			//}
				$end_date=date("Y-m-d", strtotime("$getdata +$days day"));

				$Updateresult=$this->Seller->Authorized($hawker_code,$ads_id,$plan_type,$end_date);

				if($Updateresult)
				{
					$res_array['data']=array('status'=>'1','message'=>'success');
             		$this->response($res_array, 200);
				}else
				{
					$res_array['data']=array('status'=>'0','message'=>'failed');
             		$this->response($res_array, 200);
				}
				
			}else
			{
				$res_array['data']=array('status'=>'0','message'=>'failed');
             	$this->response($res_array, 200);
			}

		}else
		{


			 $res_array['data']=array('status'=>'0','message'=>'failed');
             $this->response($res_array, 200);
		}
	}catch(Exception $e)
	{
		echo $e->getMessage();
		$error = array('status' =>'0', "message" => "Internal Server Error - Please try Later.","StatusCode"=> "HTTP405");
        $this->response($error, 200);

	}
}

public function expireAdvertisement_get()
  { 
         try
          {
         
          date_default_timezone_set('Asia/kolkata');

          $result=$this->Seller->getHawkers();

          if(!empty($result))
          {
              foreach ($result as $value)
              {
                $hawker_code      =$value['hawker_code'];
                $ads_id           =$value['ads_id'];
                $hawkerArray[]    =$value['hawker_code'];
                $adsIdArray[]     =$value['ads_id'];
                $Updateresult     =$this->Seller->ExpiredAds($hawker_code,$ads_id);

                if($Updateresult)
                {
                  $expiredHawker[]=array(

                                    'hawker_code'   =>$hawker_code,
                                    'ads_id'        =>$ads_id,
                                    'creation_date' =>date('Y-m-d H:i:s')

                  );
                }
              }
          }
        // print_r($Updateresult);exit;
        if($Updateresult)
        {     


                      $this->Seller->insertExpiredhawker($expiredHawker);
                      
                      $res_array['data']=array('status'=>'1','message'=>'success','hawker_code'=>$hawkerArray,'adsIdArray'=>$adsIdArray);
                      $this->response($res_array, 200);
        }else
        {
                      $res_array['data']=array('status'=>'0','message'=>'failed');
                      $this->response($res_array, 200);
        }
      }catch (Exception $e)
      {
                              echo $e->getMessage();
                              $error = array('status' =>'0', "message" => "Internal Server Error - Please try Later.","StatusCode"=> "HTTP405");
                              $this->response($error, 200);
      }
    } 
	public function expireFreeAdvertisement_get()
  { 
         try
          {
         
          date_default_timezone_set('Asia/kolkata');

          $result=$this->Seller->getFreeHawkers();

          if(!empty($result))
          {
              foreach ($result as $value)
              {
                $hawker_code      =$value['hawker_code'];
                $expFreehawker[]  =$value['hawker_code'];
                $Updateresult     =$this->Seller->ExpiredFreeAds($hawker_code);

                if($Updateresult)
                {
                  $expiredFreeHawker[]=array(

                                    'hawker_code'   =>$hawker_code,
                                    'creation_date' =>date('Y-m-d H:i:s')

                  );
                }
              }
          }
        // print_r($Updateresult);exit;
        if($Updateresult)
        {     


                      $this->Seller->inserFreetExpiredhawker($expiredFreeHawker);
                      
                      $res_array['data']=array('status'=>'1','message'=>'success','hawker_code'=>$expFreehawker);
                      $this->response($res_array, 200);
        }else
        {
                      $res_array['data']=array('status'=>'0','message'=>'failed');
                      $this->response($res_array, 200);
        }
      }catch (Exception $e)
      {
                              echo $e->getMessage();
                              $error = array('status' =>'0', "message" => "Internal Server Error - Please try Later.","StatusCode"=> "HTTP405");
                              $this->response($error, 200);
      }
    }
public function getPlanType_get()
   {
   	 try
   	 {

   	 	$plan_result=$this->Seller->getPlanType();
   	 	if(!empty($plan_result))
   	 	{
   	 		$res_array['data']=array('status'=>'1','message'=>'success','plan_type'=>$plan_result);
            $this->response($res_array, 200);
   	 	}else
   	 	{

          $res_array['data']=array('status'=>'0','message'=>'failed');
          $this->response($res_array, 200);
   	 	}
   	 }catch(Exception $e)
   	 {
   	 	echo $e->getMessage();
   	 	$error = array('status' =>'0', "message" => "Internal Server Error - Please try Later.","StatusCode"=> "HTTP405");
        $this->response($error, 200);
      }
   	 }
}
