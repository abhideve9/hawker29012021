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
        ->where(['mobile_no'=>$mobile_no])
        ->get()->result_array();

        $getdata1  = $this->db
		->select("type")
        ->from("registration_customer")
        ->where(['mobile_no'=>$mobile_no])
        ->get()->result_array();

        $getdata2  =  $this->db
        ->select("p_number")
        ->from("registration_seller")
        ->where(['p_number'=>$mobile_no])
        ->get()->result_array();
        if(!empty($mobile_no))
        {
          if(!empty($getdata))
		  {
           foreach ($getdata as $row)
           {
            $data['type'] =  $row['type'];
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
                  $data['status']  ='1';

                   array_push($result,$data);
          	}
          	 $response->data = $result;
          }

        else if(!empty($getdata2))
         {

           	foreach($getdata2 as $row2)
           	{
           		$data['type'] =  'fixer';
                $data['status']  ='1';
                 array_push($result,$data);
           	}
           	 $response->data = $data;
          }
           else
          //  if number not matched in all the register table --//
	        {
            	 $data['status']  ='2';
			     $data['message'] = 'number not matched';
			     array_push($result , $data);
            	
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

  /*........get check number for login   Api For Fixer  ---- */

  /*......... Login Api For Fixer ---- */
     public function login_post()
     {
		$response = new StdClass();
		$result = new StdClass();
		$name =$this->input->post('name');
		$mobile_no = $this->input->post('mobile_no');
		$password = $this->input->post('password');
		$device_id=$this->input->post('device_id');
		$notification_id=$this->input->post('notification_id');
		date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
        $getdata  =  $this->db
		->select('*')
        ->from("registration_sales")
        ->where(['mobile_no'=>$mobile_no,'password'=>$password])
        ->get()->result_array();
        $getdata1  =  $this->db
		->select('*')
        ->from("registration_customer")
        ->where(['mobile_no'=>$mobile_no,'password'=>$password])
        ->get()->result_array();

        if(!empty($mobile_no))
        {
           if(!empty($getdata))
		  {
           foreach ($getdata as $row)
           {
            /*$dara1=$row['name'];
            $data1=$row['mobile_no'];
            $data1=$row['password'];
            $data1=$row['device_id'];
            $data1->device_id = $device_id;
	        $data1->notification_id = $notification_id;
		    $data1->login_time=$now;*/
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

            $data['id'] =  $rowdata['cus_id'];
            $data['name'] =  $rowdata['name'];
            $data['type'] =  $rowdata['type'];
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

		/*//$this->load->model('User');
		//$data = $this->User->getUserData($mobile_no,$password);
		$sales_id=$data->sales_id;
		//$userId = $data->id;
		$name =$data->name;
		$mobile_no=$data->mobile_no;
		$type=$data->type;
		if(!empty($data))
		{
		  $data->device_id = $device_id;
		  $data->notification_id = $notification_id;
		  $data->login_time=$now;
		  $res = $this->User->addRegistrationSaleData($data);
		  $data1->id =$sales_id;
		  $data1->name =$name;
		 /* $response->mobile_no =$mobile_no;*/
		/*  $data1->type=$type;
	      $data1->status ='1';
	      $data1->message = 'Login Successfully';

	       array_push($result,$data1);
	          $response->data = $data1;
		}

		else
		{
			$response->status ='0';
			$response->message = 'Login failed';
		}

		echo json_output($response);
	}*/
    /*.........Login Api For Fixer ---- */

   /*.........seller Registration  Api  ---- */
	public function registration_seller_post()
	{ 	
		$response = new StdClass();
		$result2 = new StdClass();
		$p_name=$this->input->post('p_name');
		$p_number=$this->input->post('p_number');
		$p_state=$this->input->post('p_state');
		$p_city=$this->input->post('p_city');
		$p_address=$this->input->post('p_address');
		$p_pincode=$this->input->post('p_pincode');
		$profile_image =$this->input->post('profile_image');
		$img       = str_replace('data:image/jpeg;base64,','',$profile_image);
	    $img       = str_replace('','+',$img);
	    $dataimage      = base64_decode($img);
	    $imageName = "".$p_name."_".$p_number.".jpeg";
	    $dir       = "assets/upload/profile_image/".$imageName;
	    file_put_contents($dir,$dataimage);
		$identity_proof_front_image =$this->input->post('identity_proof_front_image');
		$idf       = str_replace('data:image/jpeg;base64,','',$identity_proof_front_image);
	    $idf       = str_replace('','+',$idf);
	    $dataimage1     = base64_decode($idf);
	    $imageName1 = "".$p_name."_".$p_number.".jpeg";
	    $dir       = "assets/upload/identity_proof_image/".$imageName1;
	    file_put_contents($dir,$dataimage1);

	    $identity_proof_back_image =$this->input->post('identity_proof_back_image');
		$idf2      = str_replace('data:image/jpeg;base64,','',$identity_proof_back_image);
	    $idf2       = str_replace('','+',$idf2);
	    $dataimage3     = base64_decode($idf2);
	    $imageName3 = "".$p_name."_".$p_number.".jpeg";
	    $dir       = "assets/upload/identity_proof_image/".$imageName3;
	    file_put_contents($dir,$dataimage3);
		$shop_name=$this->input->post('shop_name');
		$shop_state=$this->input->post('shop_state');
		$shop_city=$this->input->post('shop_city');
		$shop_working_hours=$this->input->post('shop_working_hours');
		$shop_address=$this->input->post('shop_address');
		$shop_area=$this->input->post('shop_area');
		$shop_number=$this->input->post('shop_number');
		$shop_landline=$this->input->post('shop_landline');
		$shop_pincode=$this->input->post('shop_pincode');
		$shop_image= $this->input->post('shop_image');
		$idf1       = str_replace('data:image/jpeg;base64,','',$shop_image);
	    $idf1       = str_replace('','+',$idf1);
	    $dataimage2      = base64_decode($idf1);
	    $imageName2 = "".$p_name."_".$p_number.".jpeg";
	    $dir       = "assets/upload/shop_image/".$imageName2;
	    file_put_contents($dir,$dataimage2);
		date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
        $shop_type=$this->input->post('shop_type');  
      	/*$device_id=$this->input->post('device_id');  */
      	$shop_gps_id=$this->input->post('shop_gps_id');  
        $shop_longitude=$this->input->post('shop_longitude');
		$shop_latitude=$this->input->post('shop_latitude');
		$sales_id=$this->input->post('sales_id');
		$data->p_name=$p_name;
		$data->p_number=$p_number;
		$data->p_state=$p_state;
		$data->p_city=$p_city;
		$data->p_address=$p_address;
		$data->p_pincode=$p_pincode;
		$data->profile_image=$profile_image;
		$data->identity_proof_front_image=$identity_proof_front_image;
		$data->identity_proof_back_image=$identity_proof_back_image;
		$data->shop_name=$shop_name;
		$data->shop_state=$shop_state;
		$data->shop_city=$shop_city;
		$data->shop_working_hours=$shop_working_hours;
		$data->shop_address=$shop_address;
		$data->shop_area=$shop_area;
		$data->shop_number=$shop_number;
		$data->shop_landline=$shop_landline;
		$data->shop_pincode=$shop_pincode;
		$data->shop_image=$shop_image;
	    $data->shop_type=$shop_type;
		$data->registered_time=$now;
		$data->active_status='0';
		$data->shop_gps_id =$shop_gps_id;
		$data->shop_longitude =$shop_longitude;
		$data->shop_latitude =$shop_latitude;
		$data->sales_id =$sales_id;
		$que=$this->db->query("select * from registration_seller where shop_number='".$shop_number."'");
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
        $data12 = $this->User->getUserpincode($shop_pincode);
        $shop_pincode1 = $data12->shop_pincode;

        if($shop_pincode1!=$shop_pincode)
        {
        $data1->shop_state=$shop_state;
		$data1->shop_city=$shop_city;
		$data1->shop_area=$shop_area;
		$data1->shop_pincode=$shop_pincode;
		$result1 = $this->User->adddata($data1);
	    }
       
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

   /*.........seller Registration profile image upload Api ---- */
  /* public function registration_seller_shop_image_post()
	{ 	
		$response = new StdClass();
		$result2 = new StdClass();
		$shop_id=$this->input->post('shop_id');
		$profile_image =$this->input->post('profile_image');
		$img       = str_replace('data:image/jpeg;base64,','',$profile_image);
	    $img       = str_replace('','+',$img);
	    $dataimage      = base64_decode($img);
	    $imageName = "".$p_name."_".$p_number.".jpeg";
	    $dir       = "assets/upload/profile_image/".$imageName;
	    file_put_contents($dir,$dataimage);
		$identity_proof_front_image =$this->input->post('identity_proof_front_image');
		$idf       = str_replace('data:image/jpeg;base64,','',$identity_proof_front_image);
	    $idf       = str_replace('','+',$idf);
	    $dataimage1     = base64_decode($idf);
	    $imageName1 = "".$p_name."_".$p_number.".jpeg";
	    $dir       = "assets/upload/identity_proof_image/".$imageName1;
	    file_put_contents($dir,$dataimage1);
	    $identity_proof_back_image =$this->input->post('identity_proof_back_image');
		$idf2      = str_replace('data:image/jpeg;base64,','',$identity_proof_back_image);
	    $idf2       = str_replace('','+',$idf2);
	    $dataimage3     = base64_decode($idf2);
	    $imageName3 = "".$p_name."_".$p_number.".jpeg";
	    $dir       = "assets/upload/identity_proof_image/".$imageName3;
	    file_put_contents($dir,$dataimage3);

		$shop_image= $this->input->post('shop_image');
		$idf1       = str_replace('data:image/jpeg;base64,','',$shop_image);
	    $idf1       = str_replace('','+',$idf1);
	    $dataimage2      = base64_decode($idf1);
	    $imageName2 = "".$p_name."_".$p_number.".jpeg";
	    $dir       = "assets/upload/shop_image/".$imageName2;
	    file_put_contents($dir,$dataimage2);
		
		$data->shop_id=$shop_id;
		$data->profile_image=$profile_image;
		$data->identity_proof_front_image=$identity_proof_front_image;
		$data->identity_proof_back_image=$identity_proof_back_image;
		$data->shop_image=$shop_image;
	       
		$result = $this->User->add($data);
		if(!empty($result))
		{  
		   
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
	}*/

    /*..........seller Registration profile image upload Api  ---- */

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
		 $data->device_id = $device_id;
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
		 $sales_id = $this->input->post('sales_id');
		
		 $result->sales_id = $sales_id;
		 $this->load->model('User');
		 $res = $this->User->Validate_sales_user($result);

		 $active_status=$res->active_status;
		 $message=$res->message;

	     if($active_status=='1')
		  {
			$response->status ='1';
			$response->message = 'Active';
		  }
		  else if($active_status=='0')
		  {
		  	$response->status ='2';
			$response->message = $message;
		  }
		  else
		  {
			$response->status ='0';
			$response->message = 'failed';
		  }

		echo json_output($response);
	 }
   /*......... Get Validate SalesUser Api For Fixer  ---- */

  /*......... Get Validate fixerUser Api For Fixer  ---- */
	public function Validate_active_fixer_user_post()
	 {
		$response = new StdClass();
		$shop_id = $this->input->post('fixer_shop_id');
		
			$result->shop_id = $shop_id;
			$this->load->model('User');
		    $res = $this->User->Validate_fixer_user($result);
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
        ->from("registration_fixer")
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

/*.........get_seller_list_data_by_location  Api For Fixer  ---- */
  public function get_seller_list_data_by_location_post()
  {
    $response   =   new StdClass();
    $result       =   array();
    $shop_city =$this->input->post('city');
    $latitudeFrom =$this->input->post('latitude');
    $longitudeFrom =$this->input->post('longitude');
    $cat_id =$this->input->post('cat_id');
    $radius1 =$this->input->post('radius');
    $radius = 15;
    $getdata  =  $this->db
    ->select("shop_area")
        ->from("registration_seller")
        ->where(['shop_city'=>$shop_city])
        ->get()->result_array();

        if(!empty($getdata))
      {
        foreach ($getdata as $row)
       {
     $data_query=$this->db->get_where('registration_seller' , array('shop_area' => $row['shop_area']));
     if ( $data_query->num_rows() > 0) {
     $data_query_row=$data_query->row();
     $rad = M_PI / 180;
     $theta = deg2rad($longitudeFrom - $data['shop_longitude']);
       $dist = sin($latitudeFrom * $rad) 
        * sin($data['shop_latitude'] * $rad) +  cos($latitudeFrom * $rad)
        * cos($data['shop_latitude'] * $rad) * cos($theta * $rad);
       $distance= acos($dist) / $rad * 60 *  2.250;

     if($distance <15)
      {
      $data['shop_longitude']   =   $data_query_row->shop_longitude;
      $data['shop_latitude']   =   $data_query_row->shop_latitude;
      }

       }
      else {
      $data['shop_longitude']   =   '';
      $data['shop_latitude']   =   '';
      }
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

      /*........get_seller_list_data_by_location Api For Fixer  ---- */
   }
