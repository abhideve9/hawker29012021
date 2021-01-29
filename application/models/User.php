<?php

class User extends CI_Model
{    
    private $notified_near_by_hawker_for_customer='notified_near_by_hawker_for_customer';
    private $tbl_customer_call_by_hawker='tbl_customer_call_by_hawker';
    private $tbl_customer_navigate_by_hawker='tbl_customer_navigate_by_hawker';
    private $history_notified_near_by_hawker_for_customer='history_notified_near_by_hawker_for_customer';
    private $tbl_notified_moving_data='tbl_notified_moving_data';
    private $tbl_history_for_location_customer='tbl_history_for_location_customer';
    private $tbl_near_by_notified_radius='tbl_near_by_notified_radius';
    private $duty_on_by_hawker='duty_on_off_by_seller';

     function insert_notified_data($data)
    {   
       $insert = $this->db->insert($this->tbl_near_by_notified_radius, $data);
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

    function remove_notified_data($cus_id,$notification_id,$cat_id,$sub_cat_id,$super_sub_cat_id)
    {   
       $this->db->delete('notified_near_by_hawker_for_customer', array('cus_id' => $cus_id,'notification_id' => $notification_id,'cat_id'=>$cat_id,'sub_cat_id'=>$sub_cat_id)); 
    }

    function remove_notification_data_in_notification_table($cus_id,$latitudeFrom,$longitudeFrom,$notification_id,$cat_id,$sub_cat_id,$super_sub_cat_id,$radius,$city,$set_time,$date_time,$status)
    {   
       $this->db->delete('notified_near_by_hawker_for_customer', array('cus_id' => $cus_id,'latitude'=>$latitudeFrom,'longitude'=>$longitudeFrom,'notification_id' => $notification_id,'cat_id'=>$cat_id,'sub_cat_id'=>$sub_cat_id)); 
    }

    function near_by_hawker_data($data)
    {   
       $insert = $this->db->insert($this->notified_near_by_hawker_for_customer, $data);
       return $insert?$this->db->insert_id():false;
    }

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

      function check_data_by_registerseller($array,$city)
    {  

      $q=$this->db->query("SELECT name,user_type,shop_latitude,shop_longitude,shop_gps_id,mobile_no_contact,business_mobile_no,hawker_code,menu_image,menu_image_2,menu_image_3,menu_image_4,seasonal_temp_hawker_type from registration_sellers where cat_id in ($array) and city='".$city."' and user_type='Fix' and duty_status='1' order by id DESC");
       return($q->result_array());
    }

   function check_data_by_registerseller_temp_fix($array,$city)
    {  
      $q=$this->db->query("SELECT name,user_type,shop_latitude,shop_longitude,shop_gps_id,mobile_no_contact,business_mobile_no,hawker_code,menu_image,menu_image_2,menu_image_3,menu_image_4,seasonal_temp_hawker_type from registration_sellers where cat_id in ($array) and city='".$city."' and user_type='Temporary' and  seasonal_temp_hawker_type='Fix' and duty_status='1' order by id DESC");
       return($q->result_array());
    }
       function check_data_by_registerseller_seasonal_fix($array,$city)
    {  
      $q=$this->db->query("SELECT name,user_type,shop_latitude,shop_longitude,shop_gps_id,mobile_no_contact,business_mobile_no,hawker_code,menu_image,menu_image_2,menu_image_3,menu_image_4,seasonal_temp_hawker_type from registration_sellers where cat_id in ($array) and city='".$city."' and user_type='Seasonal' and  seasonal_temp_hawker_type='Fix' and duty_status='1' order by id DESC");
       return($q->result_array());
    }
    function check_data_by_registerseller_temp_moving($array,$city)
    {  
      $q=$this->db->query("SELECT name,user_type,shop_latitude,shop_longitude,shop_gps_id,mobile_no_contact,business_mobile_no,hawker_code,menu_image,menu_image_2,menu_image_3,menu_image_4,seasonal_temp_hawker_type from registration_sellers where cat_id in ($array) and city='".$city."' and user_type='Temporary' and  seasonal_temp_hawker_type='Moving' and duty_status='1' order by id DESC");
       return($q->result_array());
    }
     function check_data_by_registerseller_seasonal_moving($array,$city)
    {  
      $q=$this->db->query("SELECT name,user_type,shop_latitude,shop_longitude,shop_gps_id,mobile_no_contact,business_mobile_no,hawker_code,menu_image,menu_image_2,menu_image_3,menu_image_4,seasonal_temp_hawker_type from registration_sellers where cat_id in ($array) and city='".$city."' and user_type='Seasonal' and  seasonal_temp_hawker_type='Moving' and duty_status='1' order by id DESC");
       return($q->result_array());
    }


    function check_data_by_registerseller1($array,$city)
    {  
     
      $q=$this->db->query("SELECT name,user_type,shop_latitude,shop_longitude,shop_gps_id,mobile_no_contact,business_mobile_no,hawker_code,seasonal_temp_hawker_type,menu_image,menu_image_2,menu_image_3,menu_image_4 from registration_sellers where sub_cat_id IN ($array) and city='".$city."'and user_type='Fix' and duty_status='1' order by id DESC");
       return($q->result_array());
    }

     function check_data_by_registerseller1_temp_fix($array,$city)
    {  
      $q=$this->db->query("SELECT name,user_type,shop_latitude,shop_longitude,shop_gps_id,mobile_no_contact,business_mobile_no,hawker_code,menu_image,menu_image_2,menu_image_3,menu_image_4,seasonal_temp_hawker_type from registration_sellers where sub_cat_id IN ($array) and city='".$city."'and user_type='Temporary' and  seasonal_temp_hawker_type='Fix'  and duty_status='1' order by id DESC");
       return($q->result_array());
    }
    function check_data_by_registerseller1_seasonal_fix($array,$city)
    {  
      $q=$this->db->query("SELECT name,user_type,shop_latitude,shop_longitude,shop_gps_id,mobile_no_contact,business_mobile_no,hawker_code,menu_image,menu_image_2,menu_image_3,menu_image_4,seasonal_temp_hawker_type from registration_sellers  where sub_cat_id IN ($array) and city='".$city."'and user_type='Seasonal' and  seasonal_temp_hawker_type='Fix'  and duty_status='1' order by id DESC");
       return($q->result_array());
    }
    function check_data_by_registerseller1_seasonal_moving($array,$city)
    {  
      $q=$this->db->query("SELECT name,user_type,shop_latitude,shop_longitude,shop_gps_id,mobile_no_contact,business_mobile_no,hawker_code,menu_image,menu_image_2,menu_image_3,menu_image_4,seasonal_temp_hawker_type from registration_sellers where sub_cat_id IN ($array) and city='".$city."'and user_type='Seasonal' and  seasonal_temp_hawker_type='Moving'  and duty_status='1' order by id DESC");
       return($q->result_array());
    }
   function check_data_by_registerseller1_temp_moving($array,$city)
    {  
      $q=$this->db->query("SELECT name,user_type,shop_latitude,shop_longitude,shop_gps_id,mobile_no_contact,business_mobile_no,hawker_code,menu_image,menu_image_2,menu_image_3,menu_image_4,seasonal_temp_hawker_type from registration_sellers  where sub_cat_id IN ($array) and city='".$city."'and user_type='Temporary' and  seasonal_temp_hawker_type='Moving'  and duty_status='1' order by id DESC");
       return($q->result_array());
    }
    function check_data_by_registerseller2($array,$city)
    {  
      $q=$this->db->query("SELECT name,user_type,shop_latitude,shop_longitude,shop_gps_id,mobile_no_contact,business_mobile_no,hawker_code,menu_image,menu_image_2,menu_image_3,menu_image_4,seasonal_temp_hawker_type from registration_sellers  where cat_id in ($array)  and city='".$city."' and user_type='Moving' and duty_status='1' order by id DESC");
       return($q->result_array());
     /*  print_r("SELECT name,user_type,shop_latitude,shop_longitude,shop_gps_id,mobile_no_contact,business_mobile_no,hawker_code from registration_sellers where FIND_IN_SET('".$cat_id."', cat_id) and city='".$city."' and user_type='Moving'");
       die();*/
    }
     function check_data_by_registerseller3($array,$city)
    {  
      $q=$this->db->query("SELECT name,user_type,shop_latitude,shop_longitude,shop_gps_id,mobile_no_contact,business_mobile_no,hawker_code,menu_image,menu_image_2,menu_image_3,menu_image_4,seasonal_temp_hawker_type from registration_sellers where sub_cat_id in ($array) and city='".$city."' and user_type='Moving' and duty_status='1' order by id DESC");
       return($q->result_array());
      /*  print_r("SELECT name,user_type,shop_latitude,shop_longitude,shop_gps_id,mobile_no_contact,business_mobile_no,hawker_code from registration_sellers where FIND_IN_SET('".$sub_cat_id."', sub_cat_id) and city='".$city."' and user_type='Moving'");
       die();*/

    }
    
     function near_by_hawker_notified_data()
    {  
      $q=$this->db->query("SELECT * from notified_near_by_hawker_for_customer where  status='1'");
      return($q->result_array());
    }

    function get_mobile_no_for_notified_data($mobile_no)
    {  
      $q=$this->db->query("SELECT * from tbl_customer_gps_location   where mobile_no='$mobile_no' and active_status='1' order by id desc limit 1");
      return($q->result_array());
    }
     function hawker_get_data()
    {  
      $q=$this->db->query("SELECT hawker_code,end_date  from registration_sellers where  active_status='1' and end_date!=''");
      return($q->result_array());
    }
     
      function customer_sub_cat_data($array)
     { 
         $q=$this->db->query("SELECT sub_cat_image,sub_cat_name,category from fixer_sub_category where id IN ($array) /*id='$sub_cat_id'*/ and status='1'");
           return($q->row());
     }

      function get_hawker_notification_id($hawker_code)
     { 
         $q=$this->db->query("SELECT notification_id FROM login_manage_seller where user_id='$hawker_code'");
        // print_r("SELECT notification_id FROM login_manage_seller where user_id='$hawker_code'");

         return($q->result_array());
     }

      function customer_cat_data($array)
     { 
         $q=$this->db->query("SELECT cat_icon_image,cat_name from fixer_category where id IN ($array) /*id='$cat_id'*/ and status='1'");
           return($q->row());
     }
     function notifiedhawker_by_duty_on()
    {  
      $q=$this->db->query("SELECT business_start_time,duty_status,hawker_code  from registration_sellers where user_type!='Fix'");
      return($q->result_array());
    }

     function notifiedhawker_by_duty_on_fix()
    {  
      $q=$this->db->query("SELECT business_start_time,duty_status,hawker_code,shop_latitude,shop_longitude  from registration_sellers where user_type='Fix'");
      return($q->result_array());
    }
 
    function notifiedhawker_by_duty_on_all()
    {  
      $q=$this->db->query("SELECT business_start_time,duty_status,hawker_code,shop_latitude,shop_longitude  from registration_sellers where (verification_status =1 or verification_by_call = 1) and user_type='Fix' and active_status='1'");
      return($q->result_array());
    }

    function tempoary_notifiedhawker_by_duty_on_all()
    {  
      $q=$this->db->query("SELECT business_start_time,duty_status,hawker_code,shop_latitude,shop_longitude  from registration_sellers where cat_id IN (10,27,16) and (verification_status =1 or verification_by_call = 1) and user_type='Fix' and active_status='1'");
      return($q->result_array());
    }

    function notifiedhawker_by_duty_on_Seasonals()
    {  
      $q=$this->db->query("SELECT user_type, seasonal_temp_hawker_type,duty_status,hawker_code,shop_latitude,shop_longitude,start_date  from registration_sellers where (verification_status =1 or verification_by_call = 1) and user_type='Seasonal' and seasonal_temp_hawker_type='Fix' and active_status='1'");
      return($q->result_array());
    }

     function tempory_notifiedhawker_by_duty_on_Seasonals()
    {  
      $q=$this->db->query("SELECT business_start_time,duty_status,hawker_code,shop_latitude,shop_longitude  from registration_sellers where sub_cat_id IN (7,8,9,11,12,13,14,15) and (verification_status =1 or verification_by_call = 1) and user_type='Fix' and active_status='1'");
      return($q->result_array());
    }

    function fetch_hawker_data_for_customer($hawker_code)
     {
       // $hawker_code = $data->hawker_code;
        $q=$this->db->query("SELECT cat_id,sub_cat_id,super_sub_cat_id from registration_sellers where hawker_code='".$hawker_code."'");
          return($q->row());
        $row = $q->num_rows();
     }

      public function update_catstatus_data($where)
     {
         $cat_id = $where;
    
            $this->db->where_in('id', $where);
            $this->db->update('fixer_category', ['status'=>"1"]);
     }

     public function update_catstatus_data_for_deactivate($where)
     {
         $cat_id = $where;
    
            $this->db->where_in('id', $where);
            $this->db->update('fixer_category', ['status'=>"2"]);
     }

     public function update_sub_cat_status_data($where)
     {
         $cat_id = $where;
      
        
            $this->db->where_in('id', $where);
            $this->db->update('fixer_sub_category', ['status'=>"1"]);
            /* $this->db->query("UPDATE fixer_category SET status='2' where id='$where'");*/
       /* print_r("UPDATE fixer_category SET status='2' where id='$cat_id'");
        die();*/
           /*return;*/
     }

      public function update_sub_cat_status_data_for_deactivate($where)
     {  
            $this->db->where_in('id', $where);
            $this->db->update('fixer_sub_category', ['status'=>"3"]);
        
     }

     public function hawker_deactivate($hawker_code)
     {  
            $this->db->where_in('hawker_code', $hawker_code);
            $this->db->update('registration_sellers', ['active_status'=>"0"]);
        
     }


    function turn_on_duty_by_hawker($data)
    {
       $insert = $this->db->insert($this->duty_on_by_hawker, $data);
       return $insert?$this->db->insert_id():false;
    }
    function move_data_in_history_table($data)
    {
       $insert = $this->db->insert($this->history_notified_near_by_hawker_for_customer, $data);
       return $insert?$this->db->insert_id():false;
    }

    function turn_off_duty_by_hawker($data)
    {
       $insert = $this->db->insert($this->duty_on_by_hawker, $data);
       return $insert?$this->db->insert_id():false;
    }
    function notifiedhawker_by_duty_off()
    {  
      $q=$this->db->query("SELECT business_close_time,duty_status,hawker_code  from registration_sellers  where user_type='Fix'");
      return($q->result_array());
    }

    function notifiedhawker_by_duty_off_fix()
    {  
      $q=$this->db->query("SELECT business_close_time,duty_status,hawker_code,shop_latitude,shop_longitude  from registration_sellers where user_type='Fix'");
      return($q->result_array());
    }

    function notifiedhawker_by_duty_off_all()
    {  
      $q=$this->db->query("SELECT business_close_time,duty_status,hawker_code,shop_latitude,shop_longitude  from registration_sellers where (verification_status =1 or verification_by_call = 1) and (user_type='Fix')");
      return($q->result_array());
    }

    function notifiedhawker_by_duty_off_Seasonals()
    {  
      $q=$this->db->query("SELECT end_date,business_close_time,duty_status,hawker_code,shop_latitude,shop_longitude  from registration_sellers where (verification_status =1 or verification_by_call = 1) and user_type='Seasonal' and seasonal_temp_hawker_type='Fix'");
      return($q->result_array());
    }

    function data_for_seasnal_category()
    {  
      $q=$this->db->query("SELECT duty_status,hawker_code,shop_latitude,shop_longitude,start_date,end_date,user_type,cat_id,sub_cat_id from registration_sellers where(verification_status =1 or verification_by_call = 1) and user_type='Seasonal' ");
      return($q->result_array());
    }
     function update_duty_status_hawker($hawker_code,$duty_status)
    {   
      $this->db->query("UPDATE registration_sellers SET duty_status='$duty_status' where hawker_code='$hawker_code'");
    }
    function update_duty_status_hawker_off($hawker_code,$duty_status)
    {   
    
      $this->db->query("UPDATE registration_sellers SET duty_status='$duty_status' where hawker_code='$hawker_code'");
    }
   }
?>