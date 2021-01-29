<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

 class Api extends REST_Controller {

  function __construct($config = 'rest')
  {  
    header('Access-Control-Allow-Origin:*');
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

  /*......... Login Api For Customer Hawker ---- */
   public function login_post()
    {
    $response = new StdClass();
    $result = new StdClass();
    $mobile_no = $this->input->post('mobile_no');
    $device_id=$this->input->post('device_id');
    $notification_id=$this->input->post('notification_id');
    date_default_timezone_set('Asia/kolkata'); 
    $now = date('Y-m-d H:i:s');
    $getdata1  =  $this->db
                  ->select('*')
                  ->from("registration_customer")
                  ->where(['mobile_no'=>$mobile_no,'active_status'=>'1'])
                  ->get()->result_array();
      if(!empty($mobile_no))
      {
        
      if(!empty($getdata1))
      {
      foreach ($getdata1 as $rowdata)
      {
      $otpValue=mt_rand(1000, 9999);
      $data1->device_id = $device_id;
      $data1->notification_id = $notification_id;
      $data1->login_time=$now;
      $data1->cus_id=$rowdata['cus_id'];
      $data1->name=$rowdata['name'];
      $data1->mobile_no=$rowdata['mobile_no'];
      $data1->email_id=$rowdata['email_id'];
      $data1->address=$rowdata['address'];
      $data1->otp=$otpValue;
      $res = $this->Customer->Add_registration_custumer_data($data1);
      $res3 = $this->Customer->send_otp($mobile_no,$otpValue);
      if($res3!='')
      {
      $res4 = $this->Customer->otpgetdata($data1);
      }
      $data['id'] =  $rowdata['cus_id'];
      $data['active_status'] =  $rowdata['active_status'];
      $data['status']  ='1';
      array_push($result,$data);
      }
        $response->data = $result;
      }
      else
      { 
         $otpValue=mt_rand(1000, 9999);
         $data2->mobile_no=$mobile_no;
         $data2->active_status='1';
         $data2->registered_time=$now;
         $result1 = $this->Customer->customer_add($data2);
         $alphanumerric='CUS_0000'.$result1;
         if(!empty($result1))
        {
        
         $data3->device_id = $device_id;
         $data3->notification_id = $notification_id;
         $data3->mobile_no=$mobile_no;
         $data3->cus_id=$alphanumerric;
         $data3->login_time=$now;
         $data3->otp=$otpValue;
         $res3 = $this->Customer->send_otp($mobile_no,$otpValue);
         if($res3!='')
          {
          $res4 = $this->Customer->otpgetdata($data3);
          }
         $updatedata = $this->Customer->update_customer_id($alphanumerric,$result1);
         $res = $this->Customer->Add_registration_custumer_data($data3);
         $alphanumerric='CUS_0000'.$result1;

         $data['id']  =$result1;
         $data['cus_id']  =$alphanumerric;
         $data['status']  ='1';
         $data['message']  ='register Successfully';
         array_push($result , $data);
         $response->data = $data;
         }
         else
         {
           $data['status']  ='0';
           $data['message']  ='registration failed';
           array_push($result,$data);
           $response->data = $data;
         }
        }
       }
        else
         {
            $data['status']  ='0';
       array_push($result , $data);
         }
            $response->data = $data;
            echo json_output($response);
      }
    
      /*.........Login Api For Customer Hawker ---- */

   /*.........Register_customer  Api For Fixer  ---- */
  public function customer_profile_update_post()
  {
    $response = new StdClass();
    $result = new StdClass();
    $cus_id = $this->input->post('cus_id');
    $name = $this->input->post('name');
    $state=$this->input->post('state');
    $city=$this->input->post('city');
    $address=$this->input->post('address');
    $gender=$this->input->post('gender');
    $date_of_birth=$this->input->post('date_of_birth');
    $area=$this->input->post('area');
    $pincode=$this->input->post('pincode');
    $mobile_no = $this->input->post('mobile_no');
    $email=$this->input->post('email_id');
    $latitude=$this->input->post('latitude');
    $longitude=$this->input->post('longitude');
    $cus_image=$this->input->post('cus_image');
    $img       = str_replace('data:image/jpeg;base64,','',$cus_image);
    $img       = str_replace('','+',$img);
    $dataimage      = base64_decode($img);
    $imageName = "".$mobile_no.".jpeg";
    $dir       = "assets/customerImage/".$imageName;
    file_put_contents($dir,$dataimage);
    
    $data->cus_id = $cus_id;
    $data->name = $name;
    $data->state = $state;
    $data->city = $city;
    $data->address = $address;
    $data->gender = $gender;
    $data->date_of_birth = $date_of_birth;
    $data->area = $area;
    $data->pincode = $pincode;
    $data->mobile_no= $mobile_no;
    $data->email_id=$email;
    $data->latitude =$latitude;
    $data->longitude =$longitude;
    $data->cus_image =$cus_image;
    $result1 = $this->Customer->update_customer_profile($data);
    if(!empty($mobile_no))
    {
      $data1->status ='1';
      $data1->message = 'Profile successfully update';
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
      $result1       =   array();
      $result2       =   array();
      $result3       =   new StdClass();
      $result4       = array();
      $result5       = array();
      $cus_id=$this->input->post('cus_id');
      $city=$this->input->post('city');
      $sPin=$this->input->post('sPin');
      $pindata->city=$city;
      $pindata->Pincode=$sPin;

    /*  $datacat = $this->Customer->favourite_category_data_profile($cus_id);*/
      $readdydata = $this->Customer->priority_category_data_profile();
      $fixdata = $this->Customer->priority_category_data_profile1();
      $tempcatdata = $this->Customer->festive_base_category_data_profile();
      $seasnalcatdata = $this->Customer->seasanal_festive_base_category_data_profile();
      $checkcitystatus = $this->Customer->get_city_data($pindata);
      $checkdatastatus = $this->Customer->check_data_status();
       if(empty($checkdatastatus))
       {
         $data1->show_data_status ='0';
         $data1->show_data_message ='Sorry We have not found any hawker for category.';
      
       }

        else
      {
         $data1->show_data_status ='1';
      }
      if(!empty($checkcitystatus))
      {
        $data1->city_status ='1';

        array_push($result3,$data1);
      }
    

       //$response->checkcity = $result3;
      else
      {
        $data1->city_status ='0';
        $data1->message='You are not in our service-able area. Currently, we are serving in Gurgaon only. We will inform you as soon as we launch here.';
       array_push($result3,$data1);
      }
    
          $response->data = $data1;
   /*   if(!empty($datacat))
      {
       foreach ($datacat as $row)
      {
      $cat_id=$row['cat_id'];
      $sub_cat_id=$row['sub_cat_id'];
      $super_sub_cat_id=$row['super_sub_cat_id'];
      if($sub_cat_id=='')
      {
      $datacat1 = $this->Customer->getcategory($cat_id);

      if(!empty($datacat1))
      {
      foreach ($datacat1 as $row1)
      {
       $data['id']    = $row1['id'];  
       $data['cat_name']    = $row1['cat_name'];
       $data['image_url']=base_url().'manage/catImages/'.$row1['cat_icon_image'];
       $data['status']  ='1';
      array_push($result,$data);
      }

       } 
      }
       if($cat_id=='')
       {
          $datacat3 = $this->Customer->get_sub_category($sub_cat_id);
          if(!empty($datacat1))
      {
      foreach ($datacat3 as $row2)
      {
       $data['id']    = $row2['id'];  
       $data['cat_name']    = $row2['sub_cat_name'];
       $data['image_url']=base_url().'manage/catImages/'.$row2['sub_cat_image'];
       $data['status']  ='1';
      array_push($result,$data);
      }
       } 
       }
      if($sub_cat_id=='' and $cat_id=='')
      {
      $datacat4 = $this->Customer->get_super_sub_category($super_sub_cat_id);

      if(!empty($datacat4))
      {
      foreach ($datacat4 as $row4)
      {
       $data['id']    = $row4['id'];  
       $data['cat_name']    = $row4['super_sub_cat_name'];
       $data['image_url']=base_url().'manage/catImages/'.$row4['super_sub_cat_image'];
       $data['status']  ='1';
      array_push($result,$data);
      }

       } 
      }
      $response->favourite = $result;
      }
     }
      else
      {
       $data['status']  ='0';
       array_push($result , $data);
        $response->favourite = $result;
      }*/

      if(!empty($readdydata))
      {
      foreach ($readdydata as $row4)
      {
      $data2['title1']='Rehdi/Feri wala/Transportation';
      $data2['id']    = $row4['id'];
      $subCat1 = $this->Customer->fetch_category(['cat_id'=>$row4['id'],'cus_id'=>$cus_id,'status'=>'1']);

       if(!empty($subCat1))
      {
        $data2['fav_status']='1';

      }
      else
     {
     $data2['fav_status']='0';
     } 
      $data2['cat_name']    = $row4['cat_name'];
      $data2['image_url']=base_url().'manage/catImages/'.$row4['cat_icon_image']; 
      $subCat = $this->Sales->getSubCategory(['category'=>$row4['id']]);
      if(!empty($subCat))
      {
        $data2['sub_cat_status']='1';

      }
      else
     {
     $data2['sub_cat_status']='0';
     } 
      $data2['title1']='Rehdi/Feri wala/Transportation';
      $data2['check_level_customer']  =$row4['check_level_customer'];
      $data2['status']  ='1';
      array_push($result1,$data2);
        $response->Reddi = $result1;
      }
      } 
      else
      {
       $data['status']  ='0';
       array_push($result1 , $data);
       $response->Reddi = $result1;
      }
       
      if(!empty($fixdata))

      {
      foreach ($fixdata as $row5)
      {
      $data4['title2']='Neighbourhood Shops';
      $data4['id']    = $row5['id'];
      $subCat1 = $this->Customer->fetch_category(['cat_id'=>$row5['id'],'cus_id'=>$cus_id,'status'=>'1']);

       if(!empty($subCat1))
      {
        $data4['fav_status']='1';

      }
      else
     {
     $data4['fav_status']='0';
     } 
      $data4['title2']='Neighbourhood Shops';
      $data4['cat_name']    = $row5['cat_name'];
      $data4['image_url']=base_url().'manage/catImages/'.$row5['cat_icon_image']; 
      $subCat = $this->Sales->getSubCategory(['category'=>$row5['id']]);
      if(!empty($subCat))
      {
        $data4['sub_cat_status']='1';

      }
      else
     {
     $data4['sub_cat_status']='0';
     } 
      $data4['check_level_customer']  =$row5['check_level_customer'];
      $data4['status']  ='1';
      array_push($result4,$data4);
        $response->NeighboursShops = $result4;
      }
      } 
      else
      {
       $data4['status']  ='0';
       array_push($result4 , $data4);
       $response->NeighboursShops = $result4;
      }

      if(!empty($tempcatdata))
      {
      foreach ($tempcatdata as $row3)
      {
      $data['title3']='Temporary/Seasonal';
      $data['id']    = $row3['id'];
      $subCat1 = $this->Customer->fetch_category(['cat_id'=>$row['id'],'cus_id'=>$cus_id,'status'=>'1']);

       if(!empty($subCat1))
      {
        $data['fav_status']='1';

      }
      else
     {
     $data['fav_status']='0';
     } 
      $data['title3']='Temporary/Seasonal';
       $data['check_level_customer']  =$row3['check_level_customer'];
      $data['cat_name']    = $row3['cat_name'];
      $data['image_url']=base_url().'manage/catImages/'.$row3['cat_icon_image']; 
      $subCat = $this->Sales->getSubCategory(['category'=>$row3['id']]);
      if(!empty($subCat))
      {
        $data['sub_cat_status']='1';

      }
      else
     {
     $data['sub_cat_status']='0';
     } 
      $data['status']  ='1';
      array_push($result2,$data);
        $response->temp_festive = $result2;
      }

      } 
       if(!empty($seasnalcatdata))
      {
         foreach ($seasnalcatdata as $row_seasonal)
      {
      $data['title3']='Temporary/Seasonal';
      $data['id']    = $row_seasonal['id'];
      $subCat1 = $this->Customer->fetch_category(['cat_id'=>$row_seasonal['id'],'cus_id'=>$cus_id,'status'=>'1']);

       if(!empty($subCat1))
      {
        $data['fav_status']='1';

      }
      else
     {
     $data['fav_status']='0';
     } 
      $data['title3']='Temporary/Seasonal';
       $data['check_level_customer']  =$row_seasonal['check_level_customer'];
      $data['cat_name']    = $row_seasonal['cat_name'];
      $data['image_url']=base_url().'manage/catImages/'.$row_seasonal['cat_icon_image']; 
      $subCat = $this->Sales->getSubCategory(['category'=>$row_seasonal['id']]);
      if(!empty($subCat))
      {
        $data['sub_cat_status']='1';

      }
      else
     {
     $data['sub_cat_status']='0';
     } 
      $data['status']  ='1';
      array_push($result2,$data);
        $response->temp_festive = $result2;
      }
      }
      else if(empty($tempcatdata) and empty($seasnalcatdata))
      {
       $data_temp['status']  ='0';
       array_push($result2 , $data_temp);
       $response->temp_festive = $result2;
      }
      echo json_output($response);
     }
      /*.........Category   Api For Fixer  ---- */


     /*......... sub Category   Api For Hawker  ---- */
  public function sub_category_post()
  {
    $response   =   new StdClass();
    $result       =   array();
    $cat_id =$this->input->post('cat_id');
    $cus_id =$this->input->post('cus_id');
    $datacat = $this->Customer->getSubCategory($cat_id);
    if(!empty($datacat))
    {
    foreach ($datacat as $row)
    {
    $data['id'] =   $row['id'];
    $subCat1 = $this->Customer->fetch_sub_category(['sub_cat_id'=>$row['id'],'cus_id'=>$cus_id,'status'=>'1']);

       if(!empty($subCat1))
      {
        $data['fav_status']='1';

      }
      else
     {
     $data['fav_status']='0';
     } 
    $data['sub_cat_name'] =   $row['sub_cat_name'];
    $data['image_url']=base_url().'manage/catImages/'.$row['sub_cat_image'];
    $data['check_level_customer'] =   $row['check_level_customer'];
    $data['cat_id']      =$cat_id;
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

    /*.........sub Category   Api For hawker  ---- */

      /*......... super sub Category   Api For Hawker  ---- */
  public function super_sub_category_post()
  {
    $response   =   new StdClass();
    $result       =   array();
    $cat_id =$this->input->post('cat_id');
    $cus_id =$this->input->post('cus_id');
    $sub_cat_id =$this->input->post('sub_cat_id');
    $datacat = $this->Customer->getSuperSubCategory($cat_id,$sub_cat_id);
    if(!empty($datacat))
    {
    foreach ($datacat as $row)
    {
    $data['id'] =   $row['id'];
    $subCat1 = $this->Customer->fetch_sub_category(['super_sub_cat_id'=>$row['id'],'cus_id'=>$cus_id,'status'=>'1']);

       if(!empty($subCat1))
      {
        $data['fav_status']='1';

      }
      else
     {
     $data['fav_status']='0';
     } 
    $data['cat_id'] =   $cat_id;
    $data['sub_cat_id'] =   $sub_cat_id;
    $data['super_sub_cat_name'] =   $row['super_sub_cat_name'];
    $data['image_url']=base_url().'manage/catImages/'.$row['super_sub_cat_image'];
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
  public function get_customer_profile_data_post()
    {
    $response   =   new StdClass();
    $result       =    new StdClass();
    $cus_id =$this->input->post('cus_id');
    $mobile_no =$this->input->post('mobile_no');
    $getdata = $this->Customer->customer_profile($cus_id,$mobile_no);
    if(!empty($getdata))
    {
    $cus_image=$getdata->cus_image;
    $name=$getdata->name;
    if($name=='')
    {
      $data->name='';
    }
    else
    {
       $data->name=$getdata->name;
    }
    $email_id=$getdata->email_id;
    if($email_id=='')
    {
       $data->email_id='';
    }
    else
    {
       $data->email_id=$getdata->email_id;
    }
    $date_of_birth=$getdata->date_of_birth;
    if($date_of_birth=='')
    {
       $data->date_of_birth='';
    }
    else
    {
      $data->date_of_birth=$getdata->date_of_birth;
    }
    $data->city=$getdata->city;
    $data->state=$getdata->state;
    $data->address=$getdata->address;
    $data->area=$getdata->area;
    $data->gender=$getdata->gender;
    $data->pincode=$getdata->pincode;
    $data->mobile_no=$getdata->mobile_no;
    $image_url=base_url().'assets/customerImage/'.$mobile_no.".jpeg";
    if($cus_image=='')
    {
       $data->image_url='NA';
    }
    else
    {
       $data->image_url=$image_url;
    }
    $data->status='1';
    array_push($result,$data);
    $response->data = $data;
    }       
    else
    {
       $data->status='0';
      //$data['message'] = 'failed';
      array_push($result , $data);
    }
      $response->data = $data;
      echo json_output($response);
    }

/*........get fixer registartion data by catID  Api For Fixer  ---- */

/*.........get_seller_list_data_by_location  Api For hawker  ---- */
  public function get_customer_list_data_by_location_post()
  {
    $response   =   new StdClass();
    //$response1  =   new StdClass();
    $result       =   array();
    $result1       =   array();
    $result2       =   array();
    $result3       =   array();
    $datatemp=false;
    $datatemp1=false;
    $Notavailhawker=array();
    $latitudeFrom =$this->input->post('latitude');
    $longitudeFrom =$this->input->post('longitude');
    $notification_id =$this->input->post('notification_id');
    $cus_id =$this->input->post('cus_id');
    $cat_id =$this->input->post('cat_id');
    $sub_cat_id =$this->input->post('sub_cat_id_1');
    $super_sub_cat_id =$this->input->post('sub_cat_id_2');
    $radius =$this->input->post('radius');
    $city =$this->input->post('city');

    date_default_timezone_set('Asia/kolkata'); 
    $now = date('Y-m-d H:i:s');
    $logdata->latitude = $latitudeFrom;
    $logdata->longitude = $longitudeFrom;
    $logdata->notification_id = $notification_id;
    $logdata->cus_id = $cus_id;
    $logdata->cat_id = $cat_id;
    $logdata->sub_cat_id = $sub_cat_id;
    $logdata->super_sub_cat_id = $super_sub_cat_id;
    $logdata->radius = $radius;
    $logdata->city = $city;
    $logdata->date_time=$now;
    $logdata->status='1';
    if($sub_cat_id=='' or $sub_cat_id=='0')
    {
    $getdata = $this->Customer->check_data_by_registerseller($cat_id,$city);

   // $logdatalocation = $this->Customer->logdatalocation($logdata);
    $getcatdata = $this->Customer->customer_cat_data($cat_id);
    $cat_image=$getcatdata->cat_icon_image;
    $cat_data=$getcatdata->cat_name;
    $image_url=base_url().'manage/catImages/'.$cat_image; 
    }
   else
   {
     $getdata = $this->Customer->check_data_by_registerseller1($sub_cat_id,$city);
    
     $getsubdata = $this->Customer->customer_sub_cat_data($sub_cat_id);
      //$logdatalocation = $this->Customer->logdatalocation($logdata);
     $sub_cat_image=$getsubdata->sub_cat_image;
     $cat_data=$getsubdata->sub_cat_name;
     $categoty_data=$getsubdata->category;
    
     $image_url=base_url().'manage/catImages/'.$sub_cat_image; 
   }
   if($sub_cat_id=='' or $sub_cat_id=='0')
   {
    $getdata1 = $this->Customer->check_data_by_registerseller2($cat_id,$city);
    $getcatdata = $this->Customer->customer_cat_data($cat_id);
     //$logdatalocation = $this->Customer->logdatalocation($logdata);
    $cat_image=$getcatdata->cat_icon_image;
    $cat_data=$getcatdata->cat_name;
    $image_url=base_url().'manage/catImages/'.$cat_image; 
   }
   else
   {
     $getdata1 = $this->Customer->check_data_by_registerseller3($sub_cat_id,$city);

     $getsubdata = $this->Customer->customer_sub_cat_data($sub_cat_id);
    // $logdatalocation = $this->Customer->logdatalocation($logdata);
     $sub_cat_image=$getsubdata->sub_cat_image;
     $cat_data=$getsubdata->sub_cat_name;
     $image_url=base_url().'manage/catImages/'.$sub_cat_image; 
   }
   if($sub_cat_id=='' or $sub_cat_id=='0')
    {
    $getdata_temp = $this->Customer->check_data_by_registerseller_temp_fix($cat_id,$city);
    $logdatalocation = $this->Customer->logdatalocation($logdata);
    $getcatdata = $this->Customer->customer_cat_data($cat_id);
    $cat_image=$getcatdata->cat_icon_image;
    $cat_data=$getcatdata->cat_name;
    $image_url=base_url().'manage/catImages/'.$cat_image; 
    }
   else
   {
     $getdata_temp = $this->Customer->check_data_by_registerseller1_temp_fix($sub_cat_id,$city);
     $getsubdata = $this->Customer->customer_sub_cat_data($sub_cat_id);
      $logdatalocation = $this->Customer->logdatalocation($logdata);
     $sub_cat_image=$getsubdata->sub_cat_image;
     $cat_data=$getsubdata->sub_cat_name;
     $image_url=base_url().'manage/catImages/'.$sub_cat_image; 
   }
   if($sub_cat_id=='' or $sub_cat_id=='0')
    {
    $getdata_seasonal = $this->Customer->check_data_by_registerseller_seasonal_fix($cat_id,$city);
    $logdatalocation = $this->Customer->logdatalocation($logdata);
    $getcatdata = $this->Customer->customer_cat_data($cat_id);
    $cat_image=$getcatdata->cat_icon_image;
    $cat_data=$getcatdata->cat_name;
    $image_url=base_url().'manage/catImages/'.$cat_image; 
    }
   else
   {
     $getdata_seasonal = $this->Customer->check_data_by_registerseller1_seasonal_fix($sub_cat_id,$city);
     $getsubdata = $this->Customer->customer_sub_cat_data($sub_cat_id);
      $logdatalocation = $this->Customer->logdatalocation($logdata);
     $sub_cat_image=$getsubdata->sub_cat_image;
     $cat_data=$getsubdata->sub_cat_name;
     $image_url=base_url().'manage/catImages/'.$sub_cat_image; 
   }
   if($sub_cat_id=='' or $sub_cat_id=='0')
    {
    $getdata_temp_moving = $this->Customer->check_data_by_registerseller_temp_moving($cat_id,$city);
    $logdatalocation = $this->Customer->logdatalocation($logdata);
    $getcatdata = $this->Customer->customer_cat_data($cat_id);
    $cat_image=$getcatdata->cat_icon_image;
    $cat_data=$getcatdata->cat_name;
    $image_url=base_url().'manage/catImages/'.$cat_image; 
    }
   else
   {
     $getdata_temp_moving = $this->Customer->check_data_by_registerseller1_temp_moving($sub_cat_id,$city);
     $getsubdata = $this->Customer->customer_sub_cat_data($sub_cat_id);
      $logdatalocation = $this->Customer->logdatalocation($logdata);
     $sub_cat_image=$getsubdata->sub_cat_image;
     $cat_data=$getsubdata->sub_cat_name;
     $image_url=base_url().'manage/catImages/'.$sub_cat_image; 
   }

   if($sub_cat_id=='' or $sub_cat_id=='0')
    {
    $getdata_seasonal_moving = $this->Customer->check_data_by_registerseller_seasonal_moving($cat_id,$city);
    $logdatalocation = $this->Customer->logdatalocation($logdata);
    $getcatdata = $this->Customer->customer_cat_data($cat_id);
    $cat_image=$getcatdata->cat_icon_image;
    $cat_data=$getcatdata->cat_name;
    $image_url=base_url().'manage/catImages/'.$cat_image; 
    }
   else
   {
     $getdata_seasonal_moving = $this->Customer->check_data_by_registerseller1_seasonal_moving($sub_cat_id,$city);
     $getsubdata = $this->Customer->customer_sub_cat_data($sub_cat_id);
      $logdatalocation = $this->Customer->logdatalocation($logdata);
     $sub_cat_image=$getsubdata->sub_cat_image;
     $cat_data=$getsubdata->sub_cat_name;
     $image_url=base_url().'manage/catImages/'.$sub_cat_image; 
   }

   if(!empty($getdata))
    {
    foreach ($getdata as $row)
    {
      $userType=$row['user_type'];

      if($userType=='Fix')
    {
      $rad = M_PI / 180;
     //Calculate distance from latitude and longitude
     $theta = $longitudeFrom - $row['shop_longitude'];
     $dist = sin($latitudeFrom * $rad) 
             * sin($row['shop_latitude'] * $rad) +  cos($latitudeFrom * $rad)
             * cos($row['shop_latitude'] * $rad) * cos($theta * $rad);

     $distance= acos($dist) / $rad * 60 *  2.250;

      if($distance<=$radius)
     {
      $datatemp=true;
      $data['name']   = $row['name'];
      $data['mobile_no']   = $row['mobile_no_contact'];
      $data['business_mobile_no']   = $row['business_mobile_no'];
      $mobile_no=$row['mobile_no_contact'];
      $data['image_url']=base_url().'assets/upload/profile_image/'.$mobile_no.".jpeg";
      $data['image_cat_url']=$image_url;
      $menu_image=$row['menu_image'];
      $menu_image_2=$row['menu_image_2'];
      $menu_image_3=$row['menu_image_3'];
      $menu_image_4=$row['menu_image_4'];

      if(!empty($menu_image) or (!empty($menu_image_2)) or (!empty($menu_image3)) or (!empty($menu_image_4)))
      {
         $data['menu_status'] ='1';
      }
      
      else
      {
        $data['menu_status'] ='0';
      }
      $data['fix_url']=base_url().'manage/catImages/shop.png'; 
      $data['cat_data']=$cat_data;
      if($categoty_data=='4')
      {
         $data['Show_status'] ='1';
      }
      else
      {
         $data['Show_status'] ='0';
      }
      $data['latitude'] =$row['shop_latitude'];
      $data['hawker_code'] =$row['hawker_code'];
      $data['longitude'] =$row['shop_longitude'];
      $data['distance'] =$distance;
      $data['user_type'] =$row['user_type'];
      $data['cus_id'] =$cus_id;
      $data['status'] ='1';
      array_push($result2,$data);
    }
    else
    {
      $data4['status']  ='0';
      $data4['message']  ='failed';
      array_push($result , $data4);
    }
    }
    }
    if($datatemp){
//use result 2 array and proceed working
      $response->fix_status = '1';
      $response->set_timer = '20';
      $response->notified_maxtimer ='3';
       $response->fixdata = $result2;
    }else{
//use not avail hawker array
      $response->fix_status = '2';
      $response->message = 'Hawker not available in your area.';
      $response->set_timer = '20';
      $response->notified_maxtimer ='3';
       $response->fixdata = $result;
    }
    }
    else if(!empty($getdata_temp))
    {
       foreach ($getdata_temp as $row_temp)
    {
      //$userType=$row['user_type'];
      $rad = M_PI / 180;
     //Calculate distance from latitude and longitude
     $theta = $longitudeFrom - $row_temp['shop_longitude'];
     $dist = sin($latitudeFrom * $rad) 
             * sin($row_temp['shop_latitude'] * $rad) +  cos($latitudeFrom * $rad)
             * cos($row_temp['shop_latitude'] * $rad) * cos($theta * $rad);

     $distance= acos($dist) / $rad * 60 *  2.250;

    
      if($distance<=$radius)
     {
      $datatemp=true;
      $data['name']   = $row_temp['name'];
      $data['mobile_no']   = $row_temp['mobile_no_contact'];
      $data['business_mobile_no']   = $row_temp['business_mobile_no'];
      $mobile_no=$row_temp['mobile_no_contact'];
      $data['image_url']=base_url().'assets/upload/profile_image/'.$mobile_no.".jpeg";
      $data['image_cat_url']=$image_url;
      $menu_image=$row_temp['menu_image'];
      $menu_image_2=$row_temp['menu_image_2'];
      $menu_image_3=$row_temp['menu_image_3'];
      $menu_image_4=$row_temp['menu_image_4'];

      if(!empty($menu_image) or (!empty($menu_image_2)) or (!empty($menu_image3)) or (!empty($menu_image_4)))
      {
         $data['menu_status'] ='1';
      }
      else
      {
        $data['menu_status'] ='0';
      }
      $data['Show_status'] ='0';
      $data['fix_url']=base_url().'manage/catImages/shop.png'; 
      $data['cat_data']=$cat_data;
      $data['latitude'] =$row_temp['shop_latitude'];
      $data['hawker_code'] =$row_temp['hawker_code'];
      $data['longitude'] =$row_temp['shop_longitude'];
      $data['distance'] =$distance;
      $data['user_type'] =$row_temp['seasonal_temp_hawker_type'];
      $data['cus_id'] =$cus_id;
      $data['status'] ='1';
      array_push($result2,$data);
      
    }
    else
    {
      $data['Show_status'] ='0';
      $data4['status']  ='0';
      $data4['message']  ='failed';
      array_push($result , $data4);
      
    }
    }
    if($datatemp){
//use result 2 array and proceed working
     $response->fix_status = '1';
      $response->set_timer = '20';
      $response->notified_maxtimer ='3';
      $response->fixdata = $result2;
    }else{
//use not avail hawker array
      $response->fix_status = '2';
      $response->message = 'Hawker not available in your area.';
      $response->set_timer = '20';
      $response->notified_maxtimer ='3';
      $response->fixdata = $result;
    }
    }
   else if(!empty($getdata_seasonal))
    {
       foreach ($getdata_seasonal as $row_seasonal)
    {
      //$userType=$row['user_type'];
      $rad = M_PI / 180;
     //Calculate distance from latitude and longitude
     $theta = $longitudeFrom - $row_seasonal['shop_longitude'];
     $dist = sin($latitudeFrom * $rad) 
             * sin($row_seasonal['shop_latitude'] * $rad) +  cos($latitudeFrom * $rad)
             * cos($row_seasonal['shop_latitude'] * $rad) * cos($theta * $rad);

     $distance= acos($dist) / $rad * 60 *  2.250;

    
      if($distance<=$radius)
     {
      $datatemp=true;
      $data['name']   = $row_seasonal['name'];
      $data['mobile_no']   = $row_seasonal['mobile_no_contact'];
      $data['business_mobile_no']   = $row_seasonal['business_mobile_no'];
      $mobile_no=$row_seasonal['mobile_no_contact'];
      $data['image_url']=base_url().'assets/upload/profile_image/'.$mobile_no.".jpeg";
      $data['image_cat_url']=$image_url;
      $menu_image=$row_seasonal['menu_image'];
      $menu_image_2=$row_seasonal['menu_image_2'];
      $menu_image_3=$row_seasonal['menu_image_3'];
      $menu_image_4=$row_seasonal['menu_image_4'];

      if(!empty($menu_image) or (!empty($menu_image_2)) or (!empty($menu_image3)) or (!empty($menu_image_4)))
      {
         $data['menu_status'] ='1';
      }
      else
      { 
        $data['menu_status'] ='0';
      }
      $data['Show_status'] ='0';
      $data['fix_url']=base_url().'manage/catImages/shop.png'; 
      $data['cat_data']=$cat_data;
      $data['latitude'] =$row_seasonal['shop_latitude'];
      $data['hawker_code'] =$row_seasonal['hawker_code'];
      $data['longitude'] =$row_seasonal['shop_longitude'];
      $data['distance'] =$distance;
      $data['user_type'] =$row_seasonal['seasonal_temp_hawker_type'];
      $data['cus_id'] =$cus_id;
      $data['status'] ='1';
      array_push($result2,$data);
     
    }
    else
    {
      $data4['Show_status'] ='0';
      $data4['status']  ='0';
      $data4['message']  ='failed';
      array_push($result , $data4);
      
    }
    }
    if($datatemp){
//use result 2 array and proceed working
      $response->fix_status = '1';
      $response->set_timer = '20';
      $response->notified_maxtimer ='3';
      $response->fixdata = $result2;
    }else{
//use not avail hawker array
      $response->fix_status = '2';
      $response->message = 'Hawker not available in your area.';
      $response->set_timer = '20';
      $response->notified_maxtimer ='3';
      $response->fixdata = $result;
    }
    }
    else
    {
      $data['Show_status'] ='0';
      $data['status']  ='0';
      $data['message'] = 'failed';
       array_push($result , $data);
      $response->fix_status = '2';
      $response->set_timer = '20';
      $response->notified_maxtimer ='3';
      $response->fixdata = $result;
    } 

    if(!empty($getdata1))
    {

     foreach ($getdata1 as $row1)
    {
    $hawker_code=$row1['hawker_code'];
    $getdevicedata = $this->Customer->get_device_data($hawker_code);
    foreach ($getdevicedata as $getdevice)
    {
      $gps_id=$getdevice['device_id'];
      $getdata2 = $this->Customer->check_data_by_location($gps_id);
      /* print_r($getdata2);
       die();*/
    foreach ($getdata2 as $row2)
    {
      $rad = M_PI / 180;
     //Calculate distance from latitude and longitude
     $theta = $longitudeFrom - $row2['longitude'];
     $dist = sin($latitudeFrom * $rad) 
             * sin($row2['latitude'] * $rad) +  cos($latitudeFrom * $rad)
             * cos($row2['latitude'] * $rad) * cos($theta * $rad);

     $distance= acos($dist) / $rad * 60 *  2.250;
      if($distance<=$radius)
    {
      $datatemp1=true;
      $data1['name']   = $row1['name'];
      $data1['mobile_no']   = $row1['mobile_no_contact'];
      $mobile_no=$row1['mobile_no_contact'];
      $data1['business_mobile_no']   = $row1['business_mobile_no'];
      $data1['image_url']=base_url().'assets/upload/profile_image/'.$mobile_no.".jpeg";
      $data1['image_cat_url']=$image_url;
      $menu_image=$row1['menu_image'];
      $menu_image_2=$row1['menu_image_2'];
      $menu_image_3=$row1['menu_image_3'];
      $menu_image_4=$row1['menu_image_4'];

    if(!empty($menu_image) or (!empty($menu_image_2)) or (!empty($menu_image3)) or (!empty($menu_image_4)))
      {
         $data1['menu_status'] ='1';
      }
      else
      { 
        $data1['menu_status'] ='0';
      }
      $data1['Moving_url']=base_url().'manage/catImages/moving_hawker12.png'; 
      $data1['cat_data']=$cat_data;
      $data1['latitude'] =$row2['latitude'];
      $data1['longitude'] =$row2['longitude'];
      $data1['hawker_code'] =$row1['hawker_code'];
      $data1['distance'] =$distance;
      $data1['user_type'] =$row1['user_type'];
      $data1['cus_id'] =$cus_id;
      $data1['Show_status'] ='1';
      $data1['status'] ='1';
      array_push($result3,$data1);
      
     }
      else
     {
       $data5['Show_status'] ='0';
       $data5['status']  ='0';
       $data5['message']  ='failed';
       array_push($result1 , $data5);
       
     }
    }
    }
    }
    if($datatemp1){
//use result 2 array and proceed working
      $response->Moving_status = '1';
      $response->set_timer = '20';
      $response->notified_maxtimer ='3';
      $response->Movingdata = $result3;
    }else{
//use not avail hawker array
      $response->Moving_status = '2';
       $response->message = 'Hawker not available in your area.';
       $response->set_timer = '20';
       $response->notified_maxtimer ='3';
       $response->Movingdata = $result1;
       
    
    }
    }
    else if(!empty($getdata_temp_moving))
    {
     foreach ($getdata_temp_moving as $row_temp_moving)
    {
    /*$gps_id=$row1['shop_gps_id'];*/
    $hawker_code=$row_temp_moving['hawker_code'];
    $getdevicedata = $this->Customer->get_device_data($hawker_code);
    foreach ($getdevicedata as $getdevice)
    {
      $gps_id=$getdevice['device_id'];
    $getdata2 = $this->Customer->check_data_by_location($gps_id);
    foreach ($getdata2 as $row2)
    {
      $rad = M_PI / 180;
     //Calculate distance from latitude and longitude
     $theta = $longitudeFrom - $row2['longitude'];
     $dist = sin($latitudeFrom * $rad) 
             * sin($row2['latitude'] * $rad) +  cos($latitudeFrom * $rad)
             * cos($row2['latitude'] * $rad) * cos($theta * $rad);

     $distance= acos($dist) / $rad * 60 *  2.250;
      if($distance<$radius)
    {
      $datatemp=true;
      $data1['name']   = $row_temp_moving['name'];
      $data1['mobile_no']   = $row_temp_moving['mobile_no_contact'];
      $mobile_no=$row_temp_moving['mobile_no_contact'];
      $data1['business_mobile_no']   = $row_temp_moving['business_mobile_no'];
      $data1['image_url']=base_url().'assets/upload/profile_image/'.$mobile_no.".jpeg";
      $data1['image_cat_url']=$image_url;
      $menu_image=$row_temp_moving['menu_image'];
      $menu_image_2=$row_temp_moving['menu_image_2'];
      $menu_image_3=$row_temp_moving['menu_image_3'];
      $menu_image_4=$row_temp_moving['menu_image_4'];

     if(!empty($menu_image) or (!empty($menu_image_2)) or (!empty($menu_image3)) or (!empty($menu_image_4)))
      {
         $data1['menu_status'] ='1';
      }
      else
      { 
        $data1['menu_status'] ='0';
      }
      $data1['Moving_url']=base_url().'manage/catImages/moving_hawker12.png'; 
      $data1['cat_data']=$cat_data;
      $data1['latitude'] =$row2['latitude'];
      $data1['longitude'] =$row2['longitude'];
      $data1['hawker_code'] =$row_temp_moving['hawker_code'];
      $data1['distance'] =$distance;
      $data1['user_type'] =$row_temp_moving['seasonal_temp_hawker_type'];
      $data1['cus_id'] =$cus_id;
      $data1['Show_status'] ='1';
      $data1['status'] ='1';
      array_push($result3,$data1);
     
     }
      else
     {
       $data5['Show_status'] ='0';
       $data5['status']  ='0';
       $data5['message']  ='failed';
       array_push($result1 , $data5);
      
       }
      }
     }
     if($datatemp){
//use result 2 array and proceed working
      $response->Moving_status = '1';
      $response->set_timer = '20';
      $response->notified_maxtimer ='3';
      $response->Movingdata = $result3;
    }else{
//use not avail hawker array
       $response->Moving_status = '2';
       $response->message = 'Hawker not available in your area.';
       $response->set_timer = '20';
       $response->notified_maxtimer ='3';
       $response->Movingdata = $result1;
    }
     }
    }

     else if(!empty($getdata_seasonal_moving))
    {
     foreach ($getdata_seasonal_moving as $row_seasonal_moving)
    {
    /*$gps_id=$row1['shop_gps_id'];*/
    $hawker_code=$row_seasonal_moving['hawker_code'];
    $getdevicedata = $this->Customer->get_device_data($hawker_code);
    foreach ($getdevicedata as $getdevice)
    {
      $gps_id=$getdevice['device_id'];
    $getdata2 = $this->Customer->check_data_by_location($gps_id);
    foreach ($getdata2 as $row2)
    {
      $rad = M_PI / 180;
     //Calculate distance from latitude and longitude
     $theta = $longitudeFrom - $row2['longitude'];
     $dist = sin($latitudeFrom * $rad) 
             * sin($row2['latitude'] * $rad) +  cos($latitudeFrom * $rad)
             * cos($row2['latitude'] * $rad) * cos($theta * $rad);

     $distance= acos($dist) / $rad * 60 *  2.250;
      if($distance<$radius)
    {
      $datatemp=true;
      $data1['name']   = $row_seasonal_moving['name'];
      $data1['mobile_no']   = $row_seasonal_moving['mobile_no_contact'];
      $mobile_no=$row_seasonal_moving['mobile_no_contact'];
      $data1['business_mobile_no']   = $row_seasonal_moving['business_mobile_no'];
      $data1['image_url']=base_url().'assets/upload/profile_image/'.$mobile_no.".jpeg";
      $data1['image_cat_url']=$image_url;
      $menu_image=$row_seasonal_moving['menu_image'];
      $menu_image_2=$row_seasonal_moving['menu_image_2'];
      $menu_image_3=$row_seasonal_moving['menu_image_3'];
      $menu_image_4=$row_seasonal_moving['menu_image_4'];
      if(!empty($menu_image) or (!empty($menu_image_2)) or (!empty($menu_image3)) or (!empty($menu_image_4)))
      {
         $data1['menu_status'] ='1';
      }
      else
      {

        $data1['menu_status'] ='0';
      }
      $data1['Moving_url']=base_url().'manage/catImages/moving_hawker12.png'; 
      $data1['cat_data']=$cat_data;
      $data1['latitude'] =$row2['latitude'];
      $data1['longitude'] =$row2['longitude'];
      $data1['hawker_code'] =$row_seasonal_moving['hawker_code'];
      $data1['distance'] =$distance;
      $data1['user_type'] =$row_seasonal_moving['seasonal_temp_hawker_type'];
      $data1['cus_id'] =$cus_id;
      $data1['Show_status'] ='1';
      $data1['status'] ='1';
      array_push($result3,$data1);
     }
      else
     {
       $data5['Show_status'] ='0';
       $data5['status']  ='0';
       $data5['message']  ='failed';
       array_push($result1 , $data5);
      
       }
      }
     }
     }
     if($datatemp){
//use result 2 array and proceed working
      $response->Moving_status = '1';
      $response->set_timer = '20';
      $response->notified_maxtimer ='3';
      $response->Movingdata = $result3;
    }else{
//use not avail hawker array
       $response->Moving_status = '2';
       $response->message = 'Hawker not available in your area.';
       $response->set_timer = '20';
       $response->notified_maxtimer ='3';
       $response->Movingdata = $result1;
    }
    }
    else
    {
      $data1['Show_status'] ='0';
      $data1['status']  ='0';
      $data1['message'] = 'failed';
      array_push($result1 , $data1);
     //$response->message = 'Hawker not available in your area.';
     $response->Moving_status = '2';
     $response->set_timer = '20';
     $response->notified_maxtimer ='3';
     $response->Movingdata = $result1;
    }
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

      /*.........Verification OTP Api For customer  ---- */

     public function verification_otp_data_post()
     {
      $response   =   new StdClass();
      $result       =  new StdClass();
      $mobile_no =$this->input->post('mobile_no');
      $device_id =$this->input->post('device_id');
      $referal_code =$this->input->post('referal_code');
      $otp =$this->input->post('otp');
      $data1->device_id = $device_id;
      $data1->mobile_no = $mobile_no;
      $data1->otp=$otp;
      $dataotp = $this->Customer->verification_otp($data1);
      $cus_id=$dataotp->cus_id;
      date_default_timezone_set('Asia/kolkata'); 
      $now = date('Y-m-d H:i:s');
      $nows = date('Y-m-d');
      if(!empty($dataotp))
      {
      if($referal_code!='')
      {

      $get_notification_id = $this->Customer->notification_data($referal_code);
      $notification_id=$get_notification_id->notification_id;
      require APPPATH . 'firebase.php';
      require APPPATH . 'push.php';
      require APPPATH . 'config.php';
      $firebase = new Firebase();
      $push = new Push();
      // optional payload
      $payload = array();
      $payload['team'] = 'India';
      $payload['score'] = '5.6';
      // notification title
      $title ='Congratulation';
      // notification message
      $message ='A New Customer has been registered on the Hawkers App via your referral code';
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
      $data1 = $firebase->send($regId, $json);
    }
      $notificationdata->title=$title;
      $notificationdata->device_id = $device_id;
      $notificationdata->customer_mobile_no = $mobile_no;
      $notificationdata->hawker_mobile_no = $referal_code;
      $notificationdata->date_time = $now;
      $notificationdata->notification_id = $notification_id;
      $notificationdata->message=$message;
      $notificationdata->status ='1';

       $notification_data = $this->Customer->notification_data_for_referral($notificationdata);

       $que=$this->db->query("select device_id from tbl_hawker_referal_code_for_customer where  referal_code='".$referal_code."' and date='$nows'  and (referral_flag_status='1' or referral_flag_status='0' )");
       $row = $que->num_rows();


       if($row>=10)
       {
         $data2->limit_status ='1';
       }
        $data2->device_id = $device_id;
        $data2->customer_mobile_no = $mobile_no;
        $data2->referal_code = $referal_code;
        $data2->date_time = $now;
        $data2->date=$nows;
        $data2->status = '1';
        $data2->hawker_points = '1';
        $data2->customer_points='1';
        $data2->referral_flag_status='1';

        $flag_status_update = $this->Customer->flag_status_update($data2);
       
      }
        $data->cus_id=$cus_id;
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

       /*.........Verification OTP Api For customer  ---- */

      /*.........Resend OTP Api For customer  ---- */
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
      $res = $this->Customer->send_otp($mobile_no,$otpValue);
      if(!empty($mobile_no))
      {
      $res1 = $this->Customer->resend_otp($data1);
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

      /*.........Remove OTP Api For customer  ---- */
       public function otp_expire_post()
       {
        $response   =   new StdClass();
        $result       =  new StdClass();
        $device_id =$this->input->post('device_id');
        $mobile_no =$this->input->post('mobile_no');
        $data1->device_id = $device_id;
        $data1->mobile_no=$mobile_no;
        $res = $this->Customer->remove_otp($data1);
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

       /*.........Remove OTP Api For customer  ---- */

    /*.........favourite category/subcategory  Api For hawker customer  ---- */
    public function favourite_category_post()
    {
    $response = new StdClass();
    $result = new StdClass();
    $mobile_no = $this->input->post('mobile_no');
    $cus_id=$this->input->post('cus_id');
    $cat_id=$this->input->post('cat_id');
    $sub_cat_id=$this->input->post('sub_cat_id');
    $super_sub_cat_id=$this->input->post('super_sub_cat_id');
    date_default_timezone_set('Asia/kolkata'); 
    $now = date('Y-m-d H:i:s');
    $data->mobile_no = $mobile_no;
    $data->cus_id = $cus_id;
    $data->cat_id = $cat_id;
    $data->sub_cat_id = $sub_cat_id;
    $data->super_sub_cat_id = $super_sub_cat_id;
    $data->status='1';
    $data->time_date=$now;
    $result1 = $this->Customer->favourite_category_add($data);

    if(!empty($mobile_no))
    {
      $data1->status ='1';
      $data1->message = 'favourite category add Successfully';
      array_push($result,$data1);
      $response->data = $data1;
    }
    else
    {
      $response->status ='0';
      $response->message = 'failed';
    }
    echo json_output($response);
    }
    /*..........favourite category/subcategory  Api For hawker customer  ---- */

    /*.........favourite category/subcategory  Api For hawker customer  ---- */
    public function unfavourite_category_post()
    {
    $response = new StdClass();
    $result = new StdClass();
    $mobile_no = $this->input->post('mobile_no');
    $cus_id=$this->input->post('cus_id');
    $cat_id=$this->input->post('cat_id');
    $sub_cat_id=$this->input->post('sub_cat_id');
    $super_sub_cat_id=$this->input->post('super_sub_cat_id');
    date_default_timezone_set('Asia/kolkata'); 
    $now = date('Y-m-d H:i:s');
    $data->mobile_no = $mobile_no;
    $data->cus_id = $cus_id;
    $data->cat_id = $cat_id;
    $data->sub_cat_id = $sub_cat_id;
    $data->super_sub_cat_id = $super_sub_cat_id;
    $data->status='0';
    $data->time_date=$now;
    if($sub_cat_id=='' and $super_sub_cat_id=='')
    {
    $result1 = $this->Customer->unfavourite_category($data);
    }
    else if($cat_id=='' and $sub_cat_id=='')
    {
      $result1 = $this->Customer->unfavourite_category2($data);
    }
    else if($cat_id=='' and $super_sub_cat_id=='')
    {
      $result1 = $this->Customer->unfavourite_category1($data);
    }

    if(!empty($mobile_no))
    {
      $data1->status ='1';
      $data1->message = ' data update Successfully';
      array_push($result,$data1);
      $response->data = $data1;
    }
    else
    {
      $response->status ='0';
      $response->message = 'failed';
    }
    echo json_output($response);
    }
     /*..........favourite category/subcategory  Api For hawker customer  ---- */

  /*.........favourite category  Api For Fixer  ---- */
    public function favourite_category_data_post()
    {
      $response   =   new StdClass();
      $result       =   array();
      $cus_id=$this->input->post('cus_id');
      $datacat = $this->Customer->favourite_category_data_profile($cus_id);
      if(!empty($datacat))
      {
       foreach ($datacat as $row)
      {
      $cat_id=$row['cat_id'];
      $sub_cat_id=$row['sub_cat_id'];
      $super_sub_cat_id=$row['super_sub_cat_id'];
      if($sub_cat_id=='' and $super_sub_cat_id=='')
      {
      $datacat1 = $this->Customer->getcategory($cat_id);

     /* if(!empty($datacat1))
      {*/
      foreach ($datacat1 as $row1)
      {
       $data['id']    = $row1['id'];  
       $data['cat_name']    = $row1['cat_name'];
       $data['image_url']=base_url().'manage/catImages/'.$row1['cat_icon_image'];
       $data['status']  ='1';
       $data['status_type']='CATE';
      array_push($result,$data);
      }
       } 
     /* }*/
       if($cat_id=='' and $super_sub_cat_id=='')
       {
          $datacat3 = $this->Customer->get_sub_category($sub_cat_id);
       
      foreach ($datacat3 as $row2)
      {
       $data['id']    = $row2['id'];  
       $data['cat_name']    = $row2['sub_cat_name'];
       $data['image_url']=base_url().'manage/catImages/'.$row2['sub_cat_image'];
       $data['status']  ='1';
       $data['status_type']='SUBCATE';
      array_push($result,$data);
      }
       } 
       if($sub_cat_id=='' and $cat_id=='')
      {
      $datacat4 = $this->Customer->get_super_sub_category($super_sub_cat_id);

      if(!empty($datacat4))
      {
      foreach ($datacat4 as $row4)
      {
       $data['id']    = $row4['id'];  
       $data['cat_name']    = $row4['super_sub_cat_name'];
       $data['image_url']=base_url().'manage/catImages/'.$row4['super_sub_cat_image'];
       $data['status']  ='1';
       $data['status_type']='SUPSUBCATE';
      array_push($result,$data);
      }

       } 
      }
      $response->favourite = $result;
      }
     }
      else
      {
       $data['status']  ='0';
       array_push($result , $data);
       $response->favourite = $result;
      }

      
      echo json_output($response);
     }
    /*.........favourite category Api For Fixer  ---- */

    /*.........Customer call by hawker Api For hawker customer  ---- */
    public function customer_call_by_hawker_post()
    {
    $response = new StdClass();
    $result = new StdClass();
    $cus_id = $this->input->post('cus_id');
    $hawker_id=$this->input->post('hawker_id');
    $customer_no=$this->input->post('customer_no');
    $latitude=$this->input->post('latitude');
    $longitude=$this->input->post('longitude');
    date_default_timezone_set('Asia/kolkata'); 
    $now = date('Y-m-d H:i:s');
    $data->cus_id = $cus_id;
    $data->hawker_id = $hawker_id;
    $data->customer_no = $customer_no;
    $data->latitude = $latitude;
    $data->longitude = $longitude;
    $data->date_time=$now;
    $data->status='1';
    $result1 = $this->Customer->get_data_by_customer($data);

    if(!empty($result1))
    {
      $data1->status ='1';
      $data1->message = 'add Successfully';
      array_push($result,$data1);
      $response->data = $data1;
    }
    else
    {
      $response->status ='0';
      $response->message = 'failed';
    }
    echo json_output($response);
    }
    /*..........Customer call by hawker Api For hawker customer  ---- */

    /*.........Customer Navigate by hawker Api For hawker customer  ---- */
    public function customer_navigate_by_hawker_post()
    {
    $response = new StdClass();
    $result = new StdClass();
    $cus_id = $this->input->post('cus_id');
    $hawker_id=$this->input->post('hawker_id');
    $customer_no=$this->input->post('customer_no');
    $latitude=$this->input->post('latitude');
    $longitude=$this->input->post('longitude');
    date_default_timezone_set('Asia/kolkata'); 
    $now = date('Y-m-d H:i:s');
    $data->cus_id = $cus_id;
    $data->hawker_id = $hawker_id;
    $data->customer_no = $customer_no;
    $data->latitude = $latitude;
    $data->longitude = $longitude;
    $data->date_time=$now;
    $data->status='1';
    $result1 = $this->Customer->get_navigate_by_customer($data);

    if(!empty($result1))
    {
      $data1->status ='1';
      $data1->message = 'add Successfully';
      array_push($result,$data1);
      $response->data = $data1;
    }
    else
    {
      $response->status ='0';
      $response->message = 'failed';
    }
    echo json_output($response);
    }
    /*..........Customer Navigate  by hawker Api For hawker customer  ---- */

    /*.........Customer Navigate by hawker Api For hawker customer  ---- */
    public function notified_custumer_by_time_set_post()
    {
    $response = new StdClass();
    $result = new StdClass();
    $cus_id = $this->input->post('cus_id');
    $mobile_no = $this->input->post('mobile_no');
    $latitude=$this->input->post('latitude');
    $longitude=$this->input->post('longitude');
    $notification_id=$this->input->post('notification_id');
    $cat_id = $this->input->post('cat_id');
    $sub_cat_id = $this->input->post('sub_cat_id');
    $super_sub_cat_id = $this->input->post('super_sub_cat_id');
    $radius=$this->input->post('radius'); 
    $city=$this->input->post('city'); 
    $set_time=$this->input->post('set_time');
   
    $data->cus_id = $cus_id;
    $data->mobile_no = $mobile_no;
    $data->cat_id = $cat_id;
    $data->sub_cat_id = $sub_cat_id;
    $data->super_sub_cat_id = $super_sub_cat_id;
    $data->radius = $radius;
    $data->notification_id = $notification_id;
    $data->set_time = $set_time;
    $data->latitude = $latitude;
    $data->longitude = $longitude;
    $data->city = $city;
    date_default_timezone_set('Asia/kolkata'); 
    $now = date('Y-m-d H:i:s');
    $data->date_time = $now;
    $data->status='1';
    
   /////////////// history table for radius data//////////
   
    if(!empty($cat_id))
    {
       /*$result5=$this->Customer->insert_notified_data($data);*/
        /////////////// history tabble for radius data//////////
    /*  $result1 = $this->Customer->send_set_time_for_notification($data);*/
      $notifieddata = $this->Customer->near_by_hawker_data($data);
      $data1->status ='1';
      $data1->message = 'data insert Successfully';
      array_push($result,$data1);
      $response->data = $data1;
    }
    else
    {
      $response->status ='0';
      $response->message = 'failed';
    }
    echo json_output($response);
    }
    /*..........Customer Navigate  by hawker Api For hawker customer  ---- */

   /*......... Get Check Version data   ---- */
  public function app_check_version_post()
   {
    $response = new StdClass();
    $result2 = new StdClass();
    $version_name = $this->input->post('version_name');
    $version_code =$this->input->post('version_code');
    $result->version_name = $version_name;
    $result->version_code = $version_code;
    $res = $this->Customer->Validate_version_data($result);
    $version_name_data=$res->version_name;
    $version_code_data=$res->version_code;
    $update_code_status=$res->update_code_status;

    if($version_code_data==$version_code)
    {
      $data1->status ='1';
      $data1->message = 'success';
      array_push($result2,$data1);
      $response->data = $data1;

    }
    else if($version_code_data<$version_code)
    {
      $res2 = $this->Customer->update_version_data($result);
      $data1->status ='1';
      $data1->message = 'success';
      array_push($result2,$data1);
      $response->data = $data1;

    }
    else if($version_code_data>$version_code)
    {
      $data1->status ='0';
      $data1->update_status =$update_code_status;
      $data1->message = 'A new update is available on the Play Store.
If you want to update  press button.';
      array_push($result2,$data1);
      $response->data = $data1;

    }
    else
    {

      /*$res2 = $this->Customer->update_version_data($result);*/
      $data1->status ='0';
      $data1->message = 'Update Your Application';
      array_push($result2,$data1);
      $response->data = $data1;
    }
    echo json_output($response);
   }
      /*......... Get Check Version data  ---- */

       /*.........favourite category  Api For Fixer  ---- */
    public function show_notification_data_post()
    {
      $response   =   new StdClass();
      $result       =   array();
      $cus_id=$this->input->post('cus_id');
      $datacat4 = $this->Customer->moving_notification_data($cus_id);

      if(!empty($datacat4))
      {
      foreach ($datacat4 as $row4)
      {
      $data['title']    = $row4['title'];  
       $data['message']    = $row4['message'];
       $data['date_time']=$row4['date_time'];
       $data['status']  ='1';
      array_push($result,$data);
      }
       }
      $datacat = $this->Customer->catgory_notification_data($cus_id);
      if(!empty($cus_id))
      {
      if(!empty($datacat))
      {
       foreach ($datacat as $row)
      {
      
       $data['title']    = $row['title'];  
       $data['message']    = $row['message'];
       $data['date_time']=$row['date_time'];
       $data['status']  ='1';
      array_push($result,$data);
      }
      } 
     /* }*/
     
      $datacat3 = $this->Customer->sub_catgory_notification_data($cus_id);
       if(!empty($datacat3))
       {
      foreach ($datacat3 as $row2)
      {
       $data['title']    = $row2['title'];  
       $data['message']    = $row2['message'];
       $data['date_time']=$row2['date_time'];
       $data['status']  ='1';
      array_push($result,$data);
      }
    }
    if($datacat=='' and $datacat3=='' and $datacat4=='')
    {
      $data['status']  ='0';
      array_push($result,$data);
    }
      $response->data = $result;
     }
      else
      {
       $data['status']  ='0';
       array_push($result , $data);
       $response->data = $result;
      }

      
      echo json_output($response);
     }
    /*.........favourite category Api For Fixer  ---- */

     /*......... logout Api For Door hawker ---- */
    public function data_logout_for_customer_post()
    {
    $response = new StdClass();
    $result = array();
    $device_id =$this->input->post('device_id');
    $cus_id =$this->input->post('cus_id');
    date_default_timezone_set('Asia/kolkata'); 
    $now = date('Y-m-d H:i:s');
    $data->cus_id = $cus_id;
    $data->device_id = $device_id;
    $data->logout_time=$now;
    $resdata1 = $this->Customer->logout_customer_data($data);
    if($device_id)
    {
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

    /*......... logout Api For Door hawker ---- */
    public function service_request_city_by_customer_post()
    {
    $response = new StdClass();
    $result = array();
    $city =$this->input->post('city');
    $notification_id =$this->input->post('notification_id');
    date_default_timezone_set('Asia/kolkata'); 
    $now = date('Y-m-d H:i:s');
    $data->city = $city;
    $data->notification_id = $notification_id;
    $data->date_time=$now;
    $resdata1 = $this->Customer->request_city_by_customer_data($data);
    if($resdata1!='')
    {
    $data1->status ='1';
    $data1->message=' success';
    array_push($result,$data1);
    $response->data = $data1;
      }
        else
        {
          $data1->status ='0';
          $data1->message ='failed';
      array_push($result,$data1);
       $response->data = $data1;
        }
    echo json_output($response);
   }

    /*......... logout data From Wifi-module Api For Door Unlock ---- */

    /*......... feedback Api for hawker customer  ---- */
  public function feedback_insert_data_post()
   {
      $response = new StdClass();
      $result = new StdClass();
      $cus_id = $this->input->post('cus_id');
      $sDescription =$this->input->post('sDescription');
      date_default_timezone_set('Asia/kolkata'); 
      $now = date('Y-m-d H:i:s');
      $data->cus_id = $cus_id;
      $data->description = $sDescription;
      $data->date_time = $now;
      $data->status = '1';
      $res = $this->Customer->feedback_data($data);
      if(!empty($res))
      {
      $data1->status ='1';
      $data1->message ='Your feedback has been send successfully.';
      array_push($result,$data1);
      $response->data = $data1;
      }
      else
      {
      $data1->status ='0';
      $data1->message ='failed';
      array_push($result,$data1);
      $response->data = $data1;
      }
    echo json_output($response);
   }

   /*.........  feedback Api for hawker customer  ---- */

    /*......... check data for customer  ---- */
  public function customer_data_post()
   {
      $response = new StdClass();
      $result = new StdClass();
      $mobile_no = $this->input->post('mobile_no');
      $res = $this->Customer->customer_data($mobile_no);
      if($mobile_no=='')
      {
      $data1->status ='2';
      array_push($result,$data1);
      $response->data = $data1;
      }
      else if(!empty($res))
      {
      $data1->status ='1';
      array_push($result,$data1);
      $response->data = $data1;
      }
      else
      {
      $data1->status ='0';
      $data1->message ='Please Re-Login / Restart Application \n Press OK';
      array_push($result,$data1);
      $response->data = $data1;
      }
    echo json_output($response);
   }

   /*......... check data for customer ---- */

    /*.........favourite category  Api For Fixer  ---- */
    public function get_menu_image_post()
    {
      $response   =   new StdClass();
      $result = new StdClass();
      $mobile_no=$this->input->post('mobile_no');
      $menu_image_data = $this->Customer->get_menu_image_data($mobile_no);
      if(!empty($menu_image_data))
      {
      
      //$menu_image=$row['menu_image'];
       $menu_image=$menu_image_data->menu_image;
      if(!empty($menu_image))
      {
         $data1['menu_image_url_1']=$menu_image;
      }
      else
      {
        $data1['menu_image_url_1']="";
      }
      //$menu_image_2=$row['menu_image_2'];
       $menu_image_2=$menu_image_data->menu_image_2;
       if(!empty($menu_image_2))
      {
         $data1['menu_image_url_2']=$menu_image_2;
      }
      else
      {
        $data1['menu_image_url_2']="";
      }
      //$menu_image_3=$row['menu_image_3'];
      $menu_image_3=$menu_image_data->menu_image_3;
       if(!empty($menu_image_3))
      {
         $data1['menu_image_url_3']=$menu_image_3;
      }
      else
      {
        $data1['menu_image_url_3']="";
      }
      //$menu_image_4=$row['menu_image_4'];
       $menu_image_4=$menu_image_data->menu_image_4;
       if(!empty($menu_image_4))
      {
         $data1['menu_image_url_4']=$menu_image_4;
      }
      else
      {
        $data1['menu_image_url_4']="";
      }
       $data1['status']  ='1';
      array_push($result,$data1);
      
       $response->data = $data1;
      } 
      else
      {
       $data1['status']  ='0';
       array_push($result , $data1);
       $response->data = $data1;
      }
      echo json_output($response);
     }
    /*.........favourite category Api For Fixer  ---- */

    /*................... MAP API FOR HAWKER ------------*/

    public function location_mapped_post()
    {
      $response   =   array();
      $result1       =   array();
      $checkcitystatusdata = $this->Customer->get_gps_sales_location_data();
  
      if(!empty($checkcitystatusdata))
      {
      foreach ($checkcitystatusdata as $row4)
      {
      $data2['sales_id']    = $row4['sales_id'];
      $data2['latitude']    = $row4['latitude'];
      $data2['longitude']    = $row4['longitude'];

      array_push($result1,$data2);
     
      }
       $response['location'] = $result1;

      } 
      else
      {
       $data['status']  ='0';
       array_push($result1 , $data);
       $response->location = $result1;
      }

      echo json_output($response);
     }
 /*................... MAP API FOR HAWKER ------------*/

 /*......... show location by Hawker ---- */
  public function show_location_by_hawker_post()
   {
      $response = new StdClass();
      $result = new StdClass();
      $hawker_code = $this->input->post('hawker_code');
      $hawker_mobile_no = $this->input->post('hawker_mobile_no');
      $latitude = $this->input->post('latitude');
      $longitude = $this->input->post('longitude');
      $customer_mobile_no = $this->input->post('customer_mobile_no');
      $location_name=$this->input->post('location_name');
      date_default_timezone_set('Asia/kolkata'); 
      $now = date('Y-m-d H:i:s');
      $data->hawker_code = $hawker_code;
      $data->hawker_mobile_no = $hawker_mobile_no;
      $data->latitude = $latitude;
      $data->longitude = $longitude;
      $data->customer_mobile_no = $customer_mobile_no;
      $data->location_name=$location_name;
      $data->date_time = $now;
      $data->status = '1';
      $get_hawker_notification_id_data = $this->Customer->get_hawker_notification_id($hawker_code,$hawker_mobile_no);

    
      $que=$this->db->query("select * from tbl_show_location_by_hawker where hawker_code='".$hawker_code."' and hawker_mobile_no='".$hawker_mobile_no."' and  customer_mobile_no!='$customer_mobile_no'");
      $row = $que->num_rows();
      if($row>0)
      {
        $data1->status ='2';
        $data1->message ='This user have already a trip. So, you can not share location right now.
please try later ,when this hawker  free then you can share your location.';
        array_push($result,$data1);
        $response->data = $data1;
      }
      else if($row=='0')
      {
        $res = $this->Customer->show_location_hawker($data);
      foreach ($get_hawker_notification_id_data as $rownotified_data)
      {
      $notification_id=$rownotified_data['notification_id'];
      require APPPATH . 'firebase.php';
      require APPPATH . 'push.php';
      require APPPATH . 'config.php';
      $firebase = new Firebase();
      $push = new Push();
      // optional payload
      $payload = array();
      $payload['team'] = 'India';
      $payload['score'] = '5.6';
      // notification title
      $title ='Hawker Share Location';
      // notification message
      $message =''.$customer_mobile_no. ' have share your location ';
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
      $data2 = $firebase->send($regId, $json);
    }
  }
      $data1->status ='1';
      $data1->message ='Your data insert successfully.';
      array_push($result,$data1);
      $response->data = $data1;
      }
      else
      {
      $data1->status ='0';
      $data1->message ='failed';
      array_push($result,$data1);
      $response->data = $data1;
      }
    echo json_output($response);
   }

   /*.........  show location by Hawker  ---- */

    /*.........GPS moves customer latitude and longitude  Api---- */

     public function Customer_location_by_gps_post()
   {
     $response = new StdClass();
     $result = new StdClass();
     $mobile_no  = $this->input->post('mobile_no');
     $latitude  = $this->input->post('latitude');
     $longitude = $this->input->post('longitude');
     $device_id  = $this->input->post('device_id');
     date_default_timezone_set('Asia/kolkata'); 
     $now = date('Y-m-d H:i:s');
     $data->mobile_no  = $mobile_no;
     $data->latitude  = $latitude;
     $data->longitude = $longitude;
     $data->device_id = $device_id;
     $data->date_time = $now;
     $data->active_status='1';
     $res = $this->Customer->Customer_location_add_data($data);
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

    /*.......GPS moves customer latitude and longitude  Api ---- */

    /*.........get_seller_list_data_by_location  Api For hawker  ---- */
  public function get_customer_list_data_by_count_post()
  {
    $response   =   new StdClass();
    //$response1  =   new StdClass();
    $result       =   array();
    $result1       =   array();
    $result2       =   array();
    $result3       =   array();
    $datatemp=false;
    $datatemp1=false;
    $Notavailhawker=array();
    $latitudeFrom =$this->input->post('latitude');
    $longitudeFrom =$this->input->post('longitude');
    $notification_id =$this->input->post('notification_id');
    $cus_id =$this->input->post('cus_id');
    $cat_id =$this->input->post('cat_id');
    $sub_cat_id =$this->input->post('sub_cat_id_1');
    $super_sub_cat_id =$this->input->post('sub_cat_id_2');
    $radius =$this->input->post('radius');
    $city =$this->input->post('city');
    date_default_timezone_set('Asia/kolkata'); 
    $now = date('Y-m-d H:i:s');
    $logdata->latitude = $latitudeFrom;
    $logdata->longitude = $longitudeFrom;
    $logdata->notification_id = $notification_id;
    $logdata->cus_id = $cus_id;
    $logdata->cat_id = $cat_id;
    $logdata->sub_cat_id = $sub_cat_id;
    $logdata->super_sub_cat_id = $super_sub_cat_id;
    $logdata->radius = $radius;
    $logdata->city = $city;
    $logdata->date_time=$now;
    $logdata->status='1';
    if($sub_cat_id=='' or $sub_cat_id=='0')
    {
    $getdata = $this->Customer->check_data_by_registerseller($cat_id,$city);
    }
   else
   {
     $getdata = $this->Customer->check_data_by_registerseller1($sub_cat_id,$city);
   }
   if($sub_cat_id=='' or $sub_cat_id=='0')
   {
    $getdata1 = $this->Customer->check_data_by_registerseller2($cat_id,$city);
   }
   else
   {
     $getdata1 = $this->Customer->check_data_by_registerseller3($sub_cat_id,$city);
   }
   if($sub_cat_id=='' or $sub_cat_id=='0')
    {
    $getdata_temp = $this->Customer->check_data_by_registerseller_temp_fix($cat_id,$city);
    }
   else
   {
     $getdata_temp = $this->Customer->check_data_by_registerseller1_temp_fix($sub_cat_id,$city);
   }
   if($sub_cat_id=='' or $sub_cat_id=='0')
    {
    $getdata_seasonal = $this->Customer->check_data_by_registerseller_seasonal_fix($cat_id,$city);
    }
   else
   {
     $getdata_seasonal = $this->Customer->check_data_by_registerseller1_seasonal_fix($sub_cat_id,$city);
   }
   if($sub_cat_id=='' or $sub_cat_id=='0')
    {
    $getdata_temp_moving = $this->Customer->check_data_by_registerseller_temp_moving($cat_id,$city);
    }
   else
   {
     $getdata_temp_moving = $this->Customer->check_data_by_registerseller1_temp_moving($sub_cat_id,$city);
   }

   if($sub_cat_id=='' or $sub_cat_id=='0')
    {
    $getdata_seasonal_moving = $this->Customer->check_data_by_registerseller_seasonal_moving($cat_id,$city);
    }
   else
   {
     $getdata_seasonal_moving = $this->Customer->check_data_by_registerseller1_seasonal_moving($sub_cat_id,$city);
   }

   if(!empty($getdata))
    {
    foreach ($getdata as $row)
    {
      $userType=$row['user_type'];
      $rad = M_PI / 180;
     //Calculate distance from latitude and longitude
     $theta = $longitudeFrom - $row['shop_longitude'];
     $dist = sin($latitudeFrom * $rad) 
             * sin($row['shop_latitude'] * $rad) +  cos($latitudeFrom * $rad)
             * cos($row['shop_latitude'] * $rad) * cos($theta * $rad);

     $distance= acos($dist) / $rad * 60 *  2.250;
     if($distance<=$radius)
     {
      $datatemp=true;
      $data['status'] ='1';
      array_push($result2,$data);
    }
    else
    {
      $data4['status']  ='0';
      $data4['message']  ='failed';
      array_push($result , $data4);
    }
    
    }
    if($datatemp){
//use result 2 array and proceed working
      $response->fix_count = count($result2);
      $response->fix_status = '1';
     /* $response->fixdata = $result2;*/
    }else{
//use not avail hawker array
      $response->fix_count = '0';
      $response->fix_status = '2';
      $response->message = 'Hawker not available in your area.';
    /*  $response->fixdata = $result;*/
    }
    }
    else if(!empty($getdata_temp))
    {
       foreach ($getdata_temp as $row_temp)
    {
      //$userType=$row['user_type'];
      $rad = M_PI / 180;
     //Calculate distance from latitude and longitude
     $theta = $longitudeFrom - $row_temp['shop_longitude'];
     $dist = sin($latitudeFrom * $rad) 
             * sin($row_temp['shop_latitude'] * $rad) +  cos($latitudeFrom * $rad)
             * cos($row_temp['shop_latitude'] * $rad) * cos($theta * $rad);

     $distance= acos($dist) / $rad * 60 *  2.250;

    
      if($distance<=$radius)
     {
      $datatemp=true;
      $data['status'] ='1';
      array_push($result2,$data);
      
    }
    else
    {
      $data4['status']  ='0';
      $data4['message']  ='failed';
      array_push($result , $data4);
    }
    }
    if($datatemp){
//use result 2 array and proceed working
      $response->fix_count = count($result2);
      $response->fix_status = '1';
     /* $response->fixdata = $result2;*/
    }else{
//use not avail hawker array
      $response->fix_count ='0';
      $response->fix_status = '2';
      $response->message = 'Hawker not available in your area.';
    /*  $response->fixdata = $result;*/
    }
    }
   else if(!empty($getdata_seasonal))
    {
       foreach ($getdata_seasonal as $row_seasonal)
    {
      //$userType=$row['user_type'];
      $rad = M_PI / 180;
     //Calculate distance from latitude and longitude
     $theta = $longitudeFrom - $row_seasonal['shop_longitude'];
     $dist = sin($latitudeFrom * $rad) 
             * sin($row_seasonal['shop_latitude'] * $rad) +  cos($latitudeFrom * $rad)
             * cos($row_seasonal['shop_latitude'] * $rad) * cos($theta * $rad);

     $distance= acos($dist) / $rad * 60 *  2.250;

    
      if($distance<=$radius)
     {
      $datatemp=true;
      $data['status'] ='1';
      array_push($result2,$data);
     
    }
    else
    {
      $data4['status']  ='0';
      $data4['message']  ='failed';
      array_push($result , $data4);
      
    }
    }
    if($datatemp){
//use result 2 array and proceed working
      $response->fix_count = count($result2);
      $response->fix_status = '1';
      /*$response->fixdata = $result2;*/
    }else{
//use not avail hawker array
      $response->fix_count = '0';
      $response->fix_status = '2';
      $response->message = 'Hawker not available in your area.';
      /*$response->fixdata = $result;*/
    }
    }
    else
    {
      $data['status']  ='0';
      $data['message'] = 'failed';
       array_push($result , $data);
      $response->fix_count ='0';
      $response->fix_status = '2';
     /* $response->fixdata = $result;*/
    } 

    if(!empty($getdata1))
    {

     foreach ($getdata1 as $row1)
    {
    $hawker_code=$row1['hawker_code'];
    $getdevicedata = $this->Customer->get_device_data($hawker_code);
    foreach ($getdevicedata as $getdevice)
    {
      $gps_id=$getdevice['device_id'];
      $getdata2 = $this->Customer->check_data_by_location($gps_id);
    foreach ($getdata2 as $row2)
    {
      $rad = M_PI / 180;
     //Calculate distance from latitude and longitude
     $theta = $longitudeFrom - $row2['longitude'];
     $dist = sin($latitudeFrom * $rad) 
             * sin($row2['latitude'] * $rad) +  cos($latitudeFrom * $rad)
             * cos($row2['latitude'] * $rad) * cos($theta * $rad);

     $distance= acos($dist) / $rad * 60 *  2.250;
      if($distance<=$radius)
    {
      $datatemp1=true;
      $data1['status'] ='1';
      array_push($result3,$data1);
      
     }
      else
     {
       $data5['status']  ='0';
       $data5['message']  ='failed';
       array_push($result1 , $data5);
       
     }
    }
    }
    }
    if($datatemp1){
//use result 2 array and proceed working
      $response->Moving_count = count($result3);
      $response->Moving_status = '1';
      /*$response->Movingdata = $result3;*/
    }else{
//use not avail hawker array
       $response->Moving_count ='0';
       $response->Moving_status = '2';
       $response->message = 'Hawker not available in your area.';
      /* $response->Movingdata = $result1;*/
       
    
    }
    }
    else if(!empty($getdata_temp_moving))
    {
     foreach ($getdata_temp_moving as $row_temp_moving)
    {
    /*$gps_id=$row1['shop_gps_id'];*/
    $hawker_code=$row_temp_moving['hawker_code'];
    $getdevicedata = $this->Customer->get_device_data($hawker_code);
    foreach ($getdevicedata as $getdevice)
    {
      $gps_id=$getdevice['device_id'];
    $getdata2 = $this->Customer->check_data_by_location($gps_id);
    foreach ($getdata2 as $row2)
    {
      $rad = M_PI / 180;
     //Calculate distance from latitude and longitude
     $theta = $longitudeFrom - $row2['longitude'];
     $dist = sin($latitudeFrom * $rad) 
             * sin($row2['latitude'] * $rad) +  cos($latitudeFrom * $rad)
             * cos($row2['latitude'] * $rad) * cos($theta * $rad);

     $distance= acos($dist) / $rad * 60 *  2.250;
      if($distance<$radius)
    {
      $datatemp=true;
      $data1['status'] ='1';
      array_push($result3,$data1);
     
     }
      else
     {
       $data5['status']  ='0';
       $data5['message']  ='failed';
       array_push($result1 , $data5);
      
       }
      }
     }
     if($datatemp){
//use result 2 array and proceed working
      $response->Moving_count = count($result3);
      $response->Moving_status = '1';
     /* $response->Movingdata = $result3;*/
    }else{
//use not avail hawker array
       $response->Moving_count = '0';
       $response->Moving_status = '2';
       $response->message = 'Hawker not available in your area.';
       /*$response->Movingdata = $result1;*/
    }
     }
    }

     else if(!empty($getdata_seasonal_moving))
    {
     foreach ($getdata_seasonal_moving as $row_seasonal_moving)
    {
    /*$gps_id=$row1['shop_gps_id'];*/
    $hawker_code=$row_seasonal_moving['hawker_code'];
    $getdevicedata = $this->Customer->get_device_data($hawker_code);
    foreach ($getdevicedata as $getdevice)
    {
      $gps_id=$getdevice['device_id'];
    $getdata2 = $this->Customer->check_data_by_location($gps_id);
    foreach ($getdata2 as $row2)
    {
      $rad = M_PI / 180;
     //Calculate distance from latitude and longitude
     $theta = $longitudeFrom - $row2['longitude'];
     $dist = sin($latitudeFrom * $rad) 
             * sin($row2['latitude'] * $rad) +  cos($latitudeFrom * $rad)
             * cos($row2['latitude'] * $rad) * cos($theta * $rad);

     $distance= acos($dist) / $rad * 60 *  2.250;
      if($distance<$radius)
    {
      $datatemp=true;
      $data1['status'] ='1';
      array_push($result3,$data1);
     }
      else
     {
       $data5['status']  ='0';
       $data5['message']  ='failed';
       array_push($result1 , $data5);
      
       }
      }
     }
     }
     if($datatemp){
//use result 2 array and proceed working
      $response->Moving_count = count($result3);
      $response->Moving_status = '1';
      /*$response->Movingdata = $result3;*/
    }else{
//use not avail hawker array
       $response->Moving_count = '0';
       $response->Moving_status = '2';
       $response->message = 'Hawker not available in your area.';
      /* $response->Movingdata = $result1;*/
    }
    }
    else
    {
      $data1['status']  ='0';
      $data1['message'] = 'failed';
      array_push($result1 , $data1);
     //$response->message = 'Hawker not available in your area.';
     $response->Moving_count ='0';
     $response->Moving_status = '2';
    /* $response->Movingdata = $result1;*/
    }
    echo json_output($response);
    }

    /*........get_seller_list_data_by_location Api For hawker  ---- */

    public function banner_image_data_post()
   {
    $response   =   new StdClass();
    $result       =   array();
    $banner_image       =  $this->db->where(['status'=>'1'])
          ->get('tbl_banner_image')->result_array();
      if(!empty($banner_image))
       {
             foreach ($banner_image as $row)
           {

            $data1->id =   $row['id'];
            $data1->image = base_url().'manage/hawker_offer_image/'.$row['image']; 
            $data1->date_time =$row['date_time'];
            $data1->status ='1';
            $data1->message = 'success';
             array_push($data1,$data1);
             
            
           } 
           $response->data = $data1;
         }
         else
         {
          $data1->status ='0';
            array_push($result , $data);
         }
           $response->data = $data1;
           echo json_output($response);
        }


   /*......... Referral code  Hawker ---- */

   public function referral_code_for_customer_post()
    {
    $response = new StdClass();
    $result = new StdClass();
    $referal_code=$this->input->post('referal_code');
    $customer_mobile=$this->input->post('customer_mobile');
    $device_id=$this->input->post('device_id');
    $data1->device_id = $device_id;
    $data1->referal_code = $referal_code;
    if(!empty($device_id))
    {
    $getdata1  =  $this->db
                  ->select('*')
                  ->from("login_manage_custumer")
                  ->where(['mobile_no'=>$customer_mobile])
                  ->get()->result_array();

    $que=$this->db->query("select device_id from tbl_hawker_referal_code_for_customer where device_id='".$device_id."' and referal_code='".$referal_code."'  and referral_flag_status='1'");

    $quedata=$this->db->query("select device_id from tbl_hawker_referal_code_for_customer where  device_id='".$device_id."' and referal_code='".$referal_code."' and referral_flag_status='0'");

    $quedata2=$this->db->query("select device_id from tbl_hawker_referal_code_for_customer where  device_id='".$device_id."' and referal_code='".$referal_code."' and referral_flag_status='0' and money_received_status='1'");

     $quedata1=$this->db->query("select device_id from tbl_hawker_referal_code_for_customer where  customer_mobile_no='".$customer_mobile."' and referral_flag_status='0' and money_received_status='1'");

    $quedata3=$this->db->query("select device_id from tbl_hawker_referal_code_for_customer where  device_id='".$device_id."' and  referral_flag_status='0' and money_received_status='1'");

    $quedata5=$this->db->query("select device_id from login_manage_custumer where  device_id='".$device_id."' and  status='1'");


    $quedata4=$this->db->query("select device_id from tbl_hawker_referal_code_for_customer where  device_id='".$device_id."' and  referral_flag_status='1' and money_received_status='0'");

    $row = $que->num_rows();
    $row1 = $quedata->num_rows();
    $row2 = $quedata1->num_rows();
    $row3 = $quedata2->num_rows();
    $row4 = $quedata3->num_rows();
    $row5 = $quedata4->num_rows();
    $row6 = $quedata5->num_rows();
      
  /*  $referral_code_data = $this->Customer->check_referral_code_data($data1);
*/
    $check_login_sellers = $this->Customer->check_login_seller_data($referal_code);
    $check_login_mobile_no=$check_login_sellers->mobile_no_contact;

     if(empty($check_login_mobile_no))
      {
      
      $data['referral_message'] = 'You entered invalid referral code.';
      $data['status']  ='3';
      array_push($result,$data);
      $response->data = $result;
      }

     else if(!empty($getdata1))
      {
      $data['referral_message'] = 'You are already an existing user.';
      $data['status']  ='1';
      array_push($result,$data);
     
        $response->data = $result;
      }
      else if($row>0)
      {
      $data['referral_message'] = 'This device has already used a referral code.';
      $data['status']  ='2';
      array_push($result,$data);
      $response->data = $result;
      }
      else if ($row3>0)
      {
        $data['referral_message'] = 'You have already use referral code.';
        $data['status']  ='2';
        array_push($result,$data);
        $response->data = $result;
      }
      else if($row2>0)
      {
       $data['referral_message'] = 'You entered Invalid referral code.';
       $data['status']  ='2';
      array_push($result,$data);
      $response->data = $result;
      } 
      else if($row4>0)
      {
        $data['referral_message'] = 'This device has already used a referral code.';
        $data['status']  ='2';
       array_push($result,$data);
        $response->data = $result;
      }
      else if($row6>0)
      {
        $data['referral_message'] = 'This device has already used a referral code.';
        $data['status']  ='2';
       array_push($result,$data);
        $response->data = $result;
      }
      else if($row1>0)
      {
      $data['referral_message'] = 'Enter valid referral code.';
      $data['status']  ='4';
      array_push($result,$data);
       $response->data = $result;
      }
      else if ($row5>0)
      {
         $data['referral_message'] = 'This device has already used a referral code.';
         $data['status']  ='2';
         array_push($result,$data);
         $response->data = $result;
      }
      
      else
      { 
       
       $data['referral_message'] = 'Valid Referral Code';
       $data['status']  ='4';
       array_push($result,$data);
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
    
      /*.........Referral code  Hawker ---- */
      /*.........GPS moves customer latitude and longitude  Api---- */

    /*public function genrate_referral_code_for_customers_post()
    {
     $response = new StdClass();
     $result = new StdClass();
     $device_id  = $this->input->post('device_id');
     $mobile_no  = $this->input->post('mobile_no');
     date_default_timezone_set('Asia/kolkata'); 
     $now = date('Y-m-d H:i:s');
     $otpValue=substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 7);
     $data2->customer_referral_code =$otpValue;
     $data2->mobile_no  = $mobile_no;
     $data2->device_id  = $device_id;
     $data2->customer_point ='1';
     $data2->date_time =$now;
     $data2->status='1';*/
   /*  $que=$this->db->query("select * from tbl_genrate_referral_code_for_customer where device_id='".$device_id."' and mobile_no='".$mobile_no."'");
     $row = $que->num_rows();*/
    /* $res1 = $this->Customer->get_referral_code_for_customer($data2);*/

     /*$data->mobile_no  = $mobile_no;
     $data->device_id  = $device_id;
     $res = $this->Customer->get_referral_code($data);*/
     /*$customer_referral_code=$res1->customer_referral_code;
     if(!empty($customer_referral_code))
     {
        $referral_code=$res1->customer_referral_code;
     }
     else
     {
        $referral_code=$otpValue;
     }
     if(!empty($res1))
     {
        $data1->referal_code =$referral_code;
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
   }*/

    /*.......GPS moves customer latitude and longitude  Api ---- */
     /*.........get fixer registartion data by sales_id   Api For Fixer  ---- */
  public function banner_image_list_data_post()
    {
      $response   =   new StdClass();
      $result       =   array();
      $getdata       =  $this->db->where(['offer_status'=>'1'])
                        ->get('fixer_category')->result_array();

      if(!empty($getdata))
      {
        foreach ($getdata as $row)
      {
        $data=$row['category'];

      if($data==null)
      {
        $data='';
      }
      else
      {
        $data=$row['category'];
      }
      $data['sub_cat_id'] =   $data;
      $data['sub_cat_name'] =   $row['cat_name'];
      $data['cat_id']       =   $row['id'];
      $data['check_level_customer']   =   $row['check_level_customer'];
      $data['banner_image_url']   = base_url().'manage/hawker_offer_image/'.$row['show_offer_image']; 
      $data['status']   ='1';

      array_push($result,$data);
      } 
      $response->Api_status ='1';
      $response->title ='';
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

     /*........get fixer registartion data by sales_id  Api For Fixer  ---- */
   
  }
