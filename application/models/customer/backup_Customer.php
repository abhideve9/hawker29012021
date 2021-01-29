<?php

class Customer extends CI_Model
{    
    private $register_customer='registration_customer';
    private $tablecustumerlogin='login_manage_custumer';
    private $tbl_otp_customer='tbl_otp_customer';
    private $tbl_favourite_category='tbl_favourite_category';
    private $notified_near_by_hawker_for_customer='notified_near_by_hawker_for_customer';
    private $tbl_customer_call_by_hawker='tbl_customer_call_by_hawker';
    private $tbl_customer_navigate_by_hawker='tbl_customer_navigate_by_hawker';
    private $history_notified_near_by_hawker_for_customer='history_notified_near_by_hawker_for_customer';
    private $tbl_notified_moving_data='tbl_notified_moving_data';
    private $tbl_request_city_by_customer='tbl_request_city_by_customer';
    private $tbl_history_for_location_customer='tbl_history_for_location_customer';
    private $tbl_feedback_customer='tbl_feedback_customer';
    private $tbl_near_by_notified_radius='tbl_near_by_notified_radius';
    private $tbl_show_location_by_hawker='tbl_show_location_by_hawker';
    private $tbl_customer_gps_location='tbl_customer_gps_location';
    private $tbl_hawker_referal_code_for_customer='tbl_hawker_referal_code_for_customer';
    private $tbl_genrate_referral_code_for_customer='tbl_genrate_referral_code_for_customer';
    private $tbl_notification_for_hawker_referral_code='tbl_notification_for_hawker_referral_code';

    function update_customer_id($alphanumerric,$result)
    {   
      $this->db->query("UPDATE registration_customer SET cus_id='$alphanumerric' where id='$result'");
    }
  
    function flag_status_update($data2)
    {   
      $mobile_no=$data2->customer_mobile_no;
      $query=$this->db->get_where($this->tbl_hawker_referal_code_for_customer,['customer_mobile_no'=>$mobile_no,'money_received_status'=>'1'])->num_rows();
      if($query>0)
      {
            
      }
      else
      {  
        $insert = $this->db->insert($this->tbl_hawker_referal_code_for_customer, $data2);
        return $insert?$this->db->insert_id():false;
      }
    }

     /*function get_referral_code_for_customer($data2)
    {   
        $device_id=$data2->device_id;
        $mobile_no=$data2->mobile_no;
        $customer_referral_code=$data2->otpValue;
        $longitude=$data2->longitude;
        $customer_point=$data2->customer_point;
        $date_time=$data2->date_time;
        $status=$data2->status;
        $query=$this->db->get_where($this->tbl_genrate_referral_code_for_customer,['mobile_no'=>$mobile_no])->num_rows();
      
        if($query>0)
        {
          $q=$this->db->query("SELECT customer_referral_code from tbl_genrate_referral_code_for_customer where mobile_no='".$mobile_no."'");
           return($q->row());
        
        }
        else
        {
          $insert = $this->db->insert($this->tbl_genrate_referral_code_for_customer, $data2);
          return $insert?$this->db->insert_id():false;
        }
    }*/


    function customer_add($data)
    {   
       $insert = $this->db->insert($this->register_customer, $data);
       return $insert?$this->db->insert_id():false;
    }

    function notification_data_for_referral($notificationdata)
    {   
       $insert = $this->db->insert($this->tbl_notification_for_hawker_referral_code, $notificationdata);
       return $insert?$this->db->insert_id():false;
    }

    /*function add_referral_code_data($data)
    {   
       $insert = $this->db->insert($this->tbl_hawker_referal_code_for_customer, $data);
       return $insert?$this->db->insert_id():false;
    }*/


     function insert_notified_data($data)
    {   
       $insert = $this->db->insert($this->tbl_near_by_notified_radius, $data);
       return $insert?$this->db->insert_id():false;
    }

    function Customer_location_add_data($data)
    {
        $insert = $this->db->insert($this->tbl_customer_gps_location, $data);
        return $insert?$this->db->insert_id():false;
    }


    function feedback_data($data)
    {   
       $insert = $this->db->insert($this->tbl_feedback_customer, $data);
       return $insert?$this->db->insert_id():false;
    }

    /* function show_location_hawker($data)
    {   
       $insert = $this->db->insert($this->tbl_show_location_by_hawker, $data);
       return $insert?$this->db->insert_id():false;
    }*/
     function logdatalocation($data)
    {   
       $insert = $this->db->insert($this->tbl_history_for_location_customer, $data);
       return $insert?$this->db->insert_id():false;
    }
    function request_city_by_customer_data($data)
    {   
       $insert = $this->db->insert($this->tbl_request_city_by_customer, $data);
       return $insert?$this->db->insert_id():false;
    }
     function backup_notified_data($data)
    {   
       $insert = $this->db->insert($this->history_notified_near_by_hawker_for_customer, $data);
       return $insert?$this->db->insert_id():false;
    }

      function notifiedcustomerdata($data)
    {   
       $insert = $this->db->insert($this->tbl_notified_moving_data, $data);
       return $insert?$this->db->insert_id():false;
    }

    function remove_notified_data($cus_id,$notification_id)
    {   
       $this->db->delete('notified_near_by_hawker_for_customer', array('cus_id' => $cus_id,'notification_id' => $notification_id)); 
    }

  /* function near_by_hawker_data($data)
    {   
       $insert = $this->db->insert($this->notified_near_by_hawker_for_customer, $data);
       return $insert?$this->db->insert_id():false;
    }*/

    function show_location_hawker($data)
      {
        $hawker_code=$data->hawker_code;
        $hawker_mobile_no=$data->hawker_mobile_no;
        $latitude=$data->latitude;
        $longitude=$data->longitude;
        $customer_mobile_no=$data->customer_mobile_no;
        $location_name=$data->location_name;
        $latitude=$data->latitude;
        $longitude=$data->longitude;
        $city=$data->city;
        date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
        $query=$this->db->get_where($this->tbl_show_location_by_hawker,['customer_mobile_no'=>$customer_mobile_no,'hawker_code'=>$hawker_code])->num_rows();
        if($query>0)
        {
            date_default_timezone_set('Asia/kolkata'); 
            $now = date('Y-m-d H:i:s');
            $this->db->update($this->tbl_show_location_by_hawker, ['date_time'=>$now,'close_status'=>'0']);
        }
        else
        {
              $query="insert into tbl_show_location_by_hawker(hawker_code,hawker_mobile_no,customer_mobile_no,location_name,latitude,longitude,date_time,status) values('$hawker_code','$hawker_mobile_no','$customer_mobile_no','$location_name','$latitude','$longitude','$now','1')";
        
             $this->db->query($query);
        }
      }


    function near_by_hawker_data($data)
      {
        $cus_id=$data->cus_id;
        $mobile_no=$data->mobile_no;
        $cat_id=$data->cat_id;
        $sub_cat_id=$data->sub_cat_id;
        $super_sub_cat_id=$data->super_sub_cat_id;
        $radius=$data->radius;
        $notification_id=$data->notification_id;
        $set_time=$data->set_time;
        $latitude=$data->latitude;
        $longitude=$data->longitude;
        $city=$data->city;
        date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
        if($sub_cat_id=='' and $super_sub_cat_id=='')
        {
        $query=$this->db->get_where($this->notified_near_by_hawker_for_customer,['cus_id'=>$data->cus_id,'cat_id'=>$data->cat_id])->num_rows();
        }
        else if($super_sub_cat_id=='')
        {
           $query=$this->db->get_where($this->notified_near_by_hawker_for_customer,['cus_id'=>$data->cus_id,'cat_id'=>$data->cat_id,'sub_cat_id'=>$data->sub_cat_id])->num_rows();
        }
        if($query>0)
        {
             $this->db->query("UPDATE notified_near_by_hawker_for_customer SET latitude='$latitude',longitude='$longitude',notification_id='$notification_id',radius='$radius',city='$city',date_time='$now',set_time='$set_time'");
        }
        else
        {
        $query="insert into notified_near_by_hawker_for_customer(cus_id,mobile_no,latitude,longitude,notification_id,cat_id,sub_cat_id,super_sub_cat_id,radius,city,date_time,set_time,status) values('$cus_id','$mobile_no','$latitude','$longitude','$notification_id','$cat_id','$sub_cat_id','$super_sub_cat_id','$radius','$city','$now','$set_time','1')";
        $this->db->query($query);
        }
      }
     function favourite_category_add($data)
    {   
      $mobile_no =$data->mobile_no;
      $cus_id =$data ->cus_id;
      $cat_id=$data->cat_id;
      $sub_cat_id=$data->sub_cat_id;
      $super_sub_cat_id=$data->super_sub_cat_id;
      $time_date=$data->time_date;
      if($sub_cat_id=='' and $cat_id!='' and $super_sub_cat_id=='')
      {
      $query=$this->db->get_where($this->tbl_favourite_category,['cus_id'=>$data->cus_id,'cat_id'=>$cat_id])->num_rows();
      }
      else if($cat_id=='' and $sub_cat_id=='')
      {
        $insert = $this->db->insert($this->tbl_favourite_category, $data);
          return $insert?$this->db->insert_id():false;
      }
      else
      {
        $query1=$this->db->get_where($this->tbl_favourite_category,['cus_id'=>$data->cus_id,'sub_cat_id'=>$sub_cat_id])->num_rows();
      }

     if($query>0)
     {
         $this->db->query("UPDATE tbl_favourite_category SET time_date='$time_date',status='1' where cus_id='$cus_id' and cat_id='$cat_id'");
     }
     else if($query1>0)
     {
        $this->db->query("UPDATE tbl_favourite_category SET time_date='$time_date',status='1' where cus_id='$cus_id' and sub_cat_id='$sub_cat_id'");
     }
     else
     {
          $insert = $this->db->insert($this->tbl_favourite_category, $data);
          return $insert?$this->db->insert_id():false;
     }
     
    }

      function unfavourite_category($data)
    {   
      $mobile_no =$data->mobile_no;
      $cus_id =$data ->cus_id;
      $cat_id=$data->cat_id;
      $sub_cat_id=$data->sub_cat_id;
      $time_date=$data->time_date;
      $this->db->query("UPDATE tbl_favourite_category SET status='0' where mobile_no='$mobile_no' and cus_id='$cus_id' and cat_id='$cat_id'");
    }

    function update_customer_profile($data)
    { 
      $cus_id=$data->cus_id;  
      $name =$data->name;
      $state =$data ->state;
      $city=$data->city;
      $address=$data->address;
      $gender=$data->gender;
      $date_of_birth=$data->date_of_birth;
      $area=$data->area;
      $pincode =$data->pincode;
      $mobile_no =$data ->mobile_no;
      $email_id=$data->email_id;
      $latitude=$data->latitude;
      $longitude=$data->longitude;
      $cus_image =$data ->cus_image;
      $active_status='1';
      date_default_timezone_set('Asia/kolkata'); 
      $now = date('Y-m-d H:i:s');

      $this->db->query("UPDATE registration_customer SET name='$name',state='$state',city='$city',address='$address',area='$area',gender='$gender',date_of_birth='$date_of_birth',pincode='$pincode',mobile_no='$mobile_no',email_id='$email_id',latitude='$latitude',longitude='$longitude',cus_image='$cus_image',active_status='$active_status'where cus_id='$cus_id' and mobile_no='$mobile_no'");

    }

     function unfavourite_category1($data)
    {   
      $mobile_no =$data->mobile_no;
      $cus_id =$data ->cus_id;
      $cat_id=$data->cat_id;
      $sub_cat_id=$data->sub_cat_id;
      $time_date=$data->time_date;
      $this->db->query("UPDATE tbl_favourite_category SET status='0' where mobile_no='$mobile_no' and cus_id='$cus_id' and sub_cat_id='$sub_cat_id'");
    }

     function unfavourite_category2($data)
    {   
      $mobile_no =$data->mobile_no;
      $cus_id =$data ->cus_id;
      $cat_id=$data->cat_id;
      $sub_cat_id=$data->sub_cat_id;
      $super_sub_cat_id=$data->super_sub_cat_id;
      $time_date=$data->time_date;
      $this->db->query("UPDATE tbl_favourite_category SET status='0' where mobile_no='$mobile_no' and cus_id='$cus_id' and super_sub_cat_id='$super_sub_cat_id'");
    }

     function send_set_time_for_notification($data)
    {   
      $cus_id =$data->cus_id;
      $notification_id =$data ->notification_id;
      $radius =$data ->radius;
      $set_time=$data->set_time;
      $cat_id=$data->cat_id;
      $sub_cat_id=$data->sub_cat_id;
      $super_sub_cat_id=$data->super_sub_cat_id;

      if($sub_cat_id=='' and $super_sub_cat_id=='')
      {
      
         $this->db->query("UPDATE notified_near_by_hawker_for_customer SET set_time='$set_time',radius='$radius' where notification_id='$notification_id' and  cus_id='$cus_id' and cat_id='$cat_id'");
      }
      else if($super_sub_cat_id=='')
      {

         $this->db->query("UPDATE notified_near_by_hawker_for_customer SET set_time='$set_time',radius='$radius' where notification_id='$notification_id' and  cus_id='$cus_id' and cat_id='$cat_id' and sub_cat_id='$sub_cat_id'");
      }
      else
      {
        $this->db->query("UPDATE notified_near_by_hawker_for_customer SET set_time='$set_time',radius='$radius' where notification_id='$notification_id' and  cus_id='$cus_id' and cat_id='$cat_id' and sub_cat_id='$sub_cat_id' and super_sub_cat_id='$super_sub_cat_id'");
      }
     
    }

    function Validate_custumer($mobile_no,$password)
    {
         $q=$this->db->where(['mobile_no'=>$mobile_no,'password'=>$password])
          ->get('registration_customer');
           return($q->row());
    }

     function customer_data($mobile_no)
    {
         $q=$this->db->where(['mobile_no'=>$mobile_no])
          ->get('registration_customer');
           return($q->row());
    }

    function check_login_seller_data($referal_code)
    {
        $q=$this->db->query("SELECT mobile_no_contact from registration_sellers where mobile_no_contact='".$referal_code."' and (verification_status =1 or  verification_by_call = 1) and referral_status='1'");
         return($q->row());
        $row = $q->num_rows();
    }

    function get_referral_code($data)
    {
        $device_id =$data->device_id;
        $mobile_no =$data ->mobile_no;
        $q=$this->db->query("SELECT customer_referral_code from tbl_hawker_referal_code_for_customer where customer_mobile_no='".$mobile_no."' and device_id='".$device_id."' ");
         return($q->row());
        $row = $q->num_rows();
    }

    function get_custumer_data($mobile_no,$password,$id)
    {
         $q=$this->db->query("SELECT * from registration_customer where id='".$id."'");
         $row = $que->num_rows();
         if($row>0)
         {
            return true;
         }
         else
         {
            return false;
         }
     }

     ////////Add Registartion Custumer data //////////
    function Add_registration_custumer_data($data)
    {
        $userId =$data->cus_id;
        $name =$data ->name;
        $mobile_no=$data->mobile_no;
        $device_id=$data->device_id;
        $notification_id=$data->notification_id;
        $login_time=$data->login_time;
        $emailID=$data->email_id;
        $address=$data->address;
        $query=$this->db->get_where($this->tablecustumerlogin,['user_id'=>$userId,'device_id'=>$device_id])->num_rows();
        $query1=$this->db->get_where($this->tablecustumerlogin,['user_id'=>$userId])->num_rows();

        if($query>0)
        {
            date_default_timezone_set('Asia/kolkata'); 
            $now = date('Y-m-d H:i:s');
            $this->db->where('user_id',$userId);  
            $this->db->update($this->tablecustumerlogin, ['login_time'=>$now,'notification_id'=>$notification_id,'active_status'=>'1']);
        }
         else if($query1>0)
        {
          date_default_timezone_set('Asia/kolkata'); 
            $now = date('Y-m-d H:i:s');
            $this->db->where('user_id',$userId);  
            $this->db->update($this->tablecustumerlogin, ['login_time'=>$now,'device_id'=>$device_id,'notification_id'=>$notification_id,'active_status'=>'1']);
            
        }
        else
        {
              $query="insert into login_manage_custumer(user_id,name,mobile_no,email_id,address,device_id,notification_id,login_time,status,active_status) values('$userId','$name','$mobile_no','$emailID','$address','$device_id','$notification_id','$login_time','1','1')";
        
             $this->db->query($query);
        }
     }

     

     ////////Validate category data //////////
    function Validate_catdata($data)
    {
        $userId = $data->id;
        $cat_id =$data ->cat_id;
        $shop_id=$data->shop_id;
        
        $query=$this->db->get_where($this->registration_seller,['id'=>$data->id])->num_rows();

        if($query>0)
        {
            $this->db->where('id', $data->id);  
            $this->db->update($this->registration_seller, ['cat_id'=>$cat_id]);
        }
       
     }
    ////////Validate category data //////////

    ////////Update Image Seller  data //////////
    function update_image_seller($data)
    {
        $sales_id=$data->sales_id;
        $shop_id = $data->shop_id;
        $profile_image =$data ->profile_image;
        $identity_proof_front_image=$data->identity_proof_front_image;
        $identity_proof_back_image=$data->identity_proof_back_image;
        $shop_image=$data->shop_image;
       $this->db->where('shop_id',$data->shop_id,'sales_id',$data->sales_id);  
       $this->db->update($this->registration_seller, ['profile_image'=>$profile_image,'identity_proof_front_image'=>$identity_proof_front_image,'identity_proof_back_image'=>$identity_proof_back_image,'shop_image'=>$shop_image]);
     }

     ////////Update Image Seller  data //////////

    ////////Validate salesuser data //////////
    function Validate_fixer_user($data)
     {
        $shopID = $data->shop_id;
        $q=$this->db->query("SELECT * from registration_sellers where shop_id='".$shopID."'");
         return($q->row());
        $row = $q->num_rows();
     }

     ////////Validate salesuser data //////////

     ////////IMAGE URL//////////
    function get_image_url($type = '', $id = '')
    {
        if (file_exists('manage/catImages/' . $id . '.jpg'))
            $image_url = base_url() . 'manage/catImages/' . $type . '_image/' . $id . '.jpg';
        else
            $image_url = 'http://10.0.0.15/fixer_goolean/manage/catImages/'.$id.'';

        return $image_url;
    }

     ////////IMAGE URL//////////

 ////////IMAGE URL fixer//////////
    function get_image_fixer_url($type = '', $id = '')
    {
        if (file_exists('assets/upload/' . $id . '.jpg'))
            $image_url = base_url() . 'assets/upload/' . $type . '_image/' . $id . '.jpg';
        else
            $image_url = base_url() . 'assets/upload/'.$id.'';

        return $image_url;
    }

     ////////IMAGE URL fixer//////////

     function check_data_by_location($gps_id)
     {  

        $q=$this->db->query("SELECT * from gps_seller_location where shop_gps_id='$gps_id' order by id desc limit 1");
         return($q->result_array());
     }

      function get_device_data($hawker_code)
     {  
       
        $q=$this->db->query("SELECT device_id from login_manage_seller where user_id='$hawker_code'");
         return($q->result_array());
     }

      function check_data_by_registerseller($cat_id,$city)
    {  
      $q=$this->db->query("SELECT name,user_type,shop_latitude,shop_longitude,shop_gps_id,mobile_no_contact,business_mobile_no,hawker_code,menu_image,menu_image_2,menu_image_3,menu_image_4,seasonal_temp_hawker_type from registration_sellers where FIND_IN_SET('".$cat_id."', cat_id) and city='".$city."' and user_type='Fix' and duty_status='1' order by id DESC");
       return($q->result_array());
    }

    function check_data_by_registerseller_temp_fix($cat_id,$city)
    {  
      $q=$this->db->query("SELECT name,user_type,shop_latitude,shop_longitude,shop_gps_id,mobile_no_contact,business_mobile_no,hawker_code,menu_image,menu_image_2,menu_image_3,menu_image_4,seasonal_temp_hawker_type from registration_sellers where FIND_IN_SET('".$cat_id."', cat_id) and city='".$city."' and user_type='Temporary' and  seasonal_temp_hawker_type='Fix' and duty_status='1' order by id DESC");
       return($q->result_array());
    }
       function check_data_by_registerseller_seasonal_fix($cat_id,$city)
    {  
      $q=$this->db->query("SELECT name,user_type,shop_latitude,shop_longitude,shop_gps_id,mobile_no_contact,business_mobile_no,hawker_code,menu_image,menu_image_2,menu_image_3,menu_image_4,seasonal_temp_hawker_type from registration_sellers where FIND_IN_SET('".$cat_id."', cat_id) and city='".$city."' and user_type='Seasonal' and  seasonal_temp_hawker_type='Fix' and duty_status='1' order by id DESC");
       return($q->result_array());
    }
    function check_data_by_registerseller_temp_moving($cat_id,$city)
    {  
      $q=$this->db->query("SELECT name,user_type,shop_latitude,shop_longitude,shop_gps_id,mobile_no_contact,business_mobile_no,hawker_code,menu_image,menu_image_2,menu_image_3,menu_image_4,seasonal_temp_hawker_type from registration_sellers where FIND_IN_SET('".$cat_id."', cat_id) and city='".$city."' and user_type='Temporary' and  seasonal_temp_hawker_type='Moving' and duty_status='1' order by id DESC");
       return($q->result_array());
    }
     function check_data_by_registerseller_seasonal_moving($cat_id,$city)
    {  
      $q=$this->db->query("SELECT name,user_type,shop_latitude,shop_longitude,shop_gps_id,mobile_no_contact,business_mobile_no,hawker_code,menu_image,menu_image_2,menu_image_3,menu_image_4,seasonal_temp_hawker_type from registration_sellers where FIND_IN_SET('".$cat_id."', cat_id) and city='".$city."' and user_type='Seasonal' and  seasonal_temp_hawker_type='Moving' and duty_status='1' order by id DESC");
       return($q->result_array());
    }

    function check_data_by_registerseller1($sub_cat_id,$city)
    {  
      $q=$this->db->query("SELECT name,user_type,shop_latitude,shop_longitude,shop_gps_id,mobile_no_contact,business_mobile_no,hawker_code,seasonal_temp_hawker_type,menu_image,menu_image_2,menu_image_3,menu_image_4 from registration_sellers where FIND_IN_SET('".$sub_cat_id."', sub_cat_id) and city='".$city."'and user_type='Fix' and duty_status='1' order by id DESC");
       return($q->result_array());
    }
     function check_data_by_registerseller1_temp_fix($sub_cat_id,$city)
    {  
      $q=$this->db->query("SELECT name,user_type,shop_latitude,shop_longitude,shop_gps_id,mobile_no_contact,business_mobile_no,hawker_code,menu_image,menu_image_2,menu_image_3,menu_image_4,seasonal_temp_hawker_type from registration_sellers where FIND_IN_SET('".$sub_cat_id."', sub_cat_id) and city='".$city."'and user_type='Temporary' and  seasonal_temp_hawker_type='Fix'  and duty_status='1' order by id DESC");
       return($q->result_array());
    }
     function check_data_by_registerseller1_seasonal_fix($sub_cat_id,$city)
    {  
      $q=$this->db->query("SELECT name,user_type,shop_latitude,shop_longitude,shop_gps_id,mobile_no_contact,business_mobile_no,hawker_code,menu_image,menu_image_2,menu_image_3,menu_image_4,seasonal_temp_hawker_type from registration_sellers where FIND_IN_SET('".$sub_cat_id."', sub_cat_id) and city='".$city."'and user_type='Seasonal' and  seasonal_temp_hawker_type='Fix'  and duty_status='1' order by id DESC");
       return($q->result_array());
    }
    function check_data_by_registerseller1_seasonal_moving($sub_cat_id,$city)
    {  
      $q=$this->db->query("SELECT name,user_type,shop_latitude,shop_longitude,shop_gps_id,mobile_no_contact,business_mobile_no,hawker_code,menu_image,menu_image_2,menu_image_3,menu_image_4,seasonal_temp_hawker_type from registration_sellers where FIND_IN_SET('".$sub_cat_id."', sub_cat_id) and city='".$city."'and user_type='Seasonal' and  seasonal_temp_hawker_type='Moving'  and duty_status='1' order by id DESC");
       return($q->result_array());
    }


  function check_data_by_registerseller1_temp_moving($sub_cat_id,$city)
    {  
      $q=$this->db->query("SELECT name,user_type,shop_latitude,shop_longitude,shop_gps_id,mobile_no_contact,business_mobile_no,hawker_code,menu_image,menu_image_2,menu_image_3,menu_image_4,seasonal_temp_hawker_type from registration_sellers where FIND_IN_SET('".$sub_cat_id."', sub_cat_id) and city='".$city."'and user_type='Temporary' and  seasonal_temp_hawker_type='Moving'  and duty_status='1' order by id DESC");
       return($q->result_array());
    }
    function check_data_by_registerseller2($cat_id,$city)
    {  
      $q=$this->db->query("SELECT name,user_type,shop_latitude,shop_longitude,shop_gps_id,mobile_no_contact,business_mobile_no,hawker_code,menu_image,menu_image_2,menu_image_3,menu_image_4,seasonal_temp_hawker_type from registration_sellers where FIND_IN_SET('".$cat_id."', cat_id) and city='".$city."' and user_type='Moving' and duty_status='1' order by id DESC");
       return($q->result_array());
     /*  print_r("SELECT name,user_type,shop_latitude,shop_longitude,shop_gps_id,mobile_no_contact,business_mobile_no,hawker_code from registration_sellers where FIND_IN_SET('".$cat_id."', cat_id) and city='".$city."' and user_type='Moving'");
       die();*/
    }
      function check_data_by_registerseller3($sub_cat_id,$city)
    {  
      $q=$this->db->query("SELECT name,user_type,shop_latitude,shop_longitude,shop_gps_id,mobile_no_contact,business_mobile_no,hawker_code,menu_image,menu_image_2,menu_image_3,menu_image_4,seasonal_temp_hawker_type from registration_sellers where FIND_IN_SET('".$sub_cat_id."', sub_cat_id) and city='".$city."' and user_type='Moving' and duty_status='1' order by id DESC");
       return($q->result_array());
      /*  print_r("SELECT name,user_type,shop_latitude,shop_longitude,shop_gps_id,mobile_no_contact,business_mobile_no,hawker_code from registration_sellers where FIND_IN_SET('".$sub_cat_id."', sub_cat_id) and city='".$city."' and user_type='Moving'");
       die();*/

    }
    
     function near_by_hawker_notified_data()
    {  
      $q=$this->db->query("SELECT * from notified_near_by_hawker_for_customer where  status='1'");
      return($q->result_array());
    }

      function category_data_profile()
     {  
       
        $q=$this->db->get_where('fixer_category',['fixer_category.status'=>'1']);
                        
          return($q->result_array());
     }

     function festive_base_category_data_profile()
     {  
       
        $q=$this->db->query("SELECT * from fixer_category where status='1' and type='Tempory'");
          return($q->result_array());
       /* $q=$this->db->where(['status'=>'1'])->where(['type'=>'Tempory'])->or_where(['status'=>'1'],['type'=>'Festive'])->get('fixer_category');

           return $q->result_array();*/

     }
     function seasanal_festive_base_category_data_profile()
     {  
       
        $q=$this->db->query("SELECT * from fixer_category where status='1' and type='Festive'");
          return($q->result_array());
       

     }


      function get_city_data($data)
     {  
        $city =$data->city;
        $Pincode =$data->Pincode;
        $q=$this->db->query("SELECT Pincode,city,status from tbl_pincode_by_city where Pincode='".$Pincode."' OR city='$city' and status='1'");
          return($q->row());
        $row = $q->num_rows();
     }

      function get_gps_sales_location_data()
     {  
        $q=$this->db->query("SELECT * FROM gps_sales_location WHERE  sales_id='SAL_000010' limit 5");
          return($q->result_array());
     }
     


      function priority_category_data_profile()
     {  
           $q=$this->db->query("SELECT * from fixer_category where status='1' and type='Moving' ORDER BY priority='Top' DESC, priority='High' DESC, priority='Medium' DESC, priority='Low' DESC");
          return($q->result_array());
     }
     function check_data_status()
     {  
           $q=$this->db->query("SELECT * from fixer_category where status='1'");
          return($q->result_array());
     }
     function priority_category_data_profile1()
     {  
           $q=$this->db->query("SELECT * from fixer_category where status='1' and type='Fix' and type='Fix' ORDER BY priority='Top' DESC, priority='High' DESC, priority='Medium' DESC, priority='Low' DESC");
          return($q->result_array());
     }
     function trending_category_data()
     {  
           $q=$this->db->query("SELECT * from fixer_category where status='1' and priority='Trending'");
          return($q->result_array());
          print_r("SELECT * from fixer_category where status='1' and priority='Trending'");
          die();
     }
     function trending_sub_category_data()
     {  
           $q=$this->db->query("SELECT * from fixer_sub_category where status='1' and priority='Trending'");
          return($q->result_array());
     }
     function favourite_category_data_profile($cus_id)
     { 
         $q=$this->db->query("SELECT cat_id,sub_cat_id,super_sub_cat_id from tbl_favourite_category where cus_id='$cus_id' and status='1'");
          return($q->result_array());
     }

      function customer_profile($cus_id,$mobile_no)
     { 
         $q=$this->db->query("SELECT * from registration_customer where cus_id='$cus_id' and mobile_no='$mobile_no' and active_status='1'");
           return($q->row());
     }

      function customer_cat_data($cat_id)
     { 
         $q=$this->db->query("SELECT cat_icon_image,cat_name from fixer_category where id='$cat_id' and status='1'");
           return($q->row());
     }

      function customer_sub_cat_data($sub_cat_id)
     { 
         $q=$this->db->query("SELECT sub_cat_image,sub_cat_name,category from fixer_sub_category where id='$sub_cat_id' and status='1'");
           return($q->row());
     }

      public function getSubCategory($cat_id)
     {
         $q = $this->db->get_where('fixer_sub_category',['fixer_sub_category.category'=>$cat_id,'fixer_sub_category.status'=>'1']);
        return($q->result_array());
     }

     public function getcategory($where)
     {
         $q=$this->db->query("SELECT * from fixer_category where id='$where'");
         return($q->result_array());
     }

       public function catgory_notification_data($where)
     {
         $q=$this->db->query("SELECT * from tbl_add_category_notified where cus_id='$where' and status='1' order by id desc");
         return($q->result_array());
     }

     public function sub_catgory_notification_data($where)
     {
         $q=$this->db->query("SELECT * from tbl_add_sub_category_notified where cus_id='$where'and status='1' order by id desc");
         return($q->result_array());
     }

      public function moving_notification_data($where)
     {
         $q=$this->db->query("SELECT * from tbl_notified_moving_data where cus_id='$where' and status='1' order by id desc");
         return($q->result_array());
     }
     public function get_sub_category($where)
     {
         $q=$this->db->query("SELECT * from fixer_sub_category where id='$where'");
         return($q->result_array());
     }

     public function get_super_sub_category($where)
     {
         $q=$this->db->query("SELECT * from fixer_super_sub_category where id='$where'");
         return($q->result_array());
     }

     public function getSuperSubCategory($cat_id,$sub_cat_id)
     {
         $q=$this->db->query("SELECT * from fixer_super_sub_category where cat_id='$cat_id' and sub_cat_id='$sub_cat_id' and status='1'");
         return($q->result_array());
     }

      public function get_menu_image_data($mobile_no)
     {
         $q=$this->db->query("SELECT menu_image,menu_image_2,menu_image_3,menu_image_4 from registration_sellers where mobile_no_contact='$mobile_no'");
          return($q->row());
     }

      function logout_customer_data($data)
    {
        $active_status='0';
        $cus_id = $data->cus_id;
        $device_id = $data->device_id;
        $now = $data->logout_time;
         $this->db->query("UPDATE login_manage_custumer SET active_status='$active_status',logout_time='$now',notification_id='NULL' where user_id='$cus_id' and device_id='$device_id'");
    }

     public function fetch_category($where)
     {
       $query = $this->db->get_where('tbl_favourite_category',$where)->result_array();  
        return $query;   
     }
      public function fetch_sub_category($where)
     {
        $query = $this->db->get_where('tbl_favourite_category',$where)->result_array();  
         return $query;   
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
        $cus_id=$data->cus_id;
        $otp=$data->otp;
        date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
        $query=$this->db->get_where($this->tbl_otp_customer,['cus_id'=>$data->cus_id,'device_id'=>$device_id])->num_rows();
        if($query>0)
        {
            $this->db->where('cus_id', $data->cus_id,'device_id', $data->device_id);  
            $this->db->update($this->tbl_otp_customer, ['date_time'=>$now,'notification_id'=>$notification_id,'mobile_no'=>$mobile_no,'otp'=>$otp]);
        }
        else
        {
        $query="insert into tbl_otp_customer(cus_id,mobile_no,otp,device_id,notification_id,date_time) values('$cus_id','$mobile_no','$otp','$device_id','$notification_id','$now')";
        $this->db->query($query);
        }
      }
      function verification_otp($data)
     { 
        $device_id=$data->device_id;
        $mobile_no=$data->mobile_no;
        $otp=$data->otp;
        $q=$this->db->query("SELECT mobile_no,cus_id from tbl_otp_customer where otp='".$otp."' and  device_id='".$device_id."' and mobile_no='".$mobile_no."'");
          return($q->row());
        $row = $q->num_rows();
     }
     function notification_data($referal_code)
     { 
        $q=$this->db->query("SELECT notification_id from login_manage_seller where mobile_no='".$referal_code."'");
          return($q->row());
        $row = $q->num_rows();
     }

      function resend_otp($data)
     {
        $mobile_no=$data->mobile_no;
        $device_id=$data->device_id;
        $otp=$data->otp;
        date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
        $query=$this->db->get_where($this->tbl_otp_customer,['mobile_no'=>$data->mobile_no,'device_id'=>$device_id])->num_rows();
        if($query>0)
        {
            $this->db->where('device_id', $data->device_id,'mobile_no', $data->mobile_no);  
            $this->db->update($this->tbl_otp_customer, ['date_time'=>$now,'otp'=>$otp]);
        }
        
      }

       function remove_otp($data)
     {
        $mobile_no=$data->mobile_no;
        $device_id=$data->device_id;
        $query=$this->db->get_where($this->tbl_otp_customer,['mobile_no'=>$data->mobile_no,'device_id'=>$device_id])->num_rows();
        if($query>0)
        {
            $this->db->where('device_id', $data->device_id,'mobile_no', $data->mobile_no);  
            $this->db->update($this->tbl_otp_customer, ['date_time'=>$now,'otp'=>'NULL']);
        }
        
      }

     function get_data_by_customer($data)
    {   
       $insert = $this->db->insert($this->tbl_customer_call_by_hawker, $data);
       return $insert?$this->db->insert_id():false;
    }
     function get_navigate_by_customer($data)
    {   
       $insert = $this->db->insert($this->tbl_customer_navigate_by_hawker, $data);
       return $insert?$this->db->insert_id():false;
    }

     /*function Validate_version_data($data)
     {
       
        $version_name = $data->version_name;
        $version_code = $data->version_code;
         $q=$this->db->query("SELECT * from check_version_for_customer where version_name='".$version_name."' and version_code='".$version_code."'");
          return($q->row());
        $row = $q->num_rows();
     }*/

      function Validate_version_data($data)
     {
       
        $version_name = $data->version_name;
        $version_code = $data->version_code;
         $q=$this->db->query("SELECT * from check_version_for_customer where status='1'");
          return($q->row());
        $row = $q->num_rows();
    }

     function update_version_data($data)
    {   
       $version_name = $data->version_name;
       $version_code = $data->version_code;
       date_default_timezone_set('Asia/kolkata'); 
       $now = date('Y-m-d H:i:s');
       $this->db->query("UPDATE check_version_for_customer SET version_name='$version_name', version_code='$version_code',date_time='$now'");
    }

     function get_hawker_notification_id($hawker_code,$hawker_mobile_no)
     { 
         $q=$this->db->query("SELECT notification_id FROM login_manage_seller where user_id='$hawker_code' and  mobile_no='$hawker_mobile_no'");
        // print_r("SELECT notification_id FROM login_manage_seller where user_id='$hawker_code'");

         return($q->result_array());
     }

    
   }
?>