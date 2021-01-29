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

 /*....get check number for login  Api For Moving Basket ---- */
	public function check_number_post()
	  {
	    $response = new StdClass();
		$result       =  new StdClass();
		$mobile_no =$this->input->post('mobile_no');
		$getdata  =  $this->db
		->select('type')
        ->from("registration_sales")
        ->where(['mobile_no'=>$mobile_no,'active_status'=>'1'])
        ->get()->result_array();

        $getdata1  = $this->db
		->select("type")
        ->from("registration_customer")
        ->where(['mobile_no'=>$mobile_no, 'active_status'=>'1'])
        ->get()->result_array();

        $getdata2  =  $this->db
        ->select("*")
        ->from("registration_sellers")
        ->where(['mobile_no'=>$mobile_no])
        ->get()->result_array();

       /* $getdata3  =  $this->db
        ->select("*")
        ->from("registration_sellers")
        ->where(['business_mobile_no'=>$mobile_no])
        ->get()->result_array();*/
        

        if(!empty($mobile_no))
        {
          if(!empty($getdata))
		  {
           foreach ($getdata as $row)
           {
            $data['type'] =  $row['type'];
             $data['active_status'] = '1';
            $data['status']  ='1';

            
             array_push($result,$data);
           }
             $response->data = $result;
          }

        else if(!empty($getdata1))
         {
          	foreach($getdata1 as $row1)
          	{
          		  $data['type'] =  $row1['type'];
          		   $data['active_status'] = '1';
                  $data['status']  ='1';

                   array_push($result,$data);
          	}
          	 $response->data = $result;
         }

        else if(!empty($getdata2))
         {

           	foreach($getdata2 as $row2)
           	{
           	  $data['active_status']=$row2['active_status'];
           	  if($row2['active_status']=='1')
           	   {
           	    	$data['active_status']='1';
           	    	$data['type']=$row2['type'];
           	    	$data['status']  ='1';
                    array_push($result,$data);
           	   }

           	  else if($row2['active_status']=='2')
           	    {
           	    	$data['active_status']='2';
           	    	$data['type']=$row2['type'];
           	    	$data['status']  ='1';
                    array_push($result,$data);
           	    }
           	  else
           	  {
           	  	$data['active_status']='0';
           	    $data['type']=$row2['type'];
           	    $data['status']  ='1';
                array_push($result,$data);

           	  }
           	}
           	 $response->data = $data;
          }
           else
          //  if number not matched in all the register table --//
	        {
            	 $data['status']  ='2';
			     $data['message'] = 'number not matched';
			     array_push($result ,$data);
            }
            	 $response->data = $data;

         //  if number not matched in all the register table --//

         }
        else
          {
             $data['status']  ='0';
			 array_push($result , $data);
            	
          }
              $response->data = $data;

              echo json_output($response);
      }

  /*........get check number for login   Api For Moving basket  ---- */

  /*......... Login Api For Hawker ---- */
     public function login_post()
     {
		$response = new StdClass();
		$result = new StdClass();
		$mobile_no = $this->input->post('mobile_no');
		$password = $this->input->post('password');
		$device_id=$this->input->post('device_id');
		$notification_id=$this->input->post('notification_id');
		date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
        $this->db
		->select('*');
        $this->db->from("registration_sales");
        $this->db->where(['mobile_no'=>$mobile_no,'password'=>$password]);
       /* $this->db->get()->result_array();*/
        $query=$this->db->get();
        $num_rows=$query->num_rows();
        $current_data=$query->result_array();
        $getdata1  =  $this->db
		->select('*')
        ->from("registration_customer")
        ->where(['mobile_no'=>$mobile_no,'password'=>$password])
        ->get()->result_array();

        	$data1->device_id = $device_id;
	        $data1->notification_id = $notification_id;
		    $data1->login_time=$now;

		 $getdata2  =  $this->db
		->select('*')
        ->from("registration_sellers")
        ->where(['mobile_no'=>$mobile_no,'password'=>$password])
        ->get()->result_array();

        	$data1->device_id = $device_id;
	        $data1->notification_id = $notification_id;
		    $data1->login_time=$now;
		
        if(!empty($mobile_no))
        {
           if(!empty($current_data))
		  {
           foreach ($current_data as $row)
           {
           	$data1->device_id = $device_id;
	        $data1->notification_id = $notification_id;
		    $data1->login_time=$now;
           	$data1->name=$row['name'];
           	$data1->mobile_no=$row['mobile_no'];
           	$data1->sales_id=$row['sales_id'];
           	$data1->password=$row['password'];
           	$res = $this->User->addRegistrationSaleData($data1);

            $data['id'] =  $row['sales_id'];
            $data['name'] =  $row['name'];
            $data['type'] =  $row['type'];
            $data['status']  ='1';
            
             array_push($result,$data);
           }
             $response->data = $result;
          }

          else if(!empty($getdata1))
		  {
           foreach ($getdata1 as $rowdata)
           {
           	$data1->device_id = $device_id;
	        $data1->notification_id = $notification_id;
		    $data1->login_time=$now;
		    $data1->id=$rowdata['id'];
		    $data1->name=$rowdata['name'];
		    $data1->mobile_no=$rowdata['mobile_no'];
		    $data1->email_id=$rowdata['email_id'];
		    $data1->password=$rowdata['password'];
		    $data1->address=$rowdata['address'];
		    $res = $this->User->Add_registration_custumer_data($data1);
            $data['id'] =  $rowdata['cus_id'];
            $data['name'] =  $rowdata['name'];
            $data['type'] =  $rowdata['type'];
            $data['status']  ='1';
            
             array_push($result,$data);
           }
             $response->data = $result;
          }

          else if(!empty($getdata2))
		  {
           foreach ($getdata2 as $rowdata1)
           {
           	$data1->device_id = $device_id;
	        $data1->notification_id = $notification_id;
		    $data1->login_time=$now;
		    $data1->id=$rowdata1['id'];
		    $data1->p_name=$rowdata1['p_name'];
		    $data1->shop_number=$rowdata1['shop_number'];
		    $data1->password=$rowdata1['password'];
		    $data1->logout_time=$rowdata1['logout_time'];
		    $res = $this->User->Add_registration_seller_data($data1);
            $data['id'] =  $rowdata1['shop_id'];
            $data['name'] =  $rowdata1['p_name'];
            $data['type'] =  $rowdata1['type'];
            $data['status']  ='1';
            
             array_push($result,$data);
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
		
      /*.........Login Api For Hawker ---- */

     /*.........seller Registration  Api  ---- */
	public function registration_seller_post()
	{ 	
		$response = new StdClass();
		$result2 = new StdClass();
		$name=$this->input->post('name');
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
		$profile_image=$this->input->post('profile_image');
		$img       = str_replace('data:image/jpeg;base64,','',$profile_image);
	    $img       = str_replace('','+',$img);
	    $dataimage      = base64_decode($img);
	    $imageName = "".$name.".jpeg";
	    $dir       = "assets/upload/profile_image/".$imageName;
	    file_put_contents($dir,$dataimage);
		$aadhar_card_image=$this->input->post('aadhar_card_image');
		$idf       = str_replace('data:image/jpeg;base64,','',$aadhar_card_image);
	    $idf       = str_replace('','+',$idf);
	    $dataimage1     = base64_decode($idf);
	    $imageName1 = "".$name.".jpeg";
	    $dir       = "assets/upload/identity_proof_image/front/".$imageName1;
	    file_put_contents($dir,$dataimage1);

		$address_proof=$this->input->post('address_proof');
		$addproof       = str_replace('data:image/jpeg;base64,','',$address_proof);
	    $addproof       = str_replace('','+',$addproof);
	    $addressproof     = base64_decode($addproof);
	    $imageaddress = "".$name.".jpeg";
	    $dir       = "assets/upload/identity_proof_image/front/".$imageaddress;
	    file_put_contents($dir,$addressproof);

		$shop_image_1=$this->input->post('shop_image_1');
		$idf2      = str_replace('data:image/jpeg;base64,','',$shop_image_1);
	    $idf2       = str_replace('','+',$idf2);
	    $dataimage3     = base64_decode($idf2);
	    $imageName3 = "".$name.".jpeg";
	    $dir       = "assets/upload/identity_proof_image/back/".$imageName3;
	    file_put_contents($dir,$dataimage3);
        $shop_image_2=$this->input->post('shop_image_2'); 

        $idf1       = str_replace('data:image/jpeg;base64,','',$shop_image_2);
	    $idf1       = str_replace('','+',$idf1);
	    $dataimage2      = base64_decode($idf1);
	    $imageName2 = "".$name.".jpeg";
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
		$que1=$this->db->query("select * from registration_sales where mobile_no='".$shop_number."'");
		$que2=$this->db->query("select * from registration_customer where mobile_no='".$shop_number."'");
		$row = $que->num_rows();
        $row1 = $que1->num_rows();
        $row2 = $que2->num_rows();
         if($row>0)
         {

            $data1->status ='2';
			$data1->message = 'This Number already exists';

			array_push($result2,$data1);
			$response->data = $data1;
         }
        else if($row1>0)
        {
            $data1->status ='2';
			$data1->message = 'This Number already exists';
			array_push($result2,$data1);
			$response->data = $data1;

        }
        else if($row2>0)
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
		 $this->load->model('User');
		 $res = $this->User->seller_location_add_data($data);
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
		 $this->load->model('User');
		 $res = $this->User->sales_location_add_data_by_gps($data);
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


   /*.........Register_customer  Api For Fixer  ---- */
	public function register_customer_post()
	{
		$response = new StdClass();
		$result = new StdClass();
		$name = $this->input->post('name');
		$state=$this->input->post('state');
		$city=$this->input->post('city');
		$address=$this->input->post('address');
		$area=$this->input->post('area');
		$pincode=$this->input->post('pincode');
		$mobile_no = $this->input->post('mobile_no');
		$email=$this->input->post('email_id');
		$password=$this->input->post('password');
		$latitude=$this->input->post('latitude');
		$longitude=$this->input->post('longitude');
		$device_id=$this->input->post('device_id');
		$cus_image =$this->input->post('cus_image');
		$cus_img       = str_replace('data:image/jpeg;base64,','',$cus_image);
	    $cus_img       = str_replace('','+',$cus_img);
	    $cus_dataimage      = base64_decode($cus_img);
	    $a         = rand(155,1555555555);
	    $date      = date('d-m-Y_H-m-s');
	    $imageName = "Ajax_".$a."_".$date.".jpeg";
	    $dir       = "assets/customerImage/".$imageName;
	    file_put_contents($dir,$cus_dataimage);
		$notification_id=$this->input->post('notification_id');
		date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
		$data->name = $name;
		$data->state = $state;
		$data->city = $city;
		$data->address = $address;
		$data->area = $area;
		$data->pincode = $pincode;
		$data->mobile_no= $mobile_no;
		$data->email_id=$email;
		$data->password=$password;
		$data->latitude =$latitude;
		$data->longitude =$longitude;
		$data->device_id =$device_id;
	    $data->notification_id =$notification_id;
	    $data->cus_image =$cus_image;
		$data->active_status='1';
		$data->type='customer';
		$data->registered_time=$now;
		$result1 = $this->User->customer_add($data);
		$alphanumerric='CUS_0000'.$result;
		if(!empty($result1))
		 {
		 	$updatedata = $this->User->update_customer_id($alphanumerric,$result);

		 	$data1->id=$result1;
			$data1->cus_id=$alphanumerric;
			$data1->status ='1';
			$data1->message = 'register Successfully';

			  array_push($result,$data1);
			    $response->data = $data1;
		 }

		else
		{
			$response->status ='0';
			$response->message = 'register failed';
		}
	  
		echo json_output($response);
	   }

     /*.........Register_customer  Api For Fixer  ---- */

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
		    //$data['message'] = 'failed';
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
           // $data['image_url']  =   $this->User->get_image_fixer_url( 'registration_fixer' , $row['shop_image']);
            $data['status']  ='1';
            
             array_push($result,$data);

           } 
			  $response->data = $result;
         }
		   
        
        else
            {
            	 $data['status']  ='0';
			     //$data['message'] = 'failed';
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
			$this->load->model('User');
		    $res = $this->User->Validate_catdata($result);
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

      /*......... Get Validate SalesUser Api For Fixer  ---- */
	public function validate_active_sales_user_post()
	 {
		$response = new StdClass();
		$result       =  new StdClass();
		$sales_id = $this->input->post('sales_id');
		 $result->sales_id = $sales_id;
		 $this->load->model('User');
		 $res = $this->User->Validate_sales_user($result);

		 $active_status=$res->active_status;
		 $message=$res->message;

	     if($active_status=='1')
		  {
			$data1->status ='1';
			$data1->message = 'Active';
			 array_push($result,$data1);
			 $response->data = $data1;
		  }
		  else if($active_status=='0')
		  {
		  	$data1->status ='2';
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

  /*......... Get Validate fixerUser Api For Fixer  ---- */
	public function Validate_active_seller_user_post()
	 {
		$response = new StdClass();
		$result       =  new StdClass();
		$shop_id = $this->input->post('shop_id');
		
			$result->shop_id = $shop_id;
			$this->load->model('User');
		    $res = $this->User->Validate_fixer_user($result);
		    $active_status=$res->active_status;
	     if($active_status=='1')
		  {
			$data1->status ='1';
			$data1->message = 'Active';
			 array_push($result,$data1);
			 $response->data = $data1;
		  }
		  else if($active_status=='0')
		  {
		  	$data1->status ='2';
			$data1->message = 'inactive';
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

   /*......... Get Validate fixerUser Api For Fixer  ---- */

   /*......... Get Validate CustomerUser Api For Fixer  ---- */
	public function Validate_active_customer_user_post()
	 {
		$response = new StdClass();
		$cus_id = $this->input->post('cus_id');
		
			$result->cus_id = $cus_id;
			$this->load->model('User');
		    $res = $this->User->Validate_customer_user($result);
		   $active_status=$res->active_status;
	     if($active_status=='1')
		  {
			$response->status ='1';
			$response->message = 'success';
		  }
		  else if($active_status=='0')
		  {
		  	$response->status ='2';
			$response->message = 'deactivate';
		  }
		  else
		  {
			$response->status ='0';
			$response->message = 'failed';
		  }
		echo json_output($response);
	 }

   /*......... Get Validate CustomerUser Api For Fixer  ---- */

   	 /*.........get fixer registartion data by catID   Api For Fixer  ---- */
	public function get_customer_list_data_by_catID_post()
	  {
	  	$response   =   new StdClass();
		$result       =   array();
		$cat_id =$this->input->post('cat_id');

		$getdata  =  $this->db
		->select("shop_name,shop_city,shop_address,shop_id,shop_number,shop_latitude,shop_longitude,registered_time")
        ->from("registration_sellers")
        ->where("FIND_IN_SET('".$cat_id."', cat_id)")
        ->get()->result_array();
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
           // $data['image_url']  = base_url() . 'assets/upload/'.$id.'';
            $data['image_url']  =   base_url().'assets/upload/'.$row['cat_icon_image'];
            $data['status']  ='1';
            
             array_push($result,$data);

           } 
			  $response->data = $result;
         }
		   
        
        else
            {
            	 $data['status']  ='0';
			     //$data['message'] = 'failed';
			     array_push($result , $data);
            	
            }
            	 $response->data = $result;

           echo json_output($response);
        }

/*........get fixer registartion data by catID  Api For Fixer  ---- */

/*.........get_seller_list_data_by_location  Api For hawker  ---- */
  public function get_customer_list_data_by_location_post()
  {
    $response   =   new StdClass();
    $result       =   array();
    //$shop_city =$this->input->post('city');
    $latitudeFrom =$this->input->post('latitude');
    $longitudeFrom =$this->input->post('longitude');
    $cat_id =$this->input->post('cat_id');
    $radius =$this->input->post('radius');
    $mobile_no =$this->input->post('mobile_no');
    $dataseller = $this->User->check_data_by_registerseller($cat_id);
    $shop_gps_id = $dataseller->shop_gps_id;
    print_r($shop_gps_id);
    die();
    	
   /* $getdata  =  $this->db
	->select("*")
    ->from("registration_sellers")
        
    ->where("FIND_IN_SET('".$cat_id."', cat_id)")
    ->get()->result_array();*/
     if(!empty($getdata))
     {
       foreach ($getdata as $row)
     {
   /*  $type=$row['shop_type'];*/
     $rad = M_PI / 180;
     //Calculate distance from latitude and longitude
     $theta = deg2rad($longitudeFrom - $row['shop_longitude']);
     $dist = sin($latitudeFrom * $rad) 
        * sin($row['shop_latitude'] * $rad) +  cos($latitudeFrom * $rad)
        * cos($row['shop_latitude'] * $rad) * cos($theta * $rad);

     $distance= acos($dist) / $rad * 60 *  2.250;
     
     if($distance<2)
      {
      $data['shop_name']   = $row['shop_name'];
      //$data['shop_number']   = $row['shop_number'];

          array_push($result,$data);
          $response->data = $result;
      }
      else
      {
      $data['status']   = '1';
      $data['message']   = 'No data Found';
       array_push($result,$data);
       $response->data = $result;
      }
      }
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

      /*........get_seller_list_data_by_location Api For hawker  ---- */

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
			     //$data['message'] = 'failed';
			     array_push($result , $data);
            	
            	}
            	 $response->data = $result;

           echo json_output($response);
       }

     /*.........send  Dieloge box message  Api For hawker  ---- */

     /*.........Profile data for sales Api For hawker  ---- */
	 public function sales_profile_post()
	  {
	  	$response =   new StdClass();
		$result       =  new StdClass();
		$sales_id =$this->input->post('sales_id');
		$data->sales_id=$sales_id;
	    $resdata = $this->User->check_data_sales_profile($data);
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
		  	$data1->image_url=base_url().'manage/salesuser_image/'.$image;
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

      /*......... duty on/off Api For hawker  ---- */
	 public function duty_on_off_by_seller_post()
	 {
		$response = new StdClass();
		$result       =  new StdClass();
		$seller_id = $this->input->post('seller_id');
		$longitude =$this->input->post('longitude');
		$latitude=$this->input->post('latitude');
		$duty_status=$this->input->post('duty_status');
		date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
		if($duty_status=='1')
		{
	    $data->seller_id=$seller_id;
		$data->longitude=$longitude;
		$data->latitude=$latitude;
		$data->duty_status=$duty_status;
		$data->on_time=$now;
		$data->status='1';
		$this->load->model('User');
		$res = $this->User->duty_data_by_seller($data);
		}
		else if($duty_status==0)
		{

	    $data->seller_id=$seller_id;
		$data->longitude=$longitude;
		$data->latitude=$latitude;
		$data->duty_status=$duty_status;
		$data->out_time=$now;
		$data->status='1';
		$this->load->model('User');
		$res = $this->User->duty_data_by_seller($data);

		}
		else if($duty_status==2)
		 {

		  	$resdata = $this->User->check_duty_data_by_seller($data12);
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
   /*.........  duty on/off Api For hawker  ---- */

    /*......... duty on/off Api For sales  ---- */
	 public function duty_on_off_by_sales_post()
	 {
		$response = new StdClass();
		$result       =  new StdClass();
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
		$data->status='1';
		$this->load->model('User');
		$res = $this->User->duty_data_by_sales($data);
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
		$res = $this->User->duty_data_by_sales($data);

		}
		else if($duty_status==2)
		 {
		 	$sales_id = $this->input->post('sales_id');

		  	$resdata = $this->User->check_duty_data_by_sales($sales_id);
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

   /*.........Profile data for seller Api For hawker  ---- */
	 public function seller_profile_post()
	  {
	    $response =   new StdClass();
		$result       =  new StdClass();
		$seller_id =$this->input->post('seller_id');
		$data->shop_id=$seller_id;
	    $resdata = $this->User->check_data_seller_profile($data);
	    $id = $resdata->id;
	    $shop_id1=$resdata->shop_id;
	    $name=$resdata->p_name;
		$shop_name=$resdata->shop_name;
		$shop_state=$resdata->shop_state;
		$shop_city=$resdata->shop_city;
		$shop_address=$resdata->shop_address;
		$shop_area=$resdata->shop_area;
		$shop_number=$resdata->shop_number;
		$shop_pincode=$resdata->shop_pincode;
	    if(!empty($resdata))
		{    
           	$data1->id=$id;
		  	$data1->seller_id=$shop_id1;
		  	$data1->name=$name;
		  	//$data1->image_url=base_url().'assets/upload/Profile_image/'.$shop_id1.'.jpeg';
		  	$data1->image_url='http://10.0.0.25/fixer_goolean/assets/upload/Profile_image/'.$shop_id1.'.jpeg';
		  	$data1->shop_name=$shop_name;
		  	$data1->shop_state=$shop_state;
		  	$data1->shop_city=$shop_city;
		  	$data1->shop_address=$shop_address;
		  	$data1->shop_area=$shop_area;
		  	$data1->shop_number=$shop_number;
		  	$data1->shop_pincode=$shop_pincode;
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
    	public function data_logout_post()
     {
		$response = new StdClass();
		$result = array();
		$seller_id =$this->input->post('seller_id');
		$sales_id =$this->input->post('sales_id');
		date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
        $data->shop_id = $seller_id;
	    $data->sales_id = $sales_id;
		$data->logout_time=$now;
		if($sales_id!='')
		{
	    $data->sales_id = $sales_id;
		$data->logout_time=$now;
        $data2 = $this->User->logout_sales_data($data);

        $data1->status ='1';
		$data1->message='logout success';
		array_push($result,$data1);
		$response->data = $data1;

	    }
	    else if($seller_id!='')
	    {
	    $data->shop_id = $seller_id;
		$data->logout_time=$now;
	    $data2 = $this->User->logout_seller_data($data);
        $data1->status ='1';
		$data1->message='logout success';
		array_push($result,$data1);
		$response->data = $data1;
	    }
        
        else
        {
        	$data1->status ='2';
        	$data1->message ='logout failed';
			array_push($result,$data1);
		   $response->data = $data1;

        }
        

		 echo json_output($response);
	 }

    /*......... logout data From Wifi-module Api For Door Unlock ---- */
   }
