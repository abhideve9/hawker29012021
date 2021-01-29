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
    private $tbl_customer_request_for_referral_money='tbl_customer_request_for_referral_money';
    private $tbl_customer_top_search_hawker='tbl_customer_top_search_hawker';
    private $tbl_review_for_hawker='tbl_review_for_hawker';

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

    function flag_status_update_for_customer($data2)
    {   
      $mobile_no=$data2->mobile_no;
      $query=$this->db->get_where($this->tbl_genrate_referral_code_for_customer,['mobile_no'=>$mobile_no,'money_received_status'=>'1'])->num_rows();
      if($query>0)
      {
            
      }
      else
      {  
        $insert = $this->db->insert($this->tbl_genrate_referral_code_for_customer, $data2);
        return $insert?$this->db->insert_id():false;
      }
    }

     function get_referral_code_for_customer($data2)
    {   
        $device_id=$data2->device_id;
        $mobile_no=$data2->mobile_no;
        $city=$data2->city;
        $pincode=$data2->pincode;
        $genrate_referral_code=$data2->genrate_referral_code;
        $customer_point=$data2->customer_point;
        $date_time=$data2->date_time;
        $date=$data2->date;
        $status='1';
        $referral_flag_status='0';

        $referral_code=$data2->referral_code;

        $status=$data2->status;
        $query=$this->db->query("select * from tbl_genrate_referral_code_for_customer where  mobile_no='".$mobile_no."' and genrate_referral_code='".$referral_code."'");

        $row1 = $query->num_rows();

        $query1=$this->db->get_where($this->tbl_genrate_referral_code_for_customer,['mobile_no'=>$mobile_no])->num_rows();

         $que=$this->db->query("select * from tbl_genrate_referral_code_for_customer where  mobile_no='".$mobile_no."'");
  
         $row = $que->num_rows();

      
        if($row1>0)
        {
          $q=$this->db->query("SELECT genrate_referral_code from tbl_genrate_referral_code_for_customer where mobile_no='".$mobile_no."'");
           return($q->row());
        
        }
        else if($row>0)
        {
        /* print_r("UPDATE tbl_genrate_referral_code_for_customer SET genrate_referral_code='$genrate_referral_code' where mobile_no='$mobile_no'");
         die();*/
          $this->db->query("UPDATE tbl_genrate_referral_code_for_customer SET genrate_referral_code='$genrate_referral_code' where mobile_no='$mobile_no'");
        }
        else
        {
        $device_id=$data2->device_id;
        $mobile_no=$data2->mobile_no;
         $city=$data2->city;
        $pincode=$data2->pincode;
        $genrate_referral_code=$data2->genrate_referral_code;
        $customer_point=$data2->customer_point;
        $date_time=$data2->date_time;
        $date=$data2->date;
        $status='1';
        $referral_flag_status='0';

         /* $insert = $this->db->insert($this->tbl_genrate_referral_code_for_customer, $data2);
          return $insert?$this->db->insert_id():false;*/
        $query="insert into tbl_genrate_referral_code_for_customer(device_id,mobile_no,city,pincode,genrate_referral_code,date_time,date,status,referral_flag_status) values('$device_id','$mobile_no','$city','$pincode','$genrate_referral_code','$date_time','$date','$status','$referral_flag_status')";
        
             $this->db->query($query);
        }
    }


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

     function request_customer_referral_money_data($data)
    {   
       $insert = $this->db->insert($this->tbl_customer_request_for_referral_money, $data);
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

       function resent_search_hawker($data)
       {
        $hawker_code=$data->hawker_code;
        $cus_id=$data->cus_id;
        $device_id=$data->device_id;
        $name=$data->name;
        $search_cat_name=$data->search_cat_name;
        $mobile_no=$data->mobile_no;
        $cat_id=$data->cat_id;
        $sub_cat_id=$data->sub_cat_id;
        $super_sub_cat_id=$data->super_sub_cat_id;
        $create_date=$data->create_date;
        $status=$data->status;
        date_default_timezone_set('Asia/kolkata'); 
            $now = date('Y-m-d H:i:s');
        $query=$this->db->get_where($this->tbl_customer_top_search_hawker,['hawker_code'=>$hawker_code,'device_id'=>$device_id])->num_rows();
        if($query>0)
        {
            $this->db->query("UPDATE tbl_customer_top_search_hawker SET create_date='$now' where device_id='$device_id' and hawker_code='$hawker_code'");
        }
        else
        {
              $query="insert into tbl_customer_top_search_hawker(hawker_code,cus_id,name,search_cat_name,mobile_no,device_id,cat_id,sub_cat_id,super_sub_cat_id,create_date,status) values('$hawker_code','$cus_id','$name','$search_cat_name','$mobile_no','$device_id','$cat_id','$sub_cat_id','$super_sub_cat_id','$create_date',$status)";
        
             $this->db->query($query);
        }
      }

      function review_for_hawker_customer($data)
       {
        $hawker_code=$data->hawker_code;
        $hawker_name=$data->hawker_name;
        $device_id=$data->device_id;
        $review_point=$data->review_point;
        $cus_id=$data->cus_id;
        $customer_mobile_no=$data->customer_mobile_no;
        $create_date=$data->create_date;
        $status=$data->status;
        date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
        $query=$this->db->get_where($this->tbl_review_for_hawker,['hawker_code'=>$hawker_code,'device_id'=>$device_id])->num_rows();
        if($query>0)
        {
            $this->db->query("UPDATE tbl_review_for_hawker SET review_point='$review_point', modified_date='$now' where device_id='$device_id' and hawker_code='$hawker_code'");
        }
        else
        {
              $query="insert into tbl_review_for_hawker(hawker_code,device_id,hawker_name,review_point,cus_id,customer_mobile_no,create_date,status) values('$hawker_code','$device_id','$hawker_name','$review_point','$cus_id','$customer_mobile_no','$create_date',$status)";
        
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

     function update_referral_data($mobile_no)
    { 
      $this->db->query("UPDATE tbl_genrate_referral_code_for_customer SET referral_flag_status='2' where mobile_no='$mobile_no'");
    }

     function update_status_referral_point($referal_code,$mobile_no,$referral_point,$coupon_amount,$customer_mobile_no)
     {   
      date_default_timezone_set('Asia/kolkata'); 
      $now = date('Y-m-d H:i:s');
      $nows = date('Y-m-d');
      $referral_point=$referral_point;
      $amount=$referral_point + $coupon_amounts;
      $test= date('m');
     // echo "SELECT SUM(customer_point) as cus_point from tbl_genrate_referral_code_for_customer where customer_referral_code='$referal_code' and MONTH(date)='$test' and is_reffer_code_apply=1";exit;
       $query=$this->db->query("SELECT SUM(customer_point) as cus_point from tbl_genrate_referral_code_for_customer where customer_referral_code='$referal_code' and MONTH(date)='$test' and is_reffer_code_apply=1");
       $customer_point_data=$query->row();
       $customer_point_data=isset($customer_point_data->cus_point)?$customer_point_data->cus_point:'0';
     
       //echo $customer_point_data;exit;
     if($customer_point_data <=2000)
     {
   
     $q=$this->db->query("SELECT customer_referral_code, customer_point from tbl_genrate_referral_code_for_customer where mobile_no='$mobile_no' and customer_referral_code IS NULL and customer_point='0' and status='1'");
       $row=$q->row();
     // print_r($row);exit;
      if (isset($row) && !empty($row)) {
     	$qq=$this->db->query("SELECT count(*) as referral_count from tbl_genrate_referral_code_for_customer where customer_referral_code='$referal_code' and status='1' and date='$nows'");
     	$referral_code_count=$qq->row();

     	if($referral_code_count->referral_count <=5){
      
      $this->db->where('customer_referral_code',$referal_code);
      $this->db->where('mobile_no',$customer_mobile_no);
      $this->db->UPDATE('tbl_genrate_referral_code_for_customer',array('is_reffer_code_apply'=>'1'));
     //print_r($this->db->last_query());exit;
   
    
      $this->db->query("UPDATE tbl_genrate_referral_code_for_customer SET referral_point=referral_point+'$coupon_amount', total_point= referral_point+customer_point ,referral_flag_status='1' where genrate_referral_code='$referal_code'");

     		}
      }
     // else{

     //  $qr=$this->db->query("SELECT count(*) as referral_count from tbl_genrate_referral_code_for_customer where customer_referral_code='$referal_code' and status='1' and date='$nows'");
     // 		$referral_code_count=$qr->row();
     		
     // 	if($referral_code_count->referral_count <=5){
       
     //  $this->db->where('customer_referral_code',$referal_code);
     //  $this->db->where('mobile_no',$customer_mobile_no);
     //  $this->db->UPDATE('tbl_genrate_referral_code_for_customer',array('is_reffer_code_apply'=>'1'));
      

     //    $this->db->query("UPDATE tbl_genrate_referral_code_for_customer SET referral_point=referral_point+'$coupon_amount', total_point= referral_point+customer_point ,referral_flag_status='1' where genrate_referral_code='$referal_code'");
     //  		}
     //         }
           }
       
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

    function get_referral_voucher_data($data)
    {
      $amount =$data->amount;

      $coupon_code =$data ->type;
      
      $q=$this->db->query("SELECT * from tbl_referral_coupon_code where type='$coupon_code' and Amount='$amount' and status='1' limit 1");
      return($q->row());
   /*   return($q->num_rows());*/
    }

    function check_voucher_data($data)
    {
      $amount =$data->Amount;
      $type =$data ->type;
      
      $q=$this->db->query("SELECT * from tbl_referral_coupon_code where type='$type' and Amount='$amount'  and status='1'");
      return($q->row());
   
    }


    function check_login_seller_data($referal_code)
    {
        $q=$this->db->query("SELECT mobile_no_contact from registration_sellers where mobile_no_contact='".$referal_code."' and (verification_status =1 or  verification_by_call = 1) and referral_status='1'");
         return($q->row());
        $row = $q->num_rows();
    }

    function fetch_update_status_referral_point($referal_code)
    {
      /*rint_r("SELECT mobile_no,referral_point,city,pincode from tbl_genrate_referral_code_for_customer where genrate_referral_code='$referal_code' and customer_point='0'");
      die();*/
        $q=$this->db->query("SELECT mobile_no,referral_point,city,pincode from tbl_genrate_referral_code_for_customer where genrate_referral_code='$referal_code' and customer_point='0'");
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

     function get_customer_point_data($mobile_no)
    {
       
        $q=$this->db->query("SELECT SUM(customer_point)from tbl_genrate_referral_code_for_customer where  mobile_no='$mobile_no' and referral_flag_status='1' and limit_status!='1'");
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
         // print_r($this->db->last_query());echo '<br>';
         return($q->result_array());
     }

      function get_device_data($hawker_code)
     {  
       
        $q=$this->db->query("SELECT device_id from login_manage_seller where user_id='$hawker_code'");
         return($q->result_array());
     }

    function check_data_by_registerseller($array,$city)
    {  
     

      $q=$this->db->query("SELECT `rs`.`business_name` as `name`,`rs`.`user_type`,`rs`.`shop_latitude`,`rs`.`shop_longitude`,`rs`.`shop_gps_id`,`rs`.`mobile_no_contact`,`rs`.`business_mobile_no`,`rs`.`hawker_code`,`rs`.`menu_image`,`rs`.`menu_image_2`,`rs`.`menu_image_3`,`rs`.`menu_image_4`,`rs`.`seasonal_temp_hawker_type` from `registration_sellers` AS `rs` LEFT JOIN `misc_fixer_category`AS `mfc`ON `mfc`.`hawker_code`=`rs`.`hawker_code`
      WHERE `mfc`.`cat_id` IN ($array) and `rs`.`city`='".$city."' and `rs`.`user_type`='Fix' and `rs`.`duty_status`='1' order by rs.id DESC");
  	// print_r( $this->db->last_query());exit;
  	return($q->result_array());
   }

    function check_data_by_registerseller_temp_fix($array,$city)
    {  


	$q=$this->db->query("SELECT `rs`.`business_name` as `name`,`rs`.`user_type`,`rs`.`shop_latitude`,`rs`.`shop_longitude`,`rs`.`shop_gps_id`,`rs`.`mobile_no_contact`,`rs`.`business_mobile_no`,`rs`.`hawker_code`,`rs`.`menu_image`,`rs`.`menu_image_2`,`rs`.`menu_image_3`,`rs`.`menu_image_4`,`rs`.`seasonal_temp_hawker_type` from `registration_sellers` AS `rs` LEFT JOIN `misc_fixer_category`AS `mfc`ON `mfc`.`hawker_code`=`rs`.`hawker_code`
      WHERE `mfc`.`cat_id` IN ($array) and `rs`.`city`='".$city."' and `rs`.`user_type`='Temporary'AND `rs`.`seasonal_temp_hawker_type`='Fix' and `rs`.`duty_status`='1' order by rs.id DESC");
  // print_r( $this->db->last_query());exit;
       return($q->result_array());
  }
     function check_data_by_registerseller_seasonal_fix($array,$city)
    {  

       $q=$this->db->query("SELECT `rs`.`business_name` as `name`,`rs`.`user_type`,`rs`.`shop_latitude`,`rs`.`shop_longitude`,`rs`.`shop_gps_id`,`rs`.`mobile_no_contact`,`rs`.`business_mobile_no`,`rs`.`hawker_code`,`rs`.`menu_image`,`rs`.`menu_image_2`,`rs`.`menu_image_3`,`rs`.`menu_image_4`,`rs`.`seasonal_temp_hawker_type` from `registration_sellers` AS `rs` LEFT JOIN `misc_fixer_category`AS `mfc`ON `mfc`.`hawker_code`=`rs`.`hawker_code`
      WHERE `mfc`.`cat_id` IN ($array) and `rs`.`city`='".$city."' and `rs`.`user_type`='Seasonal'AND `rs`.`seasonal_temp_hawker_type`='Fix' and `rs`.`duty_status`='1' order by rs.id DESC");
       // print_r( $this->db->last_query());exit;
       return($q->result_array());
    }
    function check_data_by_registerseller_temp_moving($array,$city)
    {  


        $q=$this->db->query("SELECT `rs`.`business_name` as `name`,`rs`.`user_type`,`rs`.`shop_latitude`,`rs`.`shop_longitude`,`rs`.`shop_gps_id`,`rs`.`mobile_no_contact`,`rs`.`business_mobile_no`,`rs`.`hawker_code`,`rs`.`menu_image`,`rs`.`menu_image_2`,`rs`.`menu_image_3`,`rs`.`menu_image_4`,`rs`.`seasonal_temp_hawker_type` from `registration_sellers` AS `rs` LEFT JOIN `misc_fixer_category`AS `mfc`ON `mfc`.`hawker_code`=`rs`.`hawker_code`
      WHERE `mfc`.`cat_id` IN ($array) and `rs`.`city`='".$city."' and `rs`.`user_type`='Temporary'AND `rs`.`seasonal_temp_hawker_type`='Moving' and `rs`.`duty_status`='1' order by rs.id DESC");
        // print_r( $this->db->last_query());exit;
       return($q->result_array());
   }
     function check_data_by_registerseller_seasonal_moving($array,$city)
    {  


       $q=$this->db->query("SELECT `rs`.`business_name` as `name`,`rs`.`user_type`,`rs`.`shop_latitude`,`rs`.`shop_longitude`,`rs`.`shop_gps_id`,`rs`.`mobile_no_contact`,`rs`.`business_mobile_no`,`rs`.`hawker_code`,`rs`.`menu_image`,`rs`.`menu_image_2`,`rs`.`menu_image_3`,`rs`.`menu_image_4`,`rs`.`seasonal_temp_hawker_type` from `registration_sellers` AS `rs` LEFT JOIN `misc_fixer_category`AS `mfc`ON `mfc`.`hawker_code`=`rs`.`hawker_code`
      WHERE `mfc`.`cat_id` IN ($array) and `rs`.`city`='".$city."' and `rs`.`user_type`='Temporary'AND `rs`.`seasonal_temp_hawker_type`='Moving' and `rs`.`duty_status`='1' order by rs.id DESC");
       // print_r( $this->db->last_query());exit;
       return($q->result_array());
    }

    function check_data_by_registerseller1($array,$city)
    {  

	 $q=$this->db->query("SELECT `rs`.`business_name` as `name`,`rs`.`user_type`,`rs`.`shop_latitude`,`rs`.`shop_longitude`,`rs`.`shop_gps_id`,`rs`.`mobile_no_contact`,`rs`.`business_mobile_no`,`rs`.`hawker_code`,`rs`.`menu_image`,`rs`.`menu_image_2`,`rs`.`menu_image_3`,`rs`.`menu_image_4`,`rs`.`seasonal_temp_hawker_type` from `registration_sellers` AS `rs` LEFT JOIN `misc_fixer_sub_category`AS `mfc`ON `mfc`.`hawker_code`=`rs`.`hawker_code`
      WHERE `mfc`.`sub_cat_id` IN ($array) and `rs`.`city`='".$city."' and `rs`.`user_type`='Fix'and `rs`.`duty_status`='1' order by rs.id DESC");
     // print_r( $this->db->last_query());exit;
         return($q->result_array()); 
   }
     function check_data_by_registerseller1_temp_fix($array,$city)
    {  


     $q=$this->db->query("SELECT `rs`.`business_name` as `name`,`rs`.`user_type`,`rs`.`shop_latitude`,`rs`.`shop_longitude`,`rs`.`shop_gps_id`,`rs`.`mobile_no_contact`,`rs`.`business_mobile_no`,`rs`.`hawker_code`,`rs`.`menu_image`,`rs`.`menu_image_2`,`rs`.`menu_image_3`,`rs`.`menu_image_4`,`rs`.`seasonal_temp_hawker_type` from `registration_sellers` AS `rs` LEFT JOIN `misc_fixer_sub_category`AS `mfc`ON `mfc`.`hawker_code`=`rs`.`hawker_code`
      WHERE `mfc`.`sub_cat_id` IN ($array) and `rs`.`city`='".$city."' and `rs`.`user_type`='Temporary'and `rs`.`seasonal_temp_hawker_type`='Fix'and  `rs`.`duty_status`='1' order by rs.id DESC");
       //print_r( $this->db->last_query());exit;
 return($q->result_array());
   }
     function check_data_by_registerseller1_seasonal_fix($array,$city)
    {  
     $q=$this->db->query("SELECT `rs`.`business_name` as `name`,`rs`.`user_type`,`rs`.`shop_latitude`,`rs`.`shop_longitude`,`rs`.`shop_gps_id`,`rs`.`mobile_no_contact`,`rs`.`business_mobile_no`,`rs`.`hawker_code`,`rs`.`menu_image`,`rs`.`menu_image_2`,`rs`.`menu_image_3`,`rs`.`menu_image_4`,`rs`.`seasonal_temp_hawker_type` from `registration_sellers` AS `rs` LEFT JOIN `misc_fixer_sub_category`AS `mfc`ON `mfc`.`hawker_code`=`rs`.`hawker_code`
      WHERE `mfc`.`sub_cat_id` IN ($array) and `rs`.`city`='".$city."' and `rs`.`user_type`='Seasonal'and `rs`.`seasonal_temp_hawker_type`='Fix'and  `rs`.`duty_status`='1' order by rs.id DESC");
       return($q->result_array());
   }
    function check_data_by_registerseller1_seasonal_moving($array,$city)
    {  
      $q=$this->db->query("SELECT `rs`.`business_name` as `name`,`rs`.`user_type`,`rs`.`shop_latitude`,`rs`.`shop_longitude`,`rs`.`shop_gps_id`,`rs`.`mobile_no_contact`,`rs`.`business_mobile_no`,`rs`.`hawker_code`,`rs`.`menu_image`,`rs`.`menu_image_2`,`rs`.`menu_image_3`,`rs`.`menu_image_4`,`rs`.`seasonal_temp_hawker_type` from `registration_sellers` AS `rs` LEFT JOIN `misc_fixer_sub_category`AS `mfc`ON `mfc`.`hawker_code`=`rs`.`hawker_code`
      WHERE `mfc`.`sub_cat_id` IN ($array) and `rs`.`city`='".$city."' and `rs`.`user_type`='Seasonal'and `rs`.`seasonal_temp_hawker_type`='Moving'and  `rs`.`duty_status`='1' order by rs.id DESC");
       return($q->result_array());
   }


  function check_data_by_registerseller1_temp_moving($array,$city)
    {  
     $q=$this->db->query("SELECT `rs`.`business_name` as `name`,`rs`.`user_type`,`rs`.`shop_latitude`,`rs`.`shop_longitude`,`rs`.`shop_gps_id`,`rs`.`mobile_no_contact`,`rs`.`business_mobile_no`,`rs`.`hawker_code`,`rs`.`menu_image`,`rs`.`menu_image_2`,`rs`.`menu_image_3`,`rs`.`menu_image_4`,`rs`.`seasonal_temp_hawker_type` from `registration_sellers` AS `rs` LEFT JOIN `misc_fixer_sub_category`AS `mfc`ON `mfc`.`hawker_code`=`rs`.`hawker_code`
      WHERE `mfc`.`sub_cat_id` IN ($array) and `rs`.`city`='".$city."' and `rs`.`user_type`='Temporary'and `rs`.`seasonal_temp_hawker_type`='Moving'and  `rs`.`duty_status`='1' order by rs.id DESC");
       return($q->result_array());
   }
    function check_data_by_registerseller2($array,$city)
    {  
      $q=$this->db->query("SELECT `rs`.`business_name` as `name`,`rs`.`user_type`,`rs`.`shop_latitude`,`rs`.`shop_longitude`,`rs`.`shop_gps_id`,`rs`.`mobile_no_contact`,`rs`.`business_mobile_no`,`rs`.`hawker_code`,`rs`.`menu_image`,`rs`.`menu_image_2`,`rs`.`menu_image_3`,`rs`.`menu_image_4`,`rs`.`seasonal_temp_hawker_type` from `registration_sellers` AS `rs` LEFT JOIN `misc_fixer_category`AS `mfc`ON `mfc`.`hawker_code`=`rs`.`hawker_code`
      WHERE `mfc`.`cat_id` IN ($array) and `rs`.`city`='".$city."' and `rs`.`user_type`='Moving'and  `rs`.`duty_status`='1' order by rs.id DESC");
       return($q->result_array());
   }
     function check_data_by_registerseller3($array,$city)
    {  
      $q=$this->db->query("SELECT `rs`.`business_name` as `name`,`rs`.`user_type`,`rs`.`shop_latitude`,`rs`.`shop_longitude`,`rs`.`shop_gps_id`,`rs`.`mobile_no_contact`,`rs`.`business_mobile_no`,`rs`.`hawker_code`,`rs`.`menu_image`,`rs`.`menu_image_2`,`rs`.`menu_image_3`,`rs`.`menu_image_4`,`rs`.`seasonal_temp_hawker_type` from `registration_sellers` AS `rs` LEFT JOIN `misc_fixer_category`AS `mfc`ON `mfc`.`hawker_code`=`rs`.`hawker_code`
      WHERE `mfc`.`cat_id` IN ($array) and `rs`.`city`='".$city."' and `rs`.`user_type`='Moving'and  `rs`.`duty_status`='1' order by rs.id DESC");
      
  return($q->result_array());
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
       
        $q=$this->db->query("SELECT * from fixer_category where status='1' and type='Tempory' and festive_status=1");
        // print_r($this->db->last_query());exit;
          return($q->result_array());
      }
     function seasanal_festive_base_category_data_profile()
     {  
       
        $q=$this->db->query("SELECT * from fixer_category where status='1' and type='Festive'and festive_status=1");
        // print_r($this->db->last_query());exit;
          return($q->result_array());
     }


      function get_city_data($data)
     {  
        $city =$data->city;
        $Pincode =$data->Pincode;
        $q=$this->db->query("SELECT Pincode,city,status from tbl_pincode_by_city where (Pincode='".$Pincode."' OR city='$city') and status='1'");
          return($q->row());
        $row = $q->num_rows();
     }

      function get_city_data_amount($data)
     {  
        $city =$data->city;
        $pincode =$data->pincode;
        /*print_r("SELECT Pincode,city,status,coupon_amount from tbl_pincode_by_city where (Pincode='".$pincode."' OR city='$city') and status='1'");
        die();*/
        $q=$this->db->query("SELECT Pincode,city,status,coupon_amount from tbl_pincode_by_city where (Pincode='".$pincode."' OR city='$city') and status='1'");
          return($q->row());
        $row = $q->num_rows();
     }

     function get_city_data_amounts($city,$pincode)
     {  
       /* $city =$data->city;
        $pincode =$data->pincode;*/
       /* print_r("SELECT Pincode,city,status,coupon_amount from tbl_pincode_by_city where (Pincode='".$pincode."' OR city='$city') and status='1'");
        die();*/
        $q=$this->db->query("SELECT Pincode,city,status,coupon_amount from tbl_pincode_by_city where (Pincode='".$pincode."' OR city='$city') and status='1'");
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
           $q=$this->db->query("SELECT DISTINCT cat_name,cat_icon_image,master_cat_id,check_level_customer from fixer_category where status='1' and ads_status=0 and type!='Tempory' and type!='Festive' ORDER BY priority='Top1' DESC ,priority='Top2' DESC, priority='Top3' DESC, priority='Top4' DESC,priority='Top' DESC,create_date DESC");
            // print_r($this->db->last_query());exit;
          return($q->result_array());
     }
     function check_data_status()
     {  
           $q=$this->db->query("SELECT * from fixer_category where status='1'");
          return($q->result_array());
     }

     function get_id_data_for_category($masterdata)
     {  
           $q=$this->db->query("SELECT id,master_cat_id from fixer_category where master_cat_id='$masterdata' and  status='1'");
          return($q->result_array());
     }

     function get_subcategory_data($masterdata)
     {  
           $q=$this->db->query("SELECT id,master_cat_id,master_sub_cat_id from fixer_sub_category where master_cat_id='$masterdata' and  status='1'");
          return($q->result_array());
     }

     function priority_category_data_profile1()
     {  
           $q=$this->db->query("SELECT * from fixer_category where status='4' and type='Fix' and type='Fix' ORDER BY priority='Top' DESC, priority='High' DESC, priority='Medium' DESC, priority='Low' DESC");
            // print_r($this->db->last_query());exit;
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

      function customer_cat_data($array)
     { 
	//echo "SELECT cat_icon_image,cat_name,cat_icon_image_map from fixer_category where id IN ($array) /*id='$cat_id'*/ and status='1'";exit;
         $q=$this->db->query("SELECT cat_icon_image,cat_name,cat_icon_image_map from fixer_category where id IN ($array) /*id='$cat_id'*/ and status='1'");
           return($q->row());
     }
     function customer_cat_data_for_fix($array)
     { 
	//echo "SELECT cat_icon_image,cat_name,cat_icon_image_map from fixer_category where id IN ($array) /*id='$cat_id'*/ and type='Fix' and status='1'";exit;
         $q=$this->db->query("SELECT cat_icon_image,cat_name,cat_icon_image_map from fixer_category where id IN ($array) /*id='$cat_id'*/ and type='Fix' and status='1'");
           return($q->row());
     }

     function customer_cat_data_for_Moving($array)
     { 
         $q=$this->db->query("SELECT cat_icon_image,cat_name,cat_icon_image_map from fixer_category where id IN ($array) /*id='$cat_id'*/ and type='Moving' and status='1'");
           return($q->row());
     }



      function get_subcat_id_data($sub_cat_id)
     { 
         $q=$this->db->query("SELECT id from fixer_sub_category where master_sub_cat_id='$sub_cat_id' and status='1'");
          return($q->result_array());
     }

     function get_cat_id_data($cat_id)
     { 
	//echo "SELECT id from fixer_category where master_cat_id='$cat_id' and status='1'";exit;
         $q=$this->db->query("SELECT id from fixer_category where master_cat_id='$cat_id' and status='1'");
          return($q->result_array());
     }

      function customer_sub_cat_data($array)
     { 
         $q=$this->db->query("SELECT sub_cat_image,sub_cat_name,category from fixer_sub_category where id IN ($array) /*id='$sub_cat_id'*/ and status='1'");
           return($q->row());
     }

     function customer_sub_cat_data_fix($array)
     { 
      //echo "SELECT sub_cat_image,sub_cat_name,category,sub_cat_image_map from fixer_sub_category where id IN ($array) /*id='$sub_cat_id'*/ and type='Fix' and status='1'";exit;
         $q=$this->db->query("SELECT sub_cat_image,sub_cat_name,category,sub_cat_image_map from fixer_sub_category where id IN ($array) /*id='$sub_cat_id'*/ and type='Fix' and status='1'");
           return($q->row());
     }

     function customer_sub_cat_data_Moving($array)
     { 
         $q=$this->db->query("SELECT sub_cat_image,sub_cat_name,category,sub_cat_image_map from fixer_sub_category where id IN ($array) /*id='$sub_cat_id'*/ and type='Moving' and status='1'");
           return($q->row());
     }

      public function getSubCategory($cat_id)
     {
    
        $q=$this->db->query("SELECT DISTINCT sub_cat_image,sub_cat_name,check_level_customer,master_cat_id,master_sub_cat_id from fixer_sub_category where master_cat_id='$cat_id' and status='1'");

        /* $q = $this->db->get_where('fixer_sub_category',['fixer_sub_category.master_cat_id'=>$cat_id,'fixer_sub_category.status'=>'1']);*/
        return($q->result_array());
     }

     public function getcategory($where)
     {
         $q=$this->db->query("SELECT * from fixer_category where master_cat_id='$where' Limit 1");
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
         $q=$this->db->query("SELECT * from fixer_sub_category where master_sub_cat_id='$where' Limit 1");
         return($q->result_array());
     }

     public function get_super_sub_category($where)
     {
         $q=$this->db->query("SELECT * from fixer_super_sub_category where master_super_sub_cat_id='$where' Limit 1");
         return($q->result_array());
     }

     public function getSuperSubCategory($cat_id,$sub_cat_id)
     {
   // file_put_contents("test.txt","SELECT * from fixer_super_sub_category where cat_id='$cat_id' and sub_cat_id='$sub_cat_id' and status='1'");
 $file = fopen("test.txt","w");
echo fwrite($file,"SELECT * from fixer_super_sub_category where cat_id='$cat_id' and sub_cat_id='$sub_cat_id' and status='1'");
fclose($file);

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

    function average_rating_hawker($hawker_code_data)
     {
      /* print_r("SELECT AVG(review_point) as AVGRATE from tbl_review_for_hawker where hawker_code='$hawker_code_data'");
       die();*/
         $q=$this->db->query("SELECT AVG(review_point) as AVGRATE from tbl_review_for_hawker where hawker_code='$hawker_code'");
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

     function getMobileNo($hawker_code)
    { 
    
    $this->db->select('mobile_no_contact');
    $this->db->from('registration_sellers');
    $this->db->where('hawker_code',$hawker_code);
    $query = $this->db->get();
    $result=$query->result_array();
    // print_r($result);exit;
    return $result[0]['mobile_no_contact'];

 }
  public function getMerchant()
       {
            $this->db->select('rs.hawker_code,rs.shop_latitude,rs.shop_longitude,pabm.ads_id');
            $this->db->from('registration_sellers AS rs');
            $this->db->join('paid_advertisement_by_merchant AS pabm','rs.hawker_code=pabm.hawker_code');
            $this->db->where('rs.user_type','Fix');
            $this->db->where('pabm.payment_status','Paid');
            $this->db->where('pabm.ads_status','Ongoing');
            $query=$this->db->get();
            // print_r( $this->db->last_query());exit;
            $result=$query->result_array();
            return $result;
       }
  
   public function getNearByMerchantImages($hawker_code,$ads_id)
   {

    $this->db->SELECT('pabm.banner_img,pabm.advertisement_title AS paid_title,pabm.detail_of_advertisement AS paid_advertisement,pabm.ads_id');
    $this->db->FROM('paid_advertisement_by_merchant AS pabm');
    $this->db->where('pabm.hawker_code',$hawker_code);
    $this->db->where('pabm.ads_id',$ads_id);
    $this->db->where('pabm.payment_status','Paid');
    $this->db->where('pabm.ads_status','Ongoing');
    $this->db->where('pabm.aproval_status','1');


    $query=$this->db->get();
    // print_r($this->db->last_query());exit;
    $result=$query->result_array();
    return $result;
    }


   function getMerchantImage($hawker_code,$ads_id)
   {

    $this->db->select('pabm.*,rs.shop_latitude,rs.shop_longitude');
    $this->db->from('paid_advertisement_by_merchant AS pabm');
    $this->db->JOIN('registration_sellers AS rs','rs.hawker_code=pabm.hawker_code','LEFT');
    $this->db->where('pabm.hawker_code',$hawker_code);
    $this->db->where('pabm.ads_id',$ads_id);
    $this->db->where('rs.user_type','FIX');
    $this->db->where('pabm.payment_status','Paid');
    $this->db->where('pabm.ads_status','Ongoing');

    $query=$this->db->get();
     //print_r($this->db->last_query());exit;
    $result=$query->result_array();
     // print_r($result);exit;
    return $result;

   }   function checkMerchant($hawker_code)
   {

        $this->db->select('*');
        $this->db->where('hawker_code',$hawker_code);
        $this->db->from('registration_sellers');
        $query=$this->db->get();
        $result=$query->result_array();
        return $result;

   }

   function updateRedeemData($mobile_no,$amount)
   {

    $this->db->where('mobile_no',$mobile_no);
    $this->db->UPDATE('tbl_genrate_referral_code_for_customer',array('total_point'=>$amount,'customer_point'=>0,'referral_point'=>$amount));
    // print_r($this->db->last_query());exit;
    $result = $this->db->affected_rows();
    return $result;
   }
  function getRedeemData($mobile_no)
   {
    
    $this->db->select('total_point');
    $this->db->FROM('tbl_genrate_referral_code_for_customer');
    $this->db->where('mobile_no',$mobile_no);
    $query=$this->db->get();
    // print_r($this->db->last_query());exit;
    $result=$query->result_array();
    return $result[0]['total_point'];
   }
   function insertRedeemRequest($reddemArray)
   {

    $this->db->insert('redeem_request',$reddemArray);
    return  $this->db->insert_id();

   }
   public function getFreeMerchant($lat1,$lon1)
       {
            $this->db->select('rs.hawker_code,pabm.advertisement_title,pabm.detail_of_advertisement,pabm.mobile_no,
                  ROUND(
                    (
                      3959 * ACOS(
                        LEAST(
                          1.0,
                          COS(RADIANS(rs.shop_latitude)) * COS(RADIANS('.$lat1.')) * COS(
                            RADIANS('.$lon1.') - RADIANS(rs.shop_longitude)
                          ) + SIN(RADIANS(rs.shop_latitude)) * SIN(RADIANS('.$lat1.'))
                        )
                      )
                    )*1000,4
                  ) AS DISTANCE');
            $this->db->from('registration_sellers AS rs');
            $this->db->join('tbl_request_for_hawker_advertisement AS pabm','rs.hawker_code=pabm.hawker_code','RIGHT');
            $this->db->where('rs.user_type','Fix');
            $this->db->where('pabm.status','1');
            $this->db->where('pabm.aproval_status','1');
            $this->db->having('DISTANCE<=',3*1000);
            $query=$this->db->get();
            // print_r($this->db->last_query());exit;
            $result=$query->result_array();
            return $result;
       }
public function getFreeHawkerImages($hawker_code)
    {
      $this->db->select('hawker_code,mobile_no,advertisement_title,detail_of_advertisement,image_1,image_2');
      $this->db->FROM('tbl_request_for_hawker_advertisement');
      $this->db->where('hawker_code',$hawker_code);
      $this->db->where('status','1');
      $this->db->where('aproval_status','1');
      $query=$this->db->get();
      // print_r($this->db->last_query());exit;
      $result=$query->result_array();
      return $result; 
    }
public function getCouponCode($mobilie_no,$cust_id)
    {
      $this->db->select('coupon_code,expiry_date,amount');
      $this->db->FROM('redeem_request');
      $this->db->where('cust_id',$cust_id);
      $this->db->where('mobile_no ',$mobilie_no);
      $this->db->where('redeem_req_status ','Approved');
      $this->db->where('CURDATE() <= STR_TO_DATE(expiry_date,"%Y-%m-%d")');
      $query=$this->db->get();
      // print_r($this->db->last_query());exit;
      $result=$query->result_array();
      return $result;
    }
public function getParameter()
    {

      $this->db->select('min_value,inc_value,redeem_val,max_val');
      $this->db->FROM('factor_calulation');
      $this->db->where('status ','1');
      $query=$this->db->get();
      // print_r($this->db->last_query());exit;
      $result=$query->result_array();
      return $result;
    }
 public function getBannerCategory()
    {
      $this->db->select('cat_name,cat_icon_image,type,id,status');
      $this->db->FROM('fixer_category');
      //$this->db->Limit(5);
      $this->db->where('ads_status','1');
      //$this->db->where('status','1');
      $this->db->where('festive_status','1');
      $query=$this->db->get();
     // print_r($this->db->last_query());exit;
      $result=$query->result_array();
      return $result;
    }
 public function getBannerCategory_old()
    {
      $this->db->select('fc.cat_name,fc.cat_icon_image,fc.type,fc.id ,rs.hawker_code');
      $this->db->FROM('tbl_request_for_hawker_advertisement AS rfha');
      $this->db->JOIN('registration_sellers AS rs','rs.hawker_code=rfha.hawker_code','LEFT');
      $this->db->JOIN('fixer_category AS fc','fc.id=rs.cat_id ','LEFT');
      // $this->db->Limit(5);
      $this->db->where('fc.ads_status','1');
      $this->db->where('fc.status','1');
      $query=$this->db->get();
      // print_r($this->db->last_query());exit;
      $result=$query->result_array();
      return $result;
    }
 public function getNearByMerchant($lat1,$lon1,$type_id)
       {
            $this->db->select('rs.hawker_code,pabm.advertisement_title,pabm.detail_of_advertisement,pabm.mobile_no,rs.shop_latitude,rs.shop_longitude,pabm.image_1,pabm.image_2,fc.cat_name,
                  ROUND(
                    (
                      3959 * ACOS(
                        LEAST(
                          1.0,
                          COS(RADIANS(rs.shop_latitude)) * COS(RADIANS('.$lat1.')) * COS(
                            RADIANS('.$lon1.') - RADIANS(rs.shop_longitude)
                          ) + SIN(RADIANS(rs.shop_latitude)) * SIN(RADIANS('.$lat1.'))
                        )
                      )
                    )*1000,4
                  ) AS DISTANCE');
            $this->db->from('registration_sellers AS rs');
            $this->db->join('tbl_request_for_hawker_advertisement AS pabm','rs.hawker_code=pabm.hawker_code','RIGHT');
            $this->db->join('fixer_category AS fc','fc.id=rs.cat_id','RIGHT');
            $this->db->where('rs.user_type','Fix');
            $this->db->where('rs.cat_id',$type_id);
            $this->db->where('fc.status',1);
            $this->db->where('pabm.status','1');
            $this->db->where('pabm.aproval_status','1');
            $this->db->having('DISTANCE<=',3*1000);//Distance in meter 
            $query=$this->db->get();
           // print_r($this->db->last_query());exit;
            $result=$query->result_array();
            return $result;
       }
 public function getOfferImages($mobile_no)
  {

      $this->db->select('hawker_code,mobile_no,advertisement_title,detail_of_advertisement,image_1,image_2');
      $this->db->FROM('tbl_request_for_hawker_advertisement');
      $this->db->where('mobile_no',$mobile_no);
      $this->db->where('status','1');
      $this->db->where('aproval_status','1');
      $query=$this->db->get();
      // print_r($this->db->last_query());exit;
      $result=$query->result_array();
      return $result; 
  }
  function getCityData($data)
     {  
       
        $city =$data->city;
        $pincode =$data->pincode;
        if(!empty($pincode))
        { 
           //echo "SELECT Pincode,city,status,coupon_amount from tbl_pincode_by_city where (Pincode='$pincode') and status='1'";exit;
           $q=$this->db->query("SELECT Pincode,city,status,coupon_amount  from tbl_pincode_by_city where (Pincode='$pincode') and status='1'");
           return($q->row());
           $row = $q->num_rows();

        }else
        {
           $q=$this->db->query("SELECT Pincode,city,status,coupon_amount from tbl_pincode_by_city where (city='$city') and status='1' LIMIT 1");
           return($q->row());
           $row = $q->num_rows();
        }
       
     }
public function getRedeemAmount($mobile_no)
     {
    
      $this->db->select('SUM(amount)AS AMOUNT');
      $this->db->from(TBL_REDEEM);
      $this->db->where('month(created_on)=month(now())');
      $this->db->where('mobile_no',$mobile_no);
      $query=$this->db->get();
      // print_r($this->db->last_query());exit;
      $result=$query->result_array();
      return $result[0]['AMOUNT'];
     }
 public function getStaticImage()
    {
     
      $this->db->select('image AS banner_img');
      $this->db->from(TBL_STATIC_IMAGE);
      $this->db->where('status',1);
      $query=$this->db->get();
      // print_r($this->db->last_query());exit;
      $result=$query->result_array();
      return $result;

    }
 public function getMerchantForDistance($from,$to,$sales_id)
       {
            $this->db->select('rs.shop_latitude,rs.shop_longitude');
            $this->db->from('registration_sellers AS rs');
            $this->db->where('rs.date_time >=',$from);
            $this->db->where('rs.date_time<=',$to);
            $this->db->where('rs.sales_id',$sales_id);
            $query=$this->db->get();
            //print_r( $this->db->last_query());exit;
            $result=$query->result_array();
            return $result;
       }
  public function  saveFixerCategoryCountRecord($arrayData)
  {
   $result=$this->db->insert(TBL_FIXER_COUNT_CATEGORY,$arrayData);
   if($result)
   {
     return $this->db->insert_id();
   }else
   {
     return false;
   }
  }
  }
?>