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
       $notification_id=$this->input->post('notification_id');
       date_default_timezone_set('Asia/kolkata'); 
       $now = date('Y-m-d H:i:s');
       $result2->city=$city;
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
	public function category_post()
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
        }

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
		$version_name = $this->input->post('version_name');
		$version_code =$this->input->post('version_code');
		$result2->city=$city;
		$data->hawker_code=$hawker_code;
		$versiondata->version_name = $version_name;
		$versiondata->version_code = $version_code;
		/*$data23->hawker_code=$hawker_code;
		$data23->city=$city;
		$history_profile_data=$this->Seller->history_profile($data23);*/
	    $resdata = $this->Seller->check_data_seller_profile($data);
	    $res2 = $this->Seller->check_city_status_seller($result2);
	    $res = $this->Seller->Validate_version_data($versiondata);
		$active_status1=$res2->active_status;
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
		    if($resdata>0)
		    { 
		     $data1->total_call=$resdata;
		    }
		    else if($resdata==0)
            {
             $data1->total_call ='0';
            }
            if($duty_status1!='')
            {
            $data1->duty_status=$duty_status1;
            }
            else
            {
            	$data1->duty_status='0';
            }
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
	    $data->hawker_code = $hawker_code;
		$data->logout_time=$now;
	    $data2 = $this->Seller->logout_seller_data($data);
	    $resdata1 = $this->Seller->insert_duty_status__for_seller($data3);
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
            $data5->name =$name;
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
		$id = $this->input->post('fixer_id');
		$version_name = $this->input->post('version_name');
		$version_code =$this->input->post('version_code');
		
	    $result->version_name = $version_name;
		$result->version_code = $version_code;
	   
	    $res = $this->Seller->Validate_version_data($result);

	    if($res!='')
	    {
		$data1->status ='1';
		$data1->message = 'success';
		array_push($result2,$data1);
		$response->data = $data1;
	    }
		
		else
		{
			$data1->status ='0';
			$data1->message = 'Please update your application';
			array_push($result2,$data1);
			$response->data = $data1;
		}
		echo json_output($response);
	 }
      /*......... Get Check Version data  ---- */
   }
