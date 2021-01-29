<?php

class Seller extends CI_Model
{    
    private $tabledata='login_manage_sales';
    private $registration_seller='registration_sellers';
    private $tablesellerlogin='login_manage_seller';
    private $gps_seller_location='gps_seller_location';
    private $duty_on_off_by_seller='duty_on_off_by_seller';
    private $tbl_otp='tbl_otp_seller';
    private $tbl_request_for_hawker_advertisement='tbl_request_for_hawker_advertisement';
    private $tbl_history_hawker_for_not_servicable_area='tbl_history_hawker_for_not_servicable_area';
    private $tbl_history_for_servicable_and_not_register_hawker='tbl_history_for_servicable_and_not_register_hawker';
    private $tbl_history_for_received_money_by_hawker='tbl_history_for_received_money_by_hawker';

    function add($data)
    {
        $insert = $this->db->insert($this->registration_seller, $data);
        return $insert?$this->db->insert_id():false;
    }

   /* function history_profile($data23)
    {
        $insert = $this->db->insert($this->tbl_history_for_hawker_profile, $data23);
        return $insert?$this->db->insert_id():false;
    }*/

      function history_data_for_not_servicable_area($data1)
    {
        $insert = $this->db->insert($this->tbl_history_hawker_for_not_servicable_area, $data1);
        return $insert?$this->db->insert_id():false;
    }


      function history_for_received_money($data)
    {
        $insert = $this->db->insert($this->tbl_history_for_received_money_by_hawker, $data);
        return $insert?$this->db->insert_id():false;
    }
     function historydata_servicable_area_and_not_register($data1)
    {
        $insert = $this->db->insert($this->tbl_history_for_servicable_and_not_register_hawker, $data1);
        return $insert?$this->db->insert_id():false;
    }

      function seller_location_add_data($data)
    {
        $insert = $this->db->insert($this->gps_seller_location, $data);
        return $insert?$this->db->insert_id():false;
    }


      function request_for_hawker_advertisements($data)
    {
        $insert = $this->db->insert($this->tbl_request_for_hawker_advertisement, $data);
        return $insert?$this->db->insert_id():false;
    }

    function update_shop_id($alphanumerric,$result)
    {   
      $this->db->query("UPDATE registration_sellers SET shop_id='$alphanumerric' where id='$result'");
    }

     function referral_money_data($mobile_no)
    {   

     $this->db->query("UPDATE tbl_hawker_referal_code_for_customer SET referral_flag_status='0',money_received_status='1' where referal_code='$mobile_no' and limit_status!='1'");
     if ($this->db->affected_rows() > 0)
      return 1;
     else
      return 0;
    }

    function update_customer_id($alphanumerric,$result)
    {   
      $this->db->query("UPDATE registration_customer SET cus_id='$alphanumerric' where id='$result'");
    }

    function update_duty_status_data($hawker_code,$duty_status)
    {   
      $this->db->query("UPDATE registration_sellers SET duty_status='$duty_status' where hawker_code='$hawker_code'");
    }

    
   
     ////////Add Registartion Custumer data //////////
    function Add_registration_seller_data($data)
    {
        $userId =$data->hawker_code;
        $name =$data ->name;
        $mobile_no=$data->mobile_no;
        $device_id=$data->device_id;
        $notification_id=$data->notification_id;
        $login_time=$data->login_time;
        $query=$this->db->get_where($this->tablesellerlogin,['user_id'=>$userId,'mobile_no'=>$mobile_no,'device_id'=>$device_id])->num_rows();

         $query1=$this->db->get_where($this->tablesellerlogin,['user_id'=>$data->hawker_code])->num_rows();

        if($query>0)
        {
            date_default_timezone_set('Asia/kolkata'); 
            $now = date('Y-m-d H:i:s');
            $this->db->where('user_id',$userId);  
            $this->db->update($this->tablesellerlogin, ['user_id'=>$userId,'login_time'=>$now,'notification_id'=>$notification_id,'active_status'=>'1']);
        }

          else if($query1>0)
        {
        
        }
        else
        {
              $query="insert into login_manage_seller(user_id,name,mobile_no,device_id,notification_id,login_time,status,active_status) values('$userId','$name','$mobile_no','$device_id','$notification_id','$login_time','1','1')";
             $this->db->query($query);
        }
     }

     ////////Add Registration Custumer data //////////

      function notified_data($data)
    {
        $device_id =$data->device_id;
        $notification_id =$data ->notification_id;
        $date_time=$data->date_time;
        $mobile_no=$data->mobile_no;
              $query="insert into tbl_hawker_notified(mobile_no,device_id,notification_id,date_time,status) values('$mobile_no','$device_id','$notification_id','$date_time','1')";
             $this->db->query($query);
        
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
         $hawker_code = $data->hawker_code;
        $q=$this->db->query("SELECT * from registration_sellers where hawker_code='".$hawker_code."'");
         return($q->row());
        $row = $q->num_rows();
     }

     function check_notified_data($mobile_no)
     {
        $q=$this->db->query("SELECT * from tbl_hawker_notified where mobile_no='".$mobile_no."'");
         return($q->row());
        $row = $q->num_rows();
     }

     function check_history_servicable_area($mobile_no)
     {
        $q=$this->db->query("SELECT mobile_no from tbl_history_for_servicable_and_not_register_hawker where mobile_no='".$mobile_no."'");
         return($q->row());
        $row = $q->num_rows();
     }


      function Validate_version_data($data)
     {
       
        $version_name = $data->version_name;
        $version_code = $data->version_code;
         $q=$this->db->query("SELECT * from check_version_for_hawker where status='1'");
          return($q->row());
        $row = $q->num_rows();
    }


      function Validate_fixer_user_data($hawker_code)
     {
       
        $q=$this->db->query("SELECT * from registration_sellers where hawker_code='".$hawker_code."'");
         return($q->row());
        $row = $q->num_rows();
     }

     ////////Validate salesuser data //////////

      ////////check device  for seller //////////
    function check_device_for_seller($data)
     {
         $hawker_code = $data->hawker_code;
        $q=$this->db->query("SELECT * from login_manage_seller where user_id='".$hawker_code."'");
          return($q->row());
        $row = $q->num_rows();
     }

     ////////check device for  seller //////////

      function check_login_validate_data($data)
     {
        $hawker_code = $data->hawker_code;
        $q=$this->db->query("SELECT * from login_manage_seller where user_id='".$hawker_code."'");
          return($q->row());
        $row = $q->num_rows();
     }

       function check_city_status_seller($data)
     {
        $city =$data->city;
        $Pincode =$data->Pincode;
        $q=$this->db->query("SELECT Pincode,city,status from tbl_pincode_by_city where Pincode='".$Pincode."' OR city='$city' and status='1'");
          return($q->row());
        $row = $q->num_rows();
     }

     function history_data_for_hawker($hawker_code)
     {
        $q=$this->db->query("SELECT * from tbl_show_location_by_hawker_history where hawker_code=$hawker_code and description!='' order by date_time desc ");
           return($q->result_array());
        $row = $q->num_rows();
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

     function duty_data_by_seller($data)
    {
        $insert = $this->db->insert($this->duty_on_off_by_seller, $data);
        return $insert?$this->db->insert_id():false;
    }

     function check_duty_data_by_seller($hawker_code)
     {  
        $q=$this->db->query("SELECT * from duty_on_off_by_seller where seller_id='$hawker_code'  order by id desc limit 1");
         return($q->row());
     }

      function check_data_seller_profile($data)
     {  
        $hawker_code = $data->hawker_code;
        $q=$this->db->where(['hawker_code'=>$hawker_code/*,'active_status'=>'1'*/])
          ->get('registration_sellers');
          return($q->row());
     }

     function logout_seller_data($data)
     {
        $active_status='0';
        $hawker_code = $data->hawker_code;
        $now = $data->logout_time;
        $this->db->where('user_id',$hawker_code);  
        $this->db->update($this->tablesellerlogin, ['active_status'=>$active_status,'logout_time'=>$now]);
     }
     function check_data_by_location($gps_id)
     {  
       
        $q=$this->db->query("SELECT * from gps_seller_location where shop_gps_id='$gps_id' order by id desc limit 1");
         return($q->row());
     }

   /* function check_data_by_registerseller($cat_id)
    {  
      $q=$this->db->query("SELECT * from registration_sellers where FIND_IN_SET('".$cat_id."', cat_id)");
      return($q->row());
                     
     }*/
      function fetch_login_data($data)
     {
        $mobile_no = $data->mobile_no;
        $q=$this->db->query("SELECT * from login_manage_seller where mobile_no='".$mobile_no."'");
          return($q->row());
        $row = $q->num_rows();
     }

      function check_logout_data_seller($hawker_code)
     {  

        $q=$this->db->query("SELECT * from login_manage_seller where user_id='$hawker_code'");
         return($q->row());
     }
      function insert_duty_status__for_seller($data3)
    {
        $insert = $this->db->insert($this->duty_on_off_by_seller, $data3);
        return $insert?$this->db->insert_id():false;
    }

     function fetch_hawker_data($data)
     {
        $mobile_no = $data->mobile_no;
        $q=$this->db->query("SELECT * from registration_sellers where mobile_no_contact='".$mobile_no."'");
          return($q->row());
        $row = $q->num_rows();
     }
     function update_login_data($data)
     {
       $device_id=$data->device_id;
        $notification_id=$data->notification_id;
        $login_time=$data->login_time;
        $mobile_no = $data->mobile_no;
         $this->db->where('mobile_no', $data->mobile_no);  
             $this->db->update($this->tablesellerlogin, ['login_time'=>$login_time,'notification_id'=>$notification_id,'device_id'=>$device_id,'active_status'=>'1']);
     }
     public function check_total_count_call($hawker_code)
     {
        date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d');
        $q=$this->db->query("SELECT hawker_id from tbl_customer_call_by_hawker where hawker_id='".$hawker_code."' and date_time LIKE '%$now%'");
        return($q->num_rows());
     }

     public function get_referral_data($referral_code)
     { 
        $q=$this->db->query("SELECT referal_code from tbl_hawker_referal_code_for_customer where referal_code='".$referal_code."'");
        return($q->num_rows());
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

        $seller_id=$data->hawker_code;
        $otp=$data->otp;
        date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
        $query=$this->db->get_where($this->tbl_otp,['seller_id'=>$data->hawker_code,'device_id'=>$device_id])->num_rows();
      
        if($query>0)
        {   
             $this->db->query("UPDATE tbl_otp_seller SET date_time='$now',notification_id='$notification_id',mobile_no='$mobile_no',otp='$otp' where seller_id='$seller_id' and device_id='$device_id'");
        }
        else
        {
        $query="insert into tbl_otp_seller(seller_id,mobile_no,otp,device_id,notification_id,date_time) values('$seller_id','$mobile_no','$otp','$device_id','$notification_id','$now')";
        $this->db->query($query);
        }
      }
       function verification_otp($data)
     { 
        $device_id=$data->device_id;
        $mobile_no=$data->mobile_no;
        $otp=$data->otp;
        $q=$this->db->query("SELECT mobile_no from tbl_otp_seller where otp='".$otp."' and  device_id='".$device_id."' and mobile_no='".$mobile_no."'");
          return($q->row());
        $row = $q->num_rows();
     }

     function fetch_hawker_data_for_customer($data)
     {
        $hawker_code = $data->hawker_code;
        $q=$this->db->query("SELECT cat_id,sub_cat_id,super_sub_cat_id from registration_sellers where hawker_code='".$hawker_code."'");
          return($q->row());
        $row = $q->num_rows();
     }

      public function update_catstatus_data($where)
     {
         $cat_id = $where;
    
            $this->db->where_in('id', $where);
            $this->db->update('fixer_category', ['status'=>"1"]);
            /* $this->db->query("UPDATE fixer_category SET status='2' where id='$where'");*/
       /* print_r("UPDATE fixer_category SET status='2' where id='$cat_id'");
        die();*/
           /*return;*/
     }
     public function update_sub_cat_status_data($where)
     {
         $cat_id = $where;
        /* print_r($cat_id);
         die();*/
         //$str_arr = explode (",", $cat_id);  
        
            $this->db->where_in('id', $where);
            $this->db->update('fixer_sub_category', ['status'=>"1"]);
            /* $this->db->query("UPDATE fixer_category SET status='2' where id='$where'");*/
       /* print_r("UPDATE fixer_category SET status='2' where id='$cat_id'");
        die();*/
           /*return;*/
     }
   
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
              $this->db->query("UPDATE tbl_otp_seller SET date_time='$now',otp='$otp' where mobile_no='$mobile_no' and device_id='$device_id'");
        
        }
      }

      function remove_otp($data)
     {
        $mobile_no=$data->mobile_no;
        $device_id=$data->device_id;
        $query=$this->db->get_where($this->tbl_otp,['mobile_no'=>$data->mobile_no,'device_id'=>$device_id])->num_rows();
        if($query>0)
        {
            $this->db->query("UPDATE tbl_otp_seller SET date_time='$now',otp='NULL' where mobile_no='$mobile_no' and device_id='$device_id'");
        }
      }
       function update_version_data($data)
    {   
       $version_name = $data->version_name;
       $version_code = $data->version_code;
       date_default_timezone_set('Asia/kolkata'); 
       $now = date('Y-m-d H:i:s');
       $this->db->query("UPDATE check_version_for_hawker SET version_name='$version_name', version_code='$version_code',date_time='$now'");
    }

    function update_duty_status__for_seller($data4)
    {   
       $hawker_code = $data4->hawker_code;
       $duty_status = $data4->duty_status;
      
       $this->db->query("UPDATE registration_sellers SET duty_status='$duty_status' where hawker_code='$hawker_code'");
    }

    function close_share_location_by_customer($data)
    {   
       $hawker_code = $data->hawker_code;
       $hawker_mobile_no = $data->hawker_mobile_no;
       $customer_mobile_no = $data->customer_mobile_no;
       $close_status = $data->close_status;
       $description = $data->description;
       $close_latitude = $data->close_latitude;
       $close_longitude = $data->close_longitude;
       date_default_timezone_set('Asia/kolkata'); 
       $now = date('Y-m-d H:i:s');
      
       $this->db->query("UPDATE tbl_show_location_by_hawker SET close_status='$close_status', close_date_time='$now',description='$description',close_latitude='$close_latitude',close_longitude='$close_longitude' where hawker_code='$hawker_code' and customer_mobile_no='$customer_mobile_no'");
    }

   }
?>