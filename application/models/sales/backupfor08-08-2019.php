<?php

class Sales extends CI_Model
{    
    private $table = 'registration_sales';
    private $tabledata='login_manage_sales';
    private $registration_seller='registration_sellers';
    private $register_customer='registration_customer';
    private $add_fixer_data='add_fixer_data';
    private $tablecustumerlogin='login_manage_custumer';
    private $tablesellerlogin='login_manage_seller';
    private $gps_seller_location='gps_seller_location';
    private $gps_sales_location ='gps_sales_location';
    private $duty_on_off_by_seller='duty_on_off_by_seller';
    private $duty_on_off_by_sales='duty_on_off_by_sales';
    
    function add($data)
    {
        $insert = $this->db->insert($this->registration_seller, $data);
        return $insert?$this->db->insert_id():false;
      
    }

     function sales_location_add_data_by_gps($data)
    {
        $insert = $this->db->insert($this->gps_sales_location, $data);
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

   


    
     function duty_data_by_sales($data)
    {
        $insert = $this->db->insert($this->duty_on_off_by_sales, $data);
        return $insert?$this->db->insert_id():false;
      
    }



     function check_duty_data_by_sales($sales_id)
     {  
        $q=$this->db->query("SELECT * from duty_on_off_by_sales where sales_id='$sales_id' order by id desc limit 1");
         return($q->row());
     }

     function check_logout_data_sales($sales_id)
     {  

        $q=$this->db->query("SELECT * from login_manage_sales where user_id='$sales_id'");
         return($q->row());
     }

      function check_data_sales_profile($data)
     {  
        $sales_id = $data->sales_id;
        $q=$this->db->where(['sales_id'=>$sales_id,'active_status'=>'1'])
          ->get('registration_sales');
          return($q->row());
     }
      function category_data_profile()
     {  
       
        $q=$this->db->get_where('fixer_category',['fixer_category.status'=>'1']);
                        
          return($q->result_array());
     }
    
     public function getSubCategory($where)
     {
         $query = $this->db->get_where('fixer_sub_category',$where)->result_array();  
         return $query;   
     }
      public function getSuperSubCategory($sub_cat_id)
     {
         $q = $this->db->get_where('fixer_super_sub_category',['fixer_super_sub_category.sub_cat_id'=>$sub_cat_id]);
        return($q->result_array());
     }
     public function gethawkertypename()
     {
         $q = $this->db->get_where('hawkers_type',['hawkers_type.status'=>'1']);
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

    function update_shop_id($alphanumerric,$result)
    {   
      $this->db->query("UPDATE registration_sellers SET shop_id='$alphanumerric' where id='$result'");
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
    
   }
?>