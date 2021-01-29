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

  /*......... Login Api For sales Hawker ---- */
     public function login_post()
     {
        $response = new StdClass();
        $result = new StdClass();
        $mobile_no = $this->input->post('mobile_no');
        $device_id=$this->input->post('device_id');
        $notification_id=$this->input->post('notification_id');
    	date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
        $this->db
    		->select('*');
	        $this->db->from("registration_sales");
	        $this->db->where(['mobile_no'=>$mobile_no]);
	        $query=$this->db->get();
	        $num_rows=$query->num_rows();
	        $current_data=$query->result_array();

            $data1->device_id = $device_id;
	        $data1->notification_id = $notification_id;
		    $data1->login_time=$now;
	        if(!empty($mobile_no))
	        {
	         if(!empty($current_data))
			    {
	         foreach ($current_data as $row)
	        {
	           	
	          if($row['active_status']=='1')
	        {

	          $data1->device_id = $device_id;
		      $data1->notification_id = $notification_id;
		      $data1->login_time=$now;
              $data1->name=$row['name'];
              $data1->mobile_no=$row['mobile_no'];
              $data1->sales_id=$row['sales_id'];
              $data2->sales_id=$row['sales_id'];
           	  $res = $this->Sales->addRegistrationSaleData($data1);
           	  $res1 = $this->Sales->check_login_validate_data($data2);
           	  $device_id1=$res1->device_id;
           	  if($device_id1!=$device_id)
           	  {
           	  $data['status']  ='3';
              array_push($result,$data);
           	  }
           	  else
           	  {
           	  $data['id'] =  $row['sales_id'];
              $data['name'] =  $row['name'];
           	  $data['active_status']='1';
           	  $data['type']=$row['type'];
           	  $data['status']  ='1';
              array_push($result,$data);
          }
           }
           else
            {
           	  $data['active_status']='0';
           	  $data['type']=$row['type'];
           	  $data['status']  ='1';
              array_push($result,$data);
            }
          
         }
          $response->data = $result;
         }
         else
	      {

              $data['status']  ='2';
			  $data['message'] = 'mobile no or password not matched';
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
		
      /*.........Login Api For sales  Hawker ---- */

       /*.........seller Registration  Api  ---- */
	public function registration_seller_post()
	{ 	
		$response = new StdClass();
		$result2 = new StdClass();
		$name=$this->input->post('name');
		$name_type=$this->input->post('name_type');
		$user_type=$this->input->post('user_type');
		$address=$this->input->post('address');
		$mobile_no=$this->input->post('mobile_no');
		$password=$this->input->post('password');
		$business_name=$this->input->post('business_name');
		$business_start_time=$this->input->post('business_start_time');
		$business_close_time=$this->input->post('business_close_time');
		$shop_name=$this->input->post('shop_name');
		$business_address=$this->input->post('business_address');
		$hawker_register_address=$this->input->post('hawker_register_address');
		$city_address=$this->input->post('city_address');
		$business_mobile_no=$this->input->post('business_mobile_no');
		$cat_id=$this->input->post('cat_id');
		$sub_cat_id=$this->input->post('sub_cat_id');
		$super_sub_cat_id=$this->input->post('super_sub_cat_id');
		$profile_image=$this->input->post('profile_image');
		$img       = str_replace('data:image/jpeg;base64,','',$profile_image);
	    $img       = str_replace('','+',$img);
	    $dataimage      = base64_decode($img);
	    $imageName = "".$mobile_no.".jpeg";
	    $dir       = "assets/upload/profile_image/".$imageName;
	    file_put_contents($dir,$dataimage);
		$aadhar_card_image=$this->input->post('aadhar_card_image');
		$idf       = str_replace('data:image/jpeg;base64,','',$aadhar_card_image);
	    $idf       = str_replace('','+',$idf);
	    $dataimage1     = base64_decode($idf);
	    $imageName1 = "".$mobile_no.".jpeg";
	    $dir       = "assets/upload/identity_proof_image/front/".$imageName1;
	    file_put_contents($dir,$dataimage1);

		$address_proof=$this->input->post('address_proof');
		$addproof       = str_replace('data:image/jpeg;base64,','',$address_proof);
	    $addproof       = str_replace('','+',$addproof);
	    $addressproof     = base64_decode($addproof);
	    $imageaddress = "".$mobile_no.".jpeg";
	    $dir       = "assets/upload/identity_proof_image/front/".$imageaddress;
	    file_put_contents($dir,$addressproof);

		$shop_image_1=$this->input->post('shop_image_1');
		$idf2      = str_replace('data:image/jpeg;base64,','',$shop_image_1);
	    $idf2       = str_replace('','+',$idf2);
	    $dataimage3     = base64_decode($idf2);
	    $imageName3 = "".$mobile_no.".jpeg";
	    $dir       = "assets/upload/identity_proof_image/back/".$imageName3;
	    file_put_contents($dir,$dataimage3);
        $shop_image_2=$this->input->post('shop_image_2'); 

        $idf1       = str_replace('data:image/jpeg;base64,','',$shop_image_2);
	    $idf1       = str_replace('','+',$idf1);
	    $dataimage2      = base64_decode($idf1);
	    $imageName2 = "".$mobile_no.".jpeg";
	    $dir       = "assets/upload/shop_image/".$imageName2;
	    file_put_contents($dir,$dataimage2);

      	$shop_gps_id=$this->input->post('shop_gps_id'); 
        $shop_latitude=$this->input->post('shop_latitude');
        $shop_longitude=$this->input->post('shop_longitude');  
		$application_type=$this->input->post('application_type');
		$sales_id=$this->input->post('sales_id');
		date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
		$data->name=$name;
		$data->name_type=$name_type;
		$data->user_type=$user_type;
		$data->address=$address;
		$data->mobile_no=$mobile_no;
		$data->password=$password;
		$data->business_name=$business_name;
		$data->business_start_time=$business_start_time;
		$data->business_close_time=$business_close_time;
		$data->shop_name=$shop_name;
		$data->business_address=$business_address;
		$data->hawker_register_address=$hawker_register_address;
		$data->city_address=$city_address;
		$data->business_mobile_no=$business_mobile_no;
		$data->cat_id=$cat_id;
		$data->sub_cat_id=$sub_cat_id;
		$data->super_sub_cat_id=$super_sub_cat_id;
		$data->profile_image=$profile_image;
		$data->aadhar_card_image=$aadhar_card_image;
		$data->address_proof=$address_proof;
		$data->shop_image_1=$shop_image_1;
	    $data->shop_image_2=$shop_image_2;
	    $data->shop_gps_id=$shop_gps_id;
	    $data->shop_latitude =$shop_latitude;
	    $data->shop_longitude =$shop_longitude;
		$data->application_type =$application_type;
		$data->registered_time=$now;
		$data->active_status='2';
		$data->type='seller';
		$data->sales_id =$sales_id;

		if($user_type=='Moving')
		{
			$que=$this->db->query("select * from registration_sellers where mobile_no='".$mobile_no."'");

		}
		else
		{
			$que=$this->db->query("select * from registration_sellers where business_mobile_no='".$business_mobile_no."'");
		}
		
		$row = $que->num_rows();
    if($row>0)
         {

            $data1->status ='2';
			$data1->message = 'This Number already exists';

			array_push($result2,$data1);
			$response->data = $data1;
         }
        
        else
        {	
		$result = $this->User->add($data);
		$alphanumerric='SHP_0000'.$result;
		if(!empty($result))
		{  
		    $resultdata = $this->User->update_shop_id($alphanumerric,$result);
			$data1->id=$result;
			$data1->shop_id=$alphanumerric;
			$data1->status ='1';
			$data1->message = 'register Successfully';

			array_push($result2,$data1);
			$response->data = $data1;
		}
		else
		{
			$data1->status ='0';
			$data1->message = 'register failed';

			array_push($result2,$data1);
			$response->data = $data1;

		}
	   }
	  echo  json_output($response);
	}
   /*.........seller Registration  Api  ---- */


    /*.........sales location by gps Api for hawker ---- */

    public function sales_location_by_gps_post()
	 {
		 $response = new StdClass();
		 $result = new StdClass();
		 $sales_id=$this->input->post('sales_id');
		 $latitude  = $this->input->post('latitude');
		 $longitude = $this->input->post('longitude');
		 $device_id  = $this->input->post('device_id');
		 $battery_status  = $this->input->post('battery_status');
		 date_default_timezone_set('Asia/kolkata'); 
         $now = date('Y-m-d H:i:s');
         $data->sales_id  = $sales_id;
		 $data->latitude  = $latitude;
		 $data->longitude = $longitude;
		 $data->device_id = $device_id;
		 $data->battery_status = $battery_status;
		 $data->create_time = $now;
		 $data->active_status='1';
		 //$this->load->model('User');
		 $res = $this->Sales->sales_location_add_data_by_gps($data);
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

    /*...... sales location by gps Api for hawker  ---- */

   /*......... Get Validate SalesUser Api For Fixer  ---- */
	public function validate_active_sales_user_post()
	 {
		$response = new StdClass();
		$result       =  new StdClass();
		$sales_id = $this->input->post('sales_id');
		$device_id=$this->input->post('device_id');
		$result->sales_id = $sales_id;
		$result1->device_id=$device_id;
		$res = $this->Sales->Validate_sales_user($result);
		$res1 = $this->Sales->check_device_for_sales($result);

		 $active_status=$res->active_status;
		 $message=$res->message;
		 $devicedata=$res1->device_id;

		 if($devicedata!=$device_id)
		 {
		 	$data1->status ='3';
			$data1->message = 'logout from other device';
			 array_push($result,$data1);
			 $response->data = $data1;

		 }

	     else if($active_status=='1')
		  {
		  	$data1->active_status='1';
			$data1->status ='1';
			$data1->message = 'Active';
			 array_push($result,$data1);
			 $response->data = $data1;
		  }
		  else if($active_status=='0')
		  {
		  	$data1->active_status='0';
		  	$data1->status ='1';
			$data1->message = $message;
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
   /*......... Get Validate SalesUser Api For Fixer  ---- */

   /*.........Profile data for sales Api For hawker  ---- */
	 public function sales_profile_post()
	  {
	  	$response =   new StdClass();
		$result       =  new StdClass();
		$sales_id =$this->input->post('sales_id');
		$data->sales_id=$sales_id;
	    $resdata = $this->Sales->check_data_sales_profile($data);
	    $id = $resdata->id;

		$sales_id1=$resdata->sales_id;
		$name=$resdata->name;
		$email_id=$resdata->email_id;
		$image=$resdata->image;
		$address=$resdata->address;
		$mobile_no=$resdata->mobile_no;
		
	    if(!empty($resdata))
		  {
		  	$data1->id=$id;
		  	$data1->sales_id=$sales_id1;
		  	$data1->name=$name;
		  	$data1->email_id=$email_id;
		    $data1->image_url='http://10.0.0.15/fixer_goolean/manage/salesuser_image/'.$image;
		  	//$data1->image_url=base_url().'manage/salesuser_image/'.$image;
		  	$data1->address=$address;
		  	$data1->mobile_no=$mobile_no;
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
            	
          echo  json_output($response);
       }

      /*.........Profile data for sales Api For hawker  ---- */

    /*......... duty on/off Api For sales  ---- */
	 public function duty_on_off_by_sales_post()
	 {
		$response = new StdClass();
		$result       =  new StdClass();
		$device_id = $this->input->post('device_id');
		$sales_id = $this->input->post('sales_id');
		$longitude =$this->input->post('longitude');
		$latitude=$this->input->post('latitude');
		$duty_status=$this->input->post('duty_status');
		date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
		if($duty_status=='1')
		{
	    $data->sales_id=$sales_id;
		$data->longitude=$longitude;
		$data->latitude=$latitude;
		$data->duty_status=$duty_status;
		$data->on_time=$now;
		$data->device_id=$device_id;
		$data->status='1';
		$res = $this->Sales->duty_data_by_sales($data);
		}
		
		else if($duty_status==0)
		{
	    $data->sales_id=$sales_id;
		$data->longitude=$longitude;
		$data->latitude=$latitude;
		$data->duty_status=$duty_status;
		$data->out_time=$now;
		$data->status='1';
		$this->load->model('User');
		$res = $this->Sales->duty_data_by_sales($data);

		}
		else if($duty_status==2)
		 {
		 	$sales_id = $this->input->post('sales_id');

		  	$resdata = $this->Sales->check_duty_data_by_sales($sales_id);
		  	$duty_status1 = $resdata->duty_status;
		 }

	    if(!empty($data))
		 {
		 	$data1->duty_status=$duty_status;
			$data1->status ='1';
			$data1->message = 'success';
			 array_push($result,$data1);
			 $response->data = $data1;
		 }
		 else if(!empty($resdata))
		 {
		 	$data1->duty_status=$duty_status1;
			$data1->status ='1';
			$data1->message = 'success';
			 array_push($result,$data1);
			 $response->data = $data1;
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
    /*.........  duty on/off Api For sales  ---- */

   /*......... logout Api For Door hawker ---- */
    	public function data_logout_for_sales_post()
     {
		$response = new StdClass();
		$result = array();
		$device_id =$this->input->post('device_id');
		$sales_id =$this->input->post('sales_id');
		$longitude =$this->input->post('longitude');
		$latitude=$this->input->post('latitude');
		date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
        $data3->latitude = $latitude;
        $data3->longitude = $longitude;
        $data3->sales_id = $sales_id;
	    $data->sales_id = $sales_id;
	    $data3->duty_status ='0';
	    $data3->status ='1';
	    $data3->out_time =$now;
		$data->logout_time=$now;
		$resdata1 = $this->Sales->check_logout_data_sales($sales_id);
		$device_id1 = $resdata1->device_id;
		if($sales_id!='')
		{
	    $data->sales_id = $sales_id;

		$data->logout_time=$now;
        $data2 = $this->Sales->logout_sales_data($data);
        $resdata1 = $this->Sales->insert_duty_status__for_sales($data3);

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

    /*.........Category   Api For Fixer  ---- */
	public function category_post()
	{
	  $response = new StdClass();
	  $result = array();
	  $datacat = $this->Sales->category_data_profile();
	  if(!empty($datacat))
	  {
	  foreach ($datacat as $row)
	   {
		 $setData = new StdClass();
		 $setData->id = $row['id'];
		 $setData->position_key = $row['id'];
		 $setData->cat_name = $row['cat_name'];
		 $setData->image_url= base_url().'manage/catImages/'.$row['cat_icon_image'];
		 $setData->sub_cat_status='0';
		 $subCat = $this->Sales->getSubCategory(['category'=>$row['id']]);
		 if(!empty($subCat))
		 {

		  $setData->sub_cat_status= '1';
		  $setData->subCat = $subCat;

	     }
		 else
		 {
			$setData->subCat = $subCat;
		 }		
		 array_push($result,$setData);
		 }
			$response->status = '1';
			$response->data = $result;

		}
		else
		{
		$response->status = '0';
		$response->data = "";

		}

	   echo json_output($response);
	  }

      /*.........Category   Api For Fixer  ---- */

      /*.........super sub Category   Api For Hawker  ---- */
	 public function super_sub_category_post()
	  {
	  	$response   =   new StdClass();
		$result       =   array();
		$sub_cat_id =$this->input->post('sub_cat_id');
		$datacat = $this->Sales->getSuperSubCategory($sub_cat_id);
	    if(!empty($datacat))
		{
         foreach ($datacat as $row)
           {

            $data['id'] =   $row['id'];
            $data['super_sub_cat_name'] =   $row['super_sub_cat_name'];
            $data['image_url']=base_url().'manage/catImages/'.$row['super_sub_cat_image'];
             $data['position_key'] = $sub_cat_id;
            $data['status']  ='1';

            array_push($result,$data);

           } 
              $response->status = '1';
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

      /*.........super sub Category   Api For hawker  ---- */

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
	    $res1 = $this->Sales->fetch_login_data($data);
        $name=$res1->name;
        $sales_id=$res1->user_id;
        $notificationdata=$res1->notification_id;
        $data2 = $this->Sales->update_login_data($data);
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
            $data1->messagedata=$data4;
            $data1->status ='1';
            $data1->name =$name;
            $data1->sales_id =$sales_id;
		    array_push($result,$data1);
		    $response->data = $data1;
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
	 /*.........super sub Category   Api For Hawker  ---- */
	 public function Hawker_type_data_post()
	  {
	  	$response   =   new StdClass();
		$result       =   array();
		$datacat = $this->Sales->gethawkertypename();
	    if(!empty($datacat))
		{
         foreach ($datacat as $row)
           {

            $data['id'] =   $row['id'];
            $data['hawker_type_name'] =   $row['hawker_type_name'];
            $data['create_date'] =  $row['create_date'];
            array_push($result,$data);

           } 
              $response->status = '1';
			  $response->data = $result;
         }
         else
         {
            $response->status = '0';
         }
           
           echo json_output($response);
        }

      /*.........super sub Category   Api For hawker  ---- */

	 /*.........BUG   Api For hawker  ---- */
	/*public function data_logout_for_sales_post()
     {
		$response = new StdClass();
		$result = array();
		$sales_id =$this->input->post('sales_id');
		$bugmessage =$this->input->post('bugmessage');
		date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
        $data->sales_id = $latitude;
        $data->longitude = $longitude;
        $data3->sales_id = $sales_id;
	    $data->sales_id = $sales_id;
	    $data3->duty_status ='0';
	    $data3->status ='1';
	    $data3->out_time =$now;
		$data->logout_time=$now;
		$resdata1 = $this->Sales->check_logout_data_sales($sales_id);
		$device_id1 = $resdata1->device_id;
		if($sales_id!='')
		{
	    $data->sales_id = $sales_id;

		$data->logout_time=$now;
        $data2 = $this->Sales->logout_sales_data($data);
        $resdata1 = $this->Sales->insert_duty_status__for_sales($data3);

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
	 }*/

      /*.........Category   Api For Fixer  ---- */

  

   }
