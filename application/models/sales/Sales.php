<?php

class Sales extends CI_Model
{    
    private $table = 'registration_sales';
    private $tabledata='login_manage_sales';
    private $table_data_for_distributor ='tbl_login_for_distributors';
    private $registration_seller='registration_sellers';
    private $registration_seller_reg='registration_sellers_1';
    private $tbl_temporary_hawker_registration='tbl_temporary_hawker_registration';
    private $gps_sales_location ='gps_sales_location';
    private $tbl_distributor_gps_location='tbl_distributor_gps_location';
    private $duty_on_off_by_sales='duty_on_off_by_sales';
    private $tbl_distributor_duty_on_off='tbl_distributor_duty_on_off';
    private $tbl_otp='tbl_otp_sales';
    private $tbl_otp_seller='tbl_otp_for_seller_registration';
    private $check_version_for_sale='check_version_for_sale';
    private $tbl_update_image_hawker_registration='tbl_update_image_hawker_registration';
    
    function add($data)
    {
        $insert = $this->db->insert($this->registration_seller, $data);
        return $insert?$this->db->insert_id():false;
      
    }
     function add_data($data)
    {
        $insert = $this->db->insert($this->tbl_update_image_hawker_registration, $data);
        return $insert?$this->db->insert_id():false;
      
    }
    function add_reg($data_reg)
    {
        $insert = $this->db->insert($this->registration_seller_reg, $data_reg);
        return $insert?$this->db->insert_id():false;
      
    }
    function temporary_hawker_registration($data)
    {
        $insert = $this->db->insert($this->tbl_temporary_hawker_registration, $data);
        return $insert?$this->db->insert_id():false;
      
    }

     function sales_location_add_data_by_gps($data)
    {
        $insert = $this->db->insert($this->gps_sales_location, $data);
        return $insert?$this->db->insert_id():false;
      
    }

     function distributor_location_for_gps($data)
    {
        $insert = $this->db->insert($this->tbl_distributor_gps_location, $data);
        return $insert?$this->db->insert_id():false;
      
    }

     ////////Add Registartion sales data //////////
    function addRegistrationSaleData($where)
    {
        $name =$where ->name;
        $mobile_no=$where->mobile_no;
        $device_id=$where->device_id;
        $notification_id=$where->notification_id;
        $login_time=$where->login_time;
        $sales_id = $where->sales_id;

        $query=$this->db->get_where($this->tabledata,['user_id'=>$where->sales_id,'device_id'=>$device_id])->num_rows();

         $query1=$this->db->get_where($this->tabledata,['user_id'=>$where->sales_id])->num_rows();

         /* $q=$this->db->query("SELECT * from login_manage_sales where user_id='".$sales_id."'");
          return($q->row());
          $row = $q->num_rows();
*/
        if($query>0)
        {
            $this->db->where('user_id', $where->sales_id);  
            $this->db->update($this->tabledata, ['login_time'=>$login_time,'notification_id'=>$notification_id,'active_status'=>'1']);
        }
        else if($query1>0)
        {
            /* $this->db->where('user_id', $where->sales_id);  
             $this->db->update($this->tabledata, ['login_time'=>$login_time,'notification_id'=>$notification_id,'device_id'=>$device_id]);*/
        }
        else
        {

             $query="insert into login_manage_sales(user_id,name,mobile_no,device_id,notification_id,login_time,status,active_status) values('$sales_id','$name','$mobile_no','$device_id','$notification_id','$login_time','1','1')";
        
            $this->db->query($query);

        }
     }

     function addRegistrationdistributorData($where)
    {
        $name =$where ->name;
        $mobile_no=$where->mobile_no;
        $device_id=$where->device_id;
        $notification_id=$where->notification_id;
        $login_time=$where->login_time;
        $sales_id = $where->sales_id;

        $query=$this->db->get_where($this->table_data_for_distributor,['distributor_id'=>$where->sales_id,'device_id'=>$device_id])->num_rows();

         $query1=$this->db->get_where($this->table_data_for_distributor,['distributor_id'=>$where->sales_id])->num_rows();

         /* $q=$this->db->query("SELECT * from login_manage_sales where user_id='".$sales_id."'");
          return($q->row());
          $row = $q->num_rows();
*/
        if($query>0)
        {
            $this->db->where('distributor_id', $where->sales_id);  
            $this->db->update($this->table_data_for_distributor, ['login_time'=>$login_time,'notification_id'=>$notification_id,'active_status'=>'1']);
        }
        else if($query1>0)
        {
            /* $this->db->where('user_id', $where->sales_id);  
             $this->db->update($this->tabledata, ['login_time'=>$login_time,'notification_id'=>$notification_id,'device_id'=>$device_id]);*/
        }
        else
        {

             $query="insert into tbl_login_for_distributors(distributor_id,name,mobile_no,device_id,notification_id,login_time,status,active_status) values('$sales_id','$name','$mobile_no','$device_id','$notification_id','$login_time','1','1')";
        
            $this->db->query($query);

        }
     }

    

     function update_login_data($data)
     {
       $device_id=$data->device_id;
        $notification_id=$data->notification_id;
        $login_time=$data->login_time;
        $mobile_no = $data->mobile_no;

         $this->db->where('mobile_no', $data->mobile_no);  
             $this->db->update($this->tabledata, ['login_time'=>$login_time,'notification_id'=>$notification_id,'device_id'=>$device_id,'active_status'=>'1']);

     }

      function check_login_validate_data($data)
     {
        $salesID = $data->sales_id;
        $q=$this->db->query("SELECT * from login_manage_sales where user_id='".$salesID."'");
          return($q->row());
        $row = $q->num_rows();
     }

     function check_login_validate_data_for_distributor($data)
     {
        $salesID = $data->sales_id;
        $q=$this->db->query("SELECT * from tbl_login_for_distributors where distributor_id='".$salesID."'");
          return($q->row());
        $row = $q->num_rows();
     }

      ////////Add Registration Sales data //////////
     
     ////////Validate salesuser data //////////
    function Validate_sales_user($data)
     {
        $salesID = $data->sales_id;
        $q=$this->db->query("SELECT * from registration_sales where sales_id='".$salesID."'");
          return($q->row());
        $row = $q->num_rows();
        
       
     }


     ////////Validate salesuser data //////////

      ////////check device  salesuser //////////
    function check_device_for_sales($data)
     {
        $sales_id =$data->sales_id;
        $q=$this->db->query("SELECT * from login_manage_sales where user_id='".$sales_id."'");
          return($q->row());
        $row = $q->num_rows();
        
       
     }
     ////////check device for  salesuser //////////

      function check_city_status_sales($data)
     {
        $city =$data->city;
        $Pincode =$data->Pincode;
        $q=$this->db->query("SELECT Pincode,city,status from tbl_pincode_by_city where (Pincode='".$Pincode."' OR  city='$city') and status='1'");
          return($q->row());
        $row = $q->num_rows();
     }

     function duty_data_by_sales($data)
    {

        $insert = $this->db->insert($this->duty_on_off_by_sales, $data);
        return $insert?$this->db->insert_id():false;
      
    }


     function duty_data_by_distributor_sales_user($data)
    {
        $insert = $this->db->insert($this->tbl_distributor_duty_on_off, $data);
        return $insert?$this->db->insert_id():false;
      
    }

     function check_duty_data_by_sales($sales_id)
     {  
        $q=$this->db->query("SELECT * from duty_on_off_by_sales where sales_id='$sales_id' order by id desc limit 1");
         return($q->row());
     }

     function check_duty_data_by_distributor_sales($distributor_id)
     {  
        $q=$this->db->query("SELECT * from tbl_distributor_duty_on_off where distributor_id='$distributor_id' order by id desc limit 1");
         return($q->row());
     }

     function check_logout_data_sales($sales_id)
     {  

        $q=$this->db->query("SELECT * from login_manage_sales where user_id='$sales_id'");
         return($q->row());
     }
     function check_logout_data_distributor_sales($distributor_id)
     {  

        $q=$this->db->query("SELECT * from tbl_login_for_distributors where distributor_id='$distributor_id'");
         return($q->row());
     }

      function check_data_sales_profile($data)
     {  
        $sales_id = $data->sales_id;
        $q=$this->db->where(['sales_id'=>$sales_id,'active_status'=>'1'])
          ->get('registration_sales');
          return($q->row());
     }
      function category_data_profile($cat_name)
     {  
       
        $q=$this->db->get_where('fixer_category',['fixer_category.sales_status'=>'2','fixer_category.cat_name'=>$cat_name]);
        // print_r( $this->db->last_query());exit;          
          return($q->result_array());
     }
     function category1_data_profile()
     {  
       
        $q=$this->db->get_where('fixer_category',['fixer_category.sales_status'=>'3','fixer_category.type'=>'Fix']);
                        
          return($q->result_array());
     }
     function category2_data_profile()
     {  
       
        $q=$this->db->get_where('fixer_category',['fixer_category.sales_status'=>'3','fixer_category.type'=>'Moving','fixer_category.festive_status'=>'1']);
                        
          return($q->result_array());
     }
    
     public function getSubCategory($where)
     {
         $query = $this->db->get_where('fixer_sub_category',$where)->result_array();
// print_r( $this->db->last_query());exit;  
         return $query;   
     }
      public function getSuperSubCategory($sub_cat_id)
     {
         $q = $this->db->get_where('fixer_super_sub_category',['fixer_super_sub_category.sub_cat_id'=>$sub_cat_id]);
        return($q->result_array());
     }
     public function gethawkertypename($hawker_type_code)
     {
         $q = $this->db->get_where('hawkers_sub_type',['hawkers_sub_type.status'=>'1','hawkers_sub_type.hawker_type_code'=>$hawker_type_code]);
        return($q->result_array());
     }

     function logout_sales_data($data)
    {
        $active_status='0';
        $sales_id = $data->sales_id;
        $now = $data->logout_time;
        $this->db->where('user_id',$sales_id);  
        $this->db->update($this->tabledata, ['active_status'=>$active_status,'logout_time'=>$now]);
    }

    function logout_distributor_sales_data($data)
    {
        $active_status='0';
        $distributor_id = $data->distributor_id;
        $now = $data->logout_time;
        $this->db->where('distributor_id',$distributor_id);  
        $this->db->update($this->table_data_for_distributor, ['active_status'=>$active_status,'logout_time'=>$now]);
    }

    function update_shop_id($alphanumerric,$result,$hawkerCode)
    {   
      $this->db->query("UPDATE registration_sellers SET shop_id='$alphanumerric',hawker_code='$hawkerCode' where id='$result'");
    }

    function update_temporary_data($result,$hawkerCode)
    {   
      $this->db->query("UPDATE tbl_temporary_hawker_registration SET hawker_code='$hawkerCode' where id='$result'");
    }

    function update_verification_hawker($mobile_no)
    {   
      $this->db->query("UPDATE registration_sellers SET verification_status='1' where mobile_no_contact='$mobile_no'");
    }

    function update_verification_hawker_by_call($mobile_no)
    {   
      $this->db->query("UPDATE registration_sellers SET verification_by_call='1' where mobile_no_contact='$mobile_no'");
    }


    ////////IMAGE URL//////////
    function get_image_url($type = '', $id = '')
    {
        if (file_exists('manage/catImages/' . $id . '.jpg'))
            $image_url = base_url() . 'manage/catImages/' . $type . '_image/' . $id . '.jpg';
        else
            $image_url = 'http://10.0.0.25/fixer_goolean/manage/catImages/'.$id.'';

        return $image_url;
    }

     ////////IMAGE URL//////////

     function fetch_login_data($data)
     {
        $mobile_no = $data->mobile_no;
        $q=$this->db->query("SELECT * from login_manage_sales where mobile_no='".$mobile_no."'");
          return($q->row());
        $row = $q->num_rows();
        
       
     }

      function insert_duty_status__for_sales($data3)
    {
        $insert = $this->db->insert($this->duty_on_off_by_sales, $data3);
        return $insert?$this->db->insert_id():false;
      
    }

    function insert_duty_status__for_distributor_sales($data3)
    {
        $insert = $this->db->insert($this->tbl_distributor_duty_on_off, $data3);
        return $insert?$this->db->insert_id():false;
      
    }
     function updatehawkerdata($data)
    {
        $mobile_no_contact = $data->mobile_no_contact;
        $name = $data->name;
       $this->db->where('mobile_no_contact', $mobile_no_contact);
         $this->db->update($this->registration_seller,$data);
      
    }
     function updatehawkerdata_img($data)
    {
        $mobile_no_contact = $data->mobile_no_contact;
        $name = $data->name;
       $this->db->where('mobile_no_contact', $mobile_no_contact);
         $this->db->update($this->registration_seller_reg,$data);
      
    }

     function checkcode($data)
     {
        $city = $data->city;
        $state = $data->state;
        $q=$this->db->query("SELECT city_code,city,state_code,id from city_state_code where city='".$city."' and state='".$state."' and active_status='1'");
          return($q->row());
        $row = $q->num_rows();
     }

     function checkstatecode($data)
     {
       
        $state = $data->state;
        $q=$this->db->query("SELECT state_code from city_state_code where  state='".$state."' and active_status='1'");
          return($q->row());
        $row = $q->num_rows();
     }

     function checktype($data)
     {
        $user_type = $data->user_type;
        $q=$this->db->query("SELECT code from hawker_type where hawker_type='".$user_type."'");
          return($q->row());
        $row = $q->num_rows();
     }

     function send_otp($mobile_no,$otpValue)
    {
        // Set POST variables

        $url = 'https://2factor.in/API/V1/c43867a9-ba7e-11e9-ade6-0200cd936042/SMS/'.$mobile_no.'/'.$otpValue.'/'.'OTP'.'';
        // Open connection
        $ch = curl_init();\
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($url));
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        return $result;
    }
     function otpgetdata($data)
     {
        $mobile_no=$data->mobile_no;
        $device_id=$data->device_id;
        $notification_id=$data->notification_id;
        $sales_id=$data->sales_id;
        $otp=$data->otp;
        date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
        $query=$this->db->get_where($this->tbl_otp,['sales_id'=>$data->sales_id,'device_id'=>$device_id])->num_rows();
        if($query>0)
        {
            $this->db->query("UPDATE tbl_otp_sales SET date_time='$now',notification_id='$notification_id',mobile_no='$mobile_no',otp='$otp' where sales_id='$sales_id' and device_id='$device_id'");
        }
        else
        {
        $query="insert into tbl_otp_sales(sales_id,mobile_no,otp,device_id,notification_id,date_time) values('$sales_id','$mobile_no','$otp','$device_id','$notification_id','$now')";
        $this->db->query($query);
        }
      }

      function otpgetdata_by_seller($data)
      {
        $mobile_no=$data->mobile_no_contact;
        $device_id=$data->device_id;
        $seller_id=$data->seller_id;
        $otp=$data->otp;
        date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
        $query=$this->db->get_where($this->tbl_otp_seller,['seller_id'=>$data->seller_id,'device_id'=>$device_id])->num_rows();
        if($query>0)
        {
             $this->db->query("UPDATE tbl_otp_for_seller_registration SET date_time='$now',mobile_no='$mobile_no',otp='$otp' where seller_id='$seller_id' and device_id='$device_id'");
        }
        else
        {
        $query="insert into tbl_otp_for_seller_registration(seller_id,mobile_no,otp,device_id,date_time) values('$seller_id','$mobile_no','$otp','$device_id','$now')";
        $this->db->query($query);
        }
      }

      function verification_otp($data)
     { 
        $device_id=$data->device_id;
        $mobile_no=$data->mobile_no;
        $otp=$data->otp;
        $q=$this->db->query("SELECT mobile_no from tbl_otp_sales where otp='".$otp."' and  device_id='".$device_id."' and mobile_no='".$mobile_no."'");
          return($q->row());
        $row = $q->num_rows();

     }
     function fetchdata_for_distributor($mobile_no)
     {  
        $q=$this->db->query("SELECT name,mobile_no,type,id,sales_id from registration_sales where mobile_no='".$mobile_no."' and active_status='1'");
          return($q->row());
        $row = $q->num_rows();

     }

      function verification_otp_by_seller($data)
     { 
        $device_id=$data->device_id;
        $mobile_no=$data->mobile_no;
        $otp=$data->otp;
        $q=$this->db->query("SELECT mobile_no,seller_id from tbl_otp_for_seller_registration where otp='".$otp."' and  device_id='".$device_id."' and mobile_no='".$mobile_no."'");
          return($q->row());
        $row = $q->num_rows();

     }


      function verification_otp_by_seller_by_call($data)
     { 
        $device_id=$data->device_id;
        $mobile_no=$data->mobile_no;
        $q=$this->db->query("SELECT mobile_no,seller_id from tbl_otp_for_seller_registration where  device_id='".$device_id."' and mobile_no='".$mobile_no."'");
          return($q->row());
        $row = $q->num_rows();

     }

     /*function fetch_data_registration($mobile_no_contact)
     { 
        $q=$this->db->query("select * from registration_sellers where mobile_no_contact='".$mobile_no_contact."' and verification_by_call='0' and verification_status='0'");
          return($q->row());
        $row = $q->num_rows();

     }*/

      function resend_otp($data)
     {
        $mobile_no=$data->mobile_no;
        $device_id=$data->device_id;
        $otp=$data->otp;
        date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
        $query=$this->db->get_where($this->tbl_otp,['mobile_no'=>$data->mobile_no,'device_id'=>$device_id])->num_rows();
        if($query>0)
        {  
             $this->db->query("UPDATE tbl_otp_sales SET date_time='$now',otp='$otp' where mobile_no='$mobile_no' and device_id='$device_id'");
        }
        
      }

      function resend_otp_for_seller($data)
     {
        $mobile_no=$data->mobile_no;
        $device_id=$data->device_id;
        $otp=$data->otp;
        date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
        $query=$this->db->get_where($this->tbl_otp_seller,['mobile_no'=>$data->mobile_no,'device_id'=>$device_id])->num_rows();
        if($query>0)
        {
    
             $this->db->query("UPDATE tbl_otp_for_seller_registration SET date_time='$now',otp='$otp' where mobile_no='$mobile_no' and device_id='$device_id'");
        }
        
      }
       function update_check_list($data)
     {
        $hawker_code=$data->hawker_code;
        $sales_id=$data->sales_id;
        $check_list=$data->check_list;
        $query=$this->db->get_where($this->registration_seller,['hawker_code'=>$data->hawker_code])->num_rows();
        if($query>0)
        {
             $this->db->query("UPDATE registration_sellers SET check_list='$check_list' where hawker_code='$hawker_code'");
        }
        
      }
       function remove_otp($data)
     {
        $mobile_no=$data->mobile_no;
        $device_id=$data->device_id;
         date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
        $query=$this->db->get_where($this->tbl_otp,['mobile_no'=>$data->mobile_no,'device_id'=>$device_id])->num_rows();
        if($query>0)
        {
            $this->db->query("UPDATE tbl_otp_sales SET date_time='$now',otp='NULL' where device_id='$device_id' and mobile_no='$mobile_no'");
        }
        
      }

        function remove_otp_for_seller($data)
     {
        $mobile_no=$data->mobile_no;
        $device_id=$data->device_id;
         date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
        $query=$this->db->get_where($this->tbl_otp_seller,['mobile_no'=>$data->mobile_no,'device_id'=>$device_id])->num_rows();
        if($query>0)
        {
              $this->db->query("UPDATE tbl_otp_for_seller_registration SET date_time='$now',otp='NULL' where device_id='$device_id' and mobile_no='$mobile_no'");
        }
        
      }
      /*function Validate_version_data($data)
     {
       
        $version_name = $data->version_name;
        $version_code = $data->version_code;

        $query=$this->db->get_where($this->tbl_otp_seller,['mobile_no'=>$data->mobile_no,'device_id'=>$device_id])->num_rows();
        if($query>0)
        {
              $this->db->query("UPDATE tbl_otp_for_seller_registration SET date_time='$now',otp='NULL' where device_id='$device_id' and mobile_no='$mobile_no'");
        }*/
        
        /* $q=$this->db->query("SELECT * from check_version_for_sale where version_name='".$version_name."' and version_code='".$version_code."'");
          return($q->row());
        $row = $q->num_rows();*/
   /*  }*/

     function Validate_version_data($data)
     {
       
        $version_name = $data->version_name;
        $version_code = $data->version_code;
         $q=$this->db->query("SELECT * from check_version_for_sale where status='1'");
          return($q->row());
        $row = $q->num_rows();
    }

    function get_lat_long_for_sales_person($sales_id,$device_id)
    { 
         $q=$this->db->query("SELECT latitude,longitude from gps_sales_location where sales_id='$sales_id' and device_id='$device_id' order by create_time desc ");
          return($q->row());
        $row = $q->num_rows();
    }

     function check_list_data()
     {  
       
        $q=$this->db->get_where('tbl_check_list_for_sale',['tbl_check_list_for_sale.status'=>'1']);
                        
          return($q->result_array());
     }
     function update_version_data($result)
    {   
        $version_name = $result->version_name;
        $version_code = $result->version_code;

      $this->db->query("UPDATE check_version_for_sale SET version_name='$version_name', version_code='$version_code'  where status='1'");
    }


     function show_list_hawker_by_sales($sales_id,$verification_status)
     {  
        date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d');
       /* $q=$this->db->get_where('registration_sellers',['registration_sellers.sales_id'=>$sales_id,'registration_sellers.verification_status'=>$verification_status,'date_time'=>$now]);*/

         $q=$this->db->query("SELECT *from registration_sellers where sales_id='".$sales_id."' and date_time='$now' and verification_status ='$verification_status' and   verification_by_call ='$verification_status'");

          return($q->result_array());
     }

      function show_list_hawker_by_distributor($pincode)
     {  
        $q=$this->db->query("SELECT name ,mobile_no_contact,hawker_code,registered_time,hawker_register_address,shop_latitude,shop_longitude,cat_id,sub_cat_id,business_name from registration_sellers where  hawker_register_address LIKE '%$pincode%' and (adhar_image_validation_status='2' or adhar_image_validation_status='3' or shop_image_validation_status='2' or shop_image_validation_status='3') and (verification_status =1 or  verification_by_call = 1) and distribute_status!='1' order by registered_time DESC");

          return($q->result_array());
     }

     function show_list_hawker_by_distributor_notification()
     {  
        $q=$this->db->query("SELECT name ,mobile_no_contact,hawker_code,registered_time,hawker_register_address,shop_latitude,shop_longitude,cat_id,sub_cat_id,business_name from registration_sellers where (adhar_image_validation_status='2' or adhar_image_validation_status='3' or shop_image_validation_status='2' or shop_image_validation_status='3') and (verification_status =1 or  verification_by_call = 1) and distribute_status!='1' order by registered_time DESC");

          return($q->result_array());
     }

     function hawker_list_detail_data($hawker_code)
     { 
         $q=$this->db->query("SELECT * FROM registration_sellers a inner join registration_sellers_1 b on a.mobile_no_contact=b.mobile_no_contact WHERE a.hawker_code='$hawker_code'");
           return($q->row());
     }

      function fetch_cat_id_data($string)
     { 
        $cat_name='';
        foreach ($string as $string2 ) {
           
           $q=$this->db->query("SELECT cat_name from fixer_category where id='$string2'");
           $cat_name1 = $q->row()->cat_name;               
            $cat_name .=$cat_name1 .",";
        }
         
          return rtrim($cat_name,",");
     }

     function Sales_name_fetch($sales_id)
     { 
         $q=$this->db->query("SELECT name from registration_sales where sales_id='$sales_id'");
           return($q->row());
     }

      function fetch_sub_cat_id_data($string1)
     { 

        $sub_cat_name='';
        foreach ($string1 as $string2 ) {
           $q=$this->db->query("SELECT sub_cat_name from fixer_sub_category where id='$string2'");
           $sub_cat_name1 = $q->row()->sub_cat_name;               
            $sub_cat_name .=$sub_cat_name1 .",";
        }

        
           return rtrim($sub_cat_name,",");
     }

     function show_list_hawker_by_sale($sales_id,$verification_status)
     {  
        date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d');
       /* $q=$this->db->get_where('registration_sellers',['registration_sellers.sales_id'=>$sales_id,'registration_sellers.verification_status'=>$verification_status,'date_time'=>$now]);*/

         $q=$this->db->query("SELECT *from registration_sellers where sales_id='".$sales_id."' and date_time='$now' and (verification_status ='$verification_status' or verification_by_call ='$verification_status')");

          return($q->result_array());
     }

      function get_city_by_pinocde($sPin)
     { 
         $q=$this->db->query("SELECT * from tbl_pincode_by_city where Pincode='$sPin' and status='1'");
           return($q->row());
     }

     function get_notification_id_for_sales($sales_id)
     { 
         $q=$this->db->query("SELECT notification_id from login_manage_sales where user_id='$sales_id' and status='1'");
           return($q->row());
     }

     function show_history_for_hawker($distributor_id)
     {  
        $q=$this->db->query("SELECT *from tbl_update_image_hawker_registration where distributor_id='".$distributor_id."'");

          return($q->result_array());
     }
    function getRegisteredHawkersBysales($currentdate)
    {
        $this->db->select('rseller.sales_id,rseller.shop_latitude,rseller.shop_longitude,TIME(rseller.registered_time) AS registered_time,rseller.date_time,rseller.mobile_no_contact');
        $this->db->FROM('registration_sales AS rsales');
        $this->db->JOIN('registration_sellers AS rseller','rseller.sales_id=rsales.sales_id','LEFT');
        $this->db->WHERE('`rsales.active_status','1');
        //$this->db->WHERE('rseller`.`date_time`',$currentdate);
	$this->db->WHERE('rseller`.`date_time`="'.$currentdate.'" AND (`verification_status`=1 OR `verification_by_call` = 1)');
        $query=$this->db->get();
       //print_r($this->db->last_query());exit;
        $result=$query->result_array();
        return $result; 

    }
    public function insertDistanceCalculatedperDay($array)
    {
         //print_r($array);exit;
        $result=$this->db->insert_batch(TBL_DISTANCE_FOR_SALES,$array);
        //print_r($this->db->last_query());exit;
        if($result)
        {
           return $this->db->insert_id();
        }else
        {
            return false;
        }

    }

    function addHawkerCategory($hawker_data_array)
    {
        $result=$this->db->insert_batch(TBL_MISC_FIXER,$hawker_data_array);
        // print_r($this->db->last_query());exit;
        if($result)
        {
           return $this->db->insert_id();
        }else
        {
            return false;
        } 
    }
    function addHawkerSubCategory($hawker_data_array2)
    {
        $result=$this->db->insert_batch(TBL_MISC_SUB_FIXER,$hawker_data_array2);
       
        if($result)
        {
           return $this->db->insert_id();
        }else
        {
            return false;
        } 
    }
     function addHawkerSuperSubCategory($hawker_data_array3)
    {
        $result=$this->db->insert_batch(TBL_MISC_SUPER_SUB_FIXER,$hawker_data_array3);
        // print_r($this->db->last_query());exit;   
        if($result)
        {
           return $this->db->insert_id();
        }else
        {
            return false;
        } 
    }


function get_city_data($Pincode,$city)
     {  
        $q=$this->db->query("SELECT Pincode,city,status from tbl_pincode_by_city where (Pincode='".$Pincode."' OR city='$city') and status='1'");
          return($q->row());
     }

   }
?>