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
    $data2['title1']='';
    $data2['id']    = $row4['master_cat_id'];
    $masterdata=$row4['master_cat_id'];
    $get_id_data_for_category = $this->Customer->get_id_data_for_category($masterdata);

    foreach ($get_id_data_for_category as $value) {
    
    $id=$value['id'];

    $subCat1 = $this->Customer->fetch_category(['cat_id'=>$value['master_cat_id'],'cus_id'=>$cus_id,'status'=>'1']);

     if(!empty($subCat1))
    {
      $data2['fav_status']='1';

    }
    else
   {
   $data2['fav_status']='0';
   } 
    $data2['cat_name']    = $row4['cat_name'];
   /* $data2['image_url']="http://192.168.0.77/Hawker/manage/catImages/".$row4['cat_icon_image'].""; */
    $data2['image_url']=base_url().'manage/catImages/'.$row4['cat_icon_image']; 
    $subCat = $this->Sales->getSubCategory(['category'=>$value['id']]);
    if(!empty($subCat))
    {
      $data2['sub_cat_status']='1';

    }
      else
     {
     $data2['sub_cat_status']='0';
     }
   }
      $data2['title1']='';
      $data2['check_level_customer']  =$row4['check_level_customer'];
      $data2['status']  ='1';
      array_push($result1,$data2);
        $response->Reddi = $result1;
     /* }*/
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
      $data['id']    = $row3['master_cat_id'];
      $subCat1 = $this->Customer->fetch_category(['cat_id'=>$row3['master_cat_id'],'cus_id'=>$cus_id,'status'=>'1']);

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
      $subCat = $this->Sales->getSubCategory(['category'=>$row3['master_cat_id']]);
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
      $data['id']    = $row_seasonal['master_cat_id'];
      $subCat1 = $this->Customer->fetch_category(['cat_id'=>$row_seasonal['master_cat_id'],'cus_id'=>$cus_id,'status'=>'1']);

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
      $subCat = $this->Sales->getSubCategory(['category'=>$row_seasonal['master_cat_id']]);
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

    $masterdata=$row['master_cat_id'];

    $get_sub_cat_id_data = $this->Customer->get_subcategory_data($masterdata);
    foreach ($get_sub_cat_id_data as $value)
    {
      $id=$value['id'];

    $data['id'] =   $row['master_sub_cat_id'];
    $subCat1 = $this->Customer->fetch_sub_category(['sub_cat_id'=>$row['master_sub_cat_id'],'cus_id'=>$cus_id,'status'=>'1']);

       if(!empty($subCat1))
      {
        $data['fav_status']='1';

      }
      else
     {
     $data['fav_status']='0';
     } 
   }
    $data['sub_cat_name'] =   $row['sub_cat_name'];
  /*  $data['image_url']="http://192.168.0.77/Hawker/manage/catImages/".$row['sub_cat_image']."";*/
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
    /*public function get_cat_data_post()
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
   }*/
      /*......... Get Category Api For Fixer  ---- */

   /*......... Get Validate CustomerUser Api For Fixer  ---- */
  /*public function Validate_active_customer_user_post()
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
*/
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
    //$radius=20;
    $city =$this->input->post('city');
   // $string=$latitudeFrom.'-'.$longitudeFrom;
   // $ch=fopen("test.txt","w");
   // fwrite($ch,$string);
   // fclose($ch);
	//print_r($cat_id);exit;
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

     $getcatdata = $this->Customer->get_cat_id_data($cat_id);

   /* foreach ($getcatdata as $valuedata) {
      $catdata=$valuedata['id'];
      */

     $array = array_column($getcatdata, 'id'); //Get an array of just the app_subject_id column
     $array = implode(',', $array); //creates a string of the id's separated by commas
     //print_r($array);exit;
     $getdata = $this->Customer->check_data_by_registerseller($array,$city);
      /*print_r($getdata);
     die();*/

    //$logdatalocation = $this->Customer->logdatalocation($logdata);
    $getcatdata = $this->Customer->customer_cat_data_for_fix($array);
   
    $cat_image=$getcatdata->cat_icon_image;
    $cat_icon_image_map=$getcatdata->cat_icon_image_map;
    $cat_data12=$getcatdata->cat_name;
    $image_url12=base_url().'manage/catImages/'.$cat_icon_image_map; 
   /* print_r($cat_icon_image_map);
    die();*/

  /*  }*/
  }
   else
   {
    $getsubcatdata = $this->Customer->get_subcat_id_data($sub_cat_id);
    $array = array_column($getsubcatdata, 'id'); //Get an array of just the app_subject_id column
    $array = implode(',', $array); //creates a string of the id's separated by commas

    $getdata = $this->Customer->check_data_by_registerseller1($array,$city);
    
    $getsubdata = $this->Customer->customer_sub_cat_data_fix($array);
    /* print_r($getsubdata);
     die();*/
     // $logdatalocation = $this->Customer->logdatalocation($logdata);
     $sub_cat_image_map=$getsubdata->sub_cat_image_map;
     $sub_cat_image=$getsubdata->sub_cat_image;
     $cat_data12=$getsubdata->sub_cat_name;
     $categoty_data12=$getsubdata->category;
    
     $image_url12=base_url().'manage/catImages/'.$sub_cat_image_map; 
   }
   if($sub_cat_id=='' or $sub_cat_id=='0')
   {
    $getcatdata = $this->Customer->get_cat_id_data($cat_id);
     $array = array_column($getcatdata, 'id'); //Get an array of just the app_subject_id column
     $array = implode(',', $array); //creates a string of the id's separated by commas

    $getdata1 = $this->Customer->check_data_by_registerseller2($array,$city);


    $getcatdata = $this->Customer->customer_cat_data_for_Moving($array);
    // $logdatalocation = $this->Customer->logdatalocation($logdata);
    $cat_image=$getcatdata->cat_icon_image;
     $cat_icon_image_map=$getcatdata->cat_icon_image_map;
    $cat_data=$getcatdata->cat_name;
    $image_url=base_url().'manage/catImages/'.$cat_icon_image_map; 
   }
   else
   {
      $getsubcatdata = $this->Customer->get_subcat_id_data($sub_cat_id);
      $array = array_column($getsubcatdata, 'id'); //Get an array of just the app_subject_id column
      $array = implode(',', $array); //creates a string of the id's separated by commas

     $getdata1 = $this->Customer->check_data_by_registerseller3($array,$city);
   /*  print_r($getdata1);
     die();*/

     $getsubdata = $this->Customer->customer_sub_cat_data_Moving($array);
      $sub_cat_image_map=$getsubdata->sub_cat_image_map;
     $logdatalocation = $this->Customer->logdatalocation($logdata);
     $sub_cat_image=$getsubdata->sub_cat_image;
     $cat_data=$getsubdata->sub_cat_name;
     $image_url=base_url().'manage/catImages/'.$sub_cat_image_map; 
   }
   if($sub_cat_id=='' or $sub_cat_id=='0')
    {
     $getcatdata = $this->Customer->get_cat_id_data($cat_id);
     $array = array_column($getcatdata, 'id'); //Get an array of just the app_subject_id column
     $array = implode(',', $array); //creates a string of the id's separated by commas

    $getdata_temp = $this->Customer->check_data_by_registerseller_temp_fix($array,$city);
    $logdatalocation = $this->Customer->logdatalocation($logdata);
    $getcatdata = $this->Customer->customer_cat_data_for_fix($array);
    $cat_image=$getcatdata->cat_icon_image;
    $cat_icon_image_map=$getcatdata->cat_icon_image_map;
    $cat_data=$getcatdata->cat_name;
    $image_url=base_url().'manage/catImages/'.$cat_icon_image_map; 
    }
   else
   {
     $getsubcatdata = $this->Customer->get_subcat_id_data($sub_cat_id);
     $array = array_column($getsubcatdata, 'id'); //Get an array of just the app_subject_id column
     $array = implode(',', $array); //creates a string of the id's separated by commas
     $getdata_temp = $this->Customer->check_data_by_registerseller1_temp_fix($array,$city);
     $getsubdata = $this->Customer->customer_sub_cat_data_fix($array);
     $logdatalocation = $this->Customer->logdatalocation($logdata);
     $sub_cat_image_map=$getcatdata->sub_cat_image_map;
     $sub_cat_image=$getsubdata->sub_cat_image;
     $cat_data=$getsubdata->sub_cat_name;
     $image_url=base_url().'manage/catImages/'.$sub_cat_image_map; 
   }
   if($sub_cat_id=='' or $sub_cat_id=='0')
    {
     $getcatdata = $this->Customer->get_cat_id_data($cat_id);
     $array = array_column($getcatdata, 'id'); //Get an array of just the app_subject_id column
     $array = implode(',', $array); //creates a string of the id's separated by commas

    $getdata_seasonal = $this->Customer->check_data_by_registerseller_seasonal_fix($array,$city);
    $logdatalocation = $this->Customer->logdatalocation($logdata);
    $getcatdata = $this->Customer->customer_cat_data_for_fix($array);
    $cat_image=$getcatdata->cat_icon_image;
    $cat_icon_image_map=$getcatdata->cat_icon_image_map;
    $cat_data=$getcatdata->cat_name;
    $image_url=base_url().'manage/catImages/'.$cat_icon_image_map; 
    }
   else
   {
     $getsubcatdata = $this->Customer->get_subcat_id_data($sub_cat_id);
     $array = array_column($getsubcatdata, 'id'); //Get an array of just the app_subject_id column
     $array = implode(',', $array); //creates a string of the id's separated by commas

     $getdata_seasonal = $this->Customer->check_data_by_registerseller1_seasonal_fix($array,$city);
     $getsubdata = $this->Customer->customer_sub_cat_data_fix($array);
      $logdatalocation = $this->Customer->logdatalocation($logdata);
       $sub_cat_image_map=$getsubdata->sub_cat_image_map;
     $sub_cat_image=$getsubdata->sub_cat_image;
     $cat_data=$getsubdata->sub_cat_name;
     $image_url=base_url().'manage/catImages/'.$sub_cat_image_map; 
   }
   if($sub_cat_id=='' or $sub_cat_id=='0')
    {
     $getcatdata = $this->Customer->get_cat_id_data($cat_id);
     $array = array_column($getcatdata, 'id'); //Get an array of just the app_subject_id column
     $array = implode(',', $array); //creates a string of the id's separated by commas

    $getdata_temp_moving = $this->Customer->check_data_by_registerseller_temp_moving($array,$city);
    $logdatalocation = $this->Customer->logdatalocation($logdata);
    $getcatdata = $this->Customer->customer_cat_data_for_Moving($array);
    $cat_image=$getcatdata->cat_icon_image;
    $cat_icon_image_map=$getcatdata->cat_icon_image_map;
    $cat_data=$getcatdata->cat_name;
    $image_url=base_url().'manage/catImages/'.$cat_icon_image_map; 
    }
   else
   {
     $getsubcatdata = $this->Customer->get_subcat_id_data($sub_cat_id);
     $array = array_column($getsubcatdata, 'id'); //Get an array of just the app_subject_id column
     $array = implode(',', $array); //creates a string of the id's separated by commas

     $getdata_temp_moving = $this->Customer->check_data_by_registerseller1_temp_moving($array,$city);
     $getsubdata = $this->Customer->customer_sub_cat_data_Moving($array);
      $logdatalocation = $this->Customer->logdatalocation($logdata);
     $sub_cat_image_map=$getsubdata->sub_cat_image_map;
      $sub_cat_image=$getsubdata->sub_cat_image;
     $cat_data=$getsubdata->sub_cat_name;
     $image_url=base_url().'manage/catImages/'.$sub_cat_image_map; 
   }

   if($sub_cat_id=='' or $sub_cat_id=='0')
    {
     $getcatdata = $this->Customer->get_cat_id_data($cat_id);
     $array = array_column($getcatdata, 'id'); //Get an array of just the app_subject_id column
     $array = implode(',', $array); //creates a string of the id's separated by commas

    $getdata_seasonal_moving = $this->Customer->check_data_by_registerseller_seasonal_moving($array,$city);
    $logdatalocation = $this->Customer->logdatalocation($logdata);
    $getcatdata = $this->Customer->customer_cat_data_for_Moving($array);
    $cat_image=$getcatdata->cat_icon_image;
    $cat_icon_image_map=$getcatdata->cat_icon_image_map;
    $cat_data=$getcatdata->cat_name;
    $image_url=base_url().'manage/catImages/'.$cat_icon_image_map; 
    }
   else
   {
     $getsubcatdata = $this->Customer->get_subcat_id_data($sub_cat_id);
     $array = array_column($getsubcatdata, 'id'); //Get an array of just the app_subject_id column
     $array = implode(',', $array); //creates a string of the id's separated by commas
     $getdata_seasonal_moving = $this->Customer->check_data_by_registerseller1_seasonal_moving($array,$city);
     $getsubdata = $this->Customer->customer_sub_cat_data_Moving($array);
      $logdatalocation = $this->Customer->logdatalocation($logdata);
       $sub_cat_image_map=$getsubdata->sub_cat_image_map;
     $sub_cat_image=$getsubdata->sub_cat_image;
     $cat_data=$getsubdata->sub_cat_name;
     

     $image_url=base_url().'manage/catImages/'.$sub_cat_image_map; 
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
      $data['name']   = ucwords($row['name']);
      $data['mobile_no']   = $row['mobile_no_contact'];
      $data['business_mobile_no']   = $row['business_mobile_no'];
      $mobile_no=$row['mobile_no_contact'];
      $data['image_url']=base_url().'assets/upload/profile_image/'.$mobile_no.".jpeg";
      $data['image_cat_url']=$image_url12;
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
      $data['cat_data']=$cat_data12;
      $hawker_code_data =$row['hawker_code'];

     $query = $this->db->query("SELECT AVG(review_point) as AVGRATE from tbl_review_for_hawker where hawker_code='$hawker_code_data'");
     $current_data=$query->result_array();
     $array = implode(',', $current_data[0]);

     if($array!='')
      {
         $arraydata=number_format($array,2);
      }
      else
      {
         $arraydata='0';
      }
     
     /* $average_rating_data = $this->Customer->average_rating_hawker($hawker_code_data);
       print_r($average_rating_data);
       die();*/
      if($categoty_data=='4')
      {
         $data['Show_status'] ='1';
      }
      else
      {
         $data['Show_status'] ='0';
      }
      $data['average_rating']=$arraydata;
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
       $hawker_code_data =$row_temp['hawker_code'];
       $query = $this->db->query("SELECT AVG(review_point) as AVGRATE from tbl_review_for_hawker where hawker_code='$hawker_code_data'");
     $current_data=$query->result_array();
     $array = implode(',', $current_data[0]);

     if($array!='')
      {
        $arraydata=number_format($array,2);
      }
      else
      {
        $arraydata='0';
      }

      $data['average_rating']=$arraydata;
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
      $hawker_code_data =$row_seasonal['hawker_code'];
      $query = $this->db->query("SELECT AVG(review_point) as AVGRATE from tbl_review_for_hawker where hawker_code='$hawker_code_data'");
     $current_data=$query->result_array();
     $array = implode(',', $current_data[0]);

     if($array!='')
      {
         $arraydata=number_format($array,2);
      }
      else
      {
        $arraydata='0';
      }

      $data['average_rating']=$arraydata;
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

      $hawker_code_data =$row1['hawker_code'];
      $query = $this->db->query("SELECT AVG(review_point) as AVGRATE from tbl_review_for_hawker where hawker_code='$hawker_code_data'");
     $current_data=$query->result_array();
     $array = implode(',', $current_data[0]);

     if($array!='')
      {
         $arraydata=number_format($array,2);
      }
      else
      {
         $arraydata='0';
      }

      $data1['average_rating']=$arraydata;
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
      $hawker_code_data =$row_temp_moving['hawker_code'];
      $query = $this->db->query("SELECT AVG(review_point) as AVGRATE from tbl_review_for_hawker where hawker_code='$hawker_code_data'");
     $current_data=$query->result_array();
     $array = implode(',', $current_data[0]);

     if($array!='')
      {
        $arraydata=number_format($array,2);
      }
      else
      {
        $arraydata='0';
      }

      $data1['average_rating']=$arraydata;
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
      $hawker_code_data =$row_seasonal_moving['hawker_code'];
      $query = $this->db->query("SELECT AVG(review_point) as AVGRATE from tbl_review_for_hawker where hawker_code='$hawker_code_data'");
     $current_data=$query->result_array();
     $array = implode(',', $current_data[0]);

     if($array!='')
      {
        $arraydata=number_format($array,2);
      }
      else
      {
         $arraydata='0';
      }

      $data1['average_rating']=$arraydata;
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
      //$url=$_SERVER['DOCUMENT_ROOT'].'/hawker/test.txt';
  
      //file_put_contents("test.txt","Hello");
      $response   =   new StdClass();
      $result       =  new StdClass();
      $mobile_no =$this->input->post('mobile_no');
      $customer_mobile_no =$this->input->post('mobile_no');
      $device_id =$this->input->post('device_id');
      $referal_code =$this->input->post('referal_code');
      $otp =$this->input->post('otp');
      $city =$this->input->post('city');
      $pincode =$this->input->post('pincode');
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
      if(preg_match("/^\d+\.?\d*$/",$referal_code) && strlen($referal_code)==10)
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
        else
        {
        $data2->device_id = $device_id;
        $data2->mobile_no = $mobile_no;
        $data2->customer_referral_code = $referal_code;
        $data1->city = $city;
        $data1->pincode = $pincode;

        $checkcitystatus = $this->Customer->get_city_data_amount($data1);
        $coupon_amount=$checkcitystatus->coupon_amount;

        $data2->date_time = $now;
        $data2->date=$nows;
        $data2->status = '1';
        $data2->referral_flag_status='1';
        //$data2->customer_point='100';
        $data2->customer_point=$coupon_amount;
        $data2->city = $city;
        $data2->pincode = $pincode;
        $fetch_referral_point_update=$this->Customer->fetch_update_status_referral_point($referal_code);
        $mobile_no=$fetch_referral_point_update->mobile_no;
        $referral_point=$fetch_referral_point_update->referral_point;
        $city=$fetch_referral_point_update->city;

        $pincode=$fetch_referral_point_update->pincode;

        $checkcitystatu = $this->Customer->get_city_data_amounts($city,$pincode);
        $coupon_amounts=$checkcitystatu->coupon_amount;
        /*print_r($city);
        die();*/
        
        //check
     $flag_status_update = $this->Customer->flag_status_update_for_customer($data2);
     
     $referral_point_update=$this->Customer->update_status_referral_point($referal_code,$mobile_no,$referral_point,$coupon_amount,$customer_mobile_no);
 
        }
        }
        $data->cus_id=$cus_id;
        $data->status = '1';
        $data->coupon = $coupon_amount;
        $data->ref_code = $referal_code;
        $data->mobile = $mobile;
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
       $data['id']    = $row1['master_cat_id'];  
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
       $data['id']    = $row2['master_sub_cat_id'];  
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
       $data['id']    = $row4['master_super_sub_cat_id'];  
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
    $banner_status=$this->input->post('banner_status');
   if(!empty($banner_status)&& $banner_status==1)
    {
        $data->banner_flag =1;
    }
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
      $OffreImage=$this->Customer->getOfferImages($mobile_no);
      if(!empty($OffreImage))
      {
        $data1['menu_image_url_1']=$OffreImage[0]['image_1'];
        $data1['menu_image_url_2']=$OffreImage[0]['image_2'];
      }else
      {
        $data1['menu_image_url_1']='';
        $data1['menu_image_url_2']='';
      }
      $menu_image_data = $this->Customer->get_menu_image_data($mobile_no);
      if(!empty($menu_image_data))
      {
      
      //$menu_image=$row['menu_image'];
       $menu_image=$menu_image_data->menu_image;
      if(!empty($menu_image))
      {
         $data1['menu_image_url_3']=$menu_image;
      }
      else
      {
        $data1['menu_image_url_3']="";
      }
      //$menu_image_2=$row['menu_image_2'];
       $menu_image_2=$menu_image_data->menu_image_2;
       if(!empty($menu_image_2))
      {
         $data1['menu_image_url_4']=$menu_image_2;
      }
      else
      {
        $data1['menu_image_url_4']="";
      }
      $menu_image_3=$row['menu_image_3'];
      $menu_image_3=$menu_image_data->menu_image_3;
      //$menu_image_4=$row['menu_image_4'];
      // $menu_image_4=$menu_image_data->menu_image_4;
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
     $getcatdata = $this->Customer->get_cat_id_data($cat_id);
     $array = array_column($getcatdata, 'id'); //Get an array of just the app_subject_id column
     $array = implode(',', $array); //creates a string of the id's separated by commas
     $getdata = $this->Customer->check_data_by_registerseller($array,$city);
    }
   else
   {
    $getsubcatdata = $this->Customer->get_subcat_id_data($sub_cat_id);
    $array = array_column($getsubcatdata, 'id'); //Get an array of just the app_subject_id column
    $array = implode(',', $array); //creates a string of the id's separated by commas
    $getdata = $this->Customer->check_data_by_registerseller1($array,$city);
   }
   if($sub_cat_id=='' or $sub_cat_id=='0')
   {
     $getcatdata = $this->Customer->get_cat_id_data($cat_id);
     $array = array_column($getcatdata, 'id'); //Get an array of just the app_subject_id column
     $array = implode(',', $array); //creates a string of the id's separated by commas

    $getdata1 = $this->Customer->check_data_by_registerseller2($array,$city);
   }
   else
   {
    $getsubcatdata = $this->Customer->get_subcat_id_data($sub_cat_id);
    $array = array_column($getsubcatdata, 'id'); //Get an array of just the app_subject_id column
    $array = implode(',', $array); //creates a string of the id's separated by commas
     $getdata1 = $this->Customer->check_data_by_registerseller3($array,$city);
   }
   if($sub_cat_id=='' or $sub_cat_id=='0')
    {
     $getcatdata = $this->Customer->get_cat_id_data($cat_id);
     $array = array_column($getcatdata, 'id'); //Get an array of just the app_subject_id column
     $array = implode(',', $array); //creates a string of the id's separated by commas
    $getdata_temp = $this->Customer->check_data_by_registerseller_temp_fix($array,$city);
    }
   else
   {
     $getsubcatdata = $this->Customer->get_subcat_id_data($sub_cat_id);
    $array = array_column($getsubcatdata, 'id'); //Get an array of just the app_subject_id column
    $array = implode(',', $array); //creates a string of the id's separated by commas
     $getdata_temp = $this->Customer->check_data_by_registerseller1_temp_fix($array,$city);
   }
   if($sub_cat_id=='' or $sub_cat_id=='0')
    {
     $getcatdata = $this->Customer->get_cat_id_data($cat_id);
     $array = array_column($getcatdata, 'id'); //Get an array of just the app_subject_id column
     $array = implode(',', $array); //creates a string of the id's separated by commas
    $getdata_seasonal = $this->Customer->check_data_by_registerseller_seasonal_fix($array,$city);
    }
   else
   {
     $getsubcatdata = $this->Customer->get_subcat_id_data($sub_cat_id);
    $array = array_column($getsubcatdata, 'id'); //Get an array of just the app_subject_id column
    $array = implode(',', $array); //creates a string of the id's separated by commas
     $getdata_seasonal = $this->Customer->check_data_by_registerseller1_seasonal_fix($array,$city);
   }
   if($sub_cat_id=='' or $sub_cat_id=='0')
    {
     $getcatdata = $this->Customer->get_cat_id_data($cat_id);
     $array = array_column($getcatdata, 'id'); //Get an array of just the app_subject_id column
     $array = implode(',', $array); //creates a string of the id's separated by commas
    $getdata_temp_moving = $this->Customer->check_data_by_registerseller_temp_moving($array,$city);
    }
   else
   {
     $getsubcatdata = $this->Customer->get_subcat_id_data($sub_cat_id);
    $array = array_column($getsubcatdata, 'id'); //Get an array of just the app_subject_id column
    $array = implode(',', $array); //creates a string of the id's separated by commas
     $getdata_temp_moving = $this->Customer->check_data_by_registerseller1_temp_moving($array,$city);
   }

   if($sub_cat_id=='' or $sub_cat_id=='0')
    {
       $getcatdata = $this->Customer->get_cat_id_data($cat_id);
     $array = array_column($getcatdata, 'id'); //Get an array of just the app_subject_id column
     $array = implode(',', $array); //creates a string of the id's separated by commas
    $getdata_seasonal_moving = $this->Customer->check_data_by_registerseller_seasonal_moving($array,$city);
    }
   else
   {
    $getsubcatdata = $this->Customer->get_subcat_id_data($sub_cat_id);
    $array = array_column($getsubcatdata, 'id'); //Get an array of just the app_subject_id column
    $array = implode(',', $array); //creates a string of the id's separated by commas
     $getdata_seasonal_moving = $this->Customer->check_data_by_registerseller1_seasonal_moving($array,$city);
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

    $quedata6=$this->db->query("select device_id from tbl_genrate_referral_code_for_customer where  device_id='".$device_id."'");

    $quedata7=$this->db->query("select device_id from tbl_genrate_referral_code_for_customer where mobile_no='".$customer_mobile."'");

    $quedata8=$this->db->query("select device_id from tbl_genrate_referral_code_for_customer where genrate_referral_code='".$referal_code."'");

     $quedata9=$this->db->query("select device_id from tbl_genrate_referral_code_for_customer where device_id='".$device_id."' and genrate_referral_code='".$referal_code."'  and referral_flag_status='1'");

    $row = $que->num_rows();
    $row1 = $quedata->num_rows();
    $row2 = $quedata1->num_rows();
    $row3 = $quedata2->num_rows();
    $row4 = $quedata3->num_rows();
    $row5 = $quedata4->num_rows();
    $row6 = $quedata5->num_rows();
    $row7 = $quedata6->num_rows(); 
    $row8 = $quedata7->num_rows();
    $row9 = $quedata8->num_rows();
    $row10 = $quedata9->num_rows();
  /*  $referral_code_data = $this->Customer->check_referral_code_data($data1);
*/
    $check_login_sellers = $this->Customer->check_login_seller_data($referal_code);
    $check_login_mobile_no=$check_login_sellers->mobile_no_contact;

    if(preg_match("/^\d+\.?\d*$/",$referal_code) && strlen($referal_code)==10)
    {
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
      if(empty($row9))
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

      else if($row10>0)
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

        else if($row7>0)
      {
        $data['referral_message'] = 'This device has already used a referral code.';
        $data['status']  ='2';
        array_push($result,$data);
        $response->data = $result;

      }

      else if($row8>0)
      {
        $data['referral_message'] = 'You have already use referral code.';
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

    public function genrate_referral_code_for_customers_post()
    {
     $response = new StdClass();
     $result = new StdClass();
     $device_id  = $this->input->post('device_id');
     $mobile_no  = $this->input->post('mobile_no');
     $referral_code=$this->input->post('referral_code');
     $city=$this->input->post('city');
     $pincode=$this->input->post('pincode');
     date_default_timezone_set('Asia/kolkata'); 
     $now = date('Y-m-d H:i:s');
     $nows = date('Y-m-d');
     $otpValue=substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 5);
     $data2->genrate_referral_code =$otpValue;

     $data2->mobile_no  = $mobile_no;
     $data2->device_id  = $device_id;
     $data2->city  = $city;
     $data2->pincode  = $pincode;
     $data2->referral_code=$referral_code;
     $data2->date_time =$now;
     $data2->date =$nows;
     $data2->status='1';
     $data2->referral_flag_status='0';
     $que=$this->db->query("select * from tbl_genrate_referral_code_for_customer where device_id='".$device_id."' and mobile_no='".$mobile_no."'");
     $res1 = $this->Customer->get_referral_code_for_customer($data2);

     $data->mobile_no  = $mobile_no;
     $data->device_id  = $device_id;
     $res = $this->Customer->get_referral_code($data);
     $customer_referral_code=$res1->genrate_referral_code;
    
     if(!empty($customer_referral_code))
     {
        $referral_code=$res1->genrate_referral_code;
     }
     else
     {
        $referral_code=$otpValue;
     }
     if(!empty($mobile_no))
     {
      $checkcitystatus = $this->Customer->get_city_data_amount($data2);
      $coupon_amount=$checkcitystatus->coupon_amount;

  
        $data1->referal_code =$referral_code;
        $data1->status ='1';
        $data1->message = 'Please join to earn '.$coupon_amount.' using my referral code';
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
     /*.........get fixer registartion data by sales_id   Api For Fixer  ---- */
  public function banner_image_list_data_post()
    {
      $response   =   new StdClass();
      $result       =   array();
      $getdata       =  $this->db->where(['offer_status'=>'1'])
                        ->order_by('create_date', 'DESC')
                        ->get('fixer_category')->result_array();
     /* $getdata1       =  $this->db->where(['status'=>'1'])
                        ->get('tbl_banner_show_image')->result_array();

*/
      if(!empty($getdata))
      {

        foreach ($getdata as $row)
      {
        $data=$row['category'];

      if($data==null)
      {
        $data1='';
      }
      else
      {
        $data1=$row['category'];
      }
      $data['sub_cat_id'] =   $data1;
      $data['sub_cat_name'] =   $row['cat_name'];
      $data['cat_id']       =   $row['master_cat_id'];
      $data['web_link']   =  $row['link'];
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

     /*new api for wallet screen(count and show amount)*/

    public function count_customer_refferal_amount_post()
    {
      $response = new StdClass();
      $result = new StdClass();
      $mobile_no = $this->input->post('mobile_no');
      date_default_timezone_set('Asia/kolkata'); 
      $now = date('Y-m-d');
      //$this->db->select_sum('customer_point');
      $query = $this->db->where('mobile_no',$mobile_no)->get('tbl_genrate_referral_code_for_customer');

       if($query->num_rows()>0){
      
          $sum = $query->result();
           $point= 0; 
           foreach ($sum as $value) {
            //$point = $point + $value->customer_point;
               $customer_point = $value->customer_point;
               $referral_point = $value->referral_point;
               $point = $point + $value->total_point;
             
           }
                  if ($referral_point==0) {
                 $response = array('coupon_amount' => $customer_point, "status" => 1, "message"=>"success");
                                          }
                  else
                  {
                 $response = array('coupon_amount' => $point, "status" => 1, "message"=>"success");
                  }
          
       }else{
        $response = array('coupon_amount' => $point, "status" => 0, "message"=>"failed");
          }
       $new = array( 'data' => $response);
       print json_encode($new);
    }   
  /*new api for wallet screen(count and show amount)*/


     /*.........count_hawker_referral_code ---- */

     public function count_customer_referral_data_post()
     {
     $response = new StdClass();
     $result = new StdClass();
     $mobile_no = $this->input->post('mobile_no');
     //$money='100';
     date_default_timezone_set('Asia/kolkata'); 
     $now = date('Y-m-d');
     
     $query=$this->db->query("select * FROM tbl_genrate_referral_code_for_customer where mobile_no='$mobile_no' and referral_flag_status='1' and limit_status!='1'");
      
      $array = implode(',', $current_data[0]);

      $array1 = implode(',', $current_data1[0]);

      if($array!='')
      {
        $arraydata=$array;
      }
      else
      {
        $arraydata='0';
      }
      if($array1!='')
      {
         $arraydata1=$array1;
      }
      else
      {
        $arraydata1='0';
      }
      
    /* $num_rows=$query->num_rows();*/
     if($mobile_no!='')
      {
      $data1->count =$arraydata+$arraydata1;
      $data1->status = '1';
      $data1->message = 'success';
      array_push($result,$data1);
      $response->data = $data1;
      }
      else
      {
        $data1->count =$num_rows;
      $data1->status ='0';
      $data1->message = 'failed';
       array_push($result,$data1);
        $response->data = $data1;
      }

    echo json_output($response);
   }

    /*......count_hawker_referral_code  ---- */

   public function request_customer_referral_data_post()
   {
     $response = new StdClass();
     $result = new StdClass();
     $mobile_no  = $this->input->post('mobile_no');
     $customer_point  = $this->input->post('customer_point');
     $type  = $this->input->post('type');
     $amount  = $this->input->post('amount');
     date_default_timezone_set('Asia/kolkata'); 
     $now = date('Y-m-d H:i:s');
     $data->mobile_no  = $mobile_no;
     $data->customer_point  = $customer_point;
     $data->type  = $type;
     //$data->amount  = $amount;
     $data->date_time = $now;
     $data->status='1';
     $data1->type  = $type;
     $data1->customer_point = $customer_point;
    
     $type=$resdata->type;
     $amount=$resdata->Amount;
     
     $data->coupon_code=$coupon_code;
     if(!empty($resdata))
     {
       $res = $this->Customer->request_customer_referral_money_data($data);
      }
     
     if(!empty($res))
      {
       $data2->type =$type;
      // $data2->Amount =$amount;
       $data2->coupon_code =$coupon_code;
       $data2->expire_date =$expire_date;
       $data2->status ='1';
       $data2->message = 'success';
      array_push($result,$data2);
      $response->data = $data2;
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

   /*.........get fixer registartion data by sales_id   Api For Fixer  ---- */
     public function coupon_list_data_post()
    {
      $response   =   new StdClass();
      $result       =   array();

       $getdata  = $this->db->distinct()
                  ->select('type')
                  ->from("tbl_referral_coupon_code")
                  ->get()->result_array();

     /* $getdata       =  $this->db->where(['status'=>'1'])
                        ->get('tbl_referral_coupon_code')->result_array();*/

      if(!empty($getdata))
      {
        foreach ($getdata as $row)
      {
        
      $data['type'] =   $row['type'];
     // $data['amount']       =   $row['Amount'];
      //$data['create_date']   =   $row['create_date'];
      $data['status']   ='1';

      array_push($result,$data);
      } 
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

      
     /*........Resent Search Customer for hawker  ---- */

    public function resent_search_hawker_for_customer_data_post()
    {
     $response = new StdClass();
     $result = new StdClass();
     $cus_id  = $this->input->post('cus_id');
     $hawker_code  = $this->input->post('hawker_code');
     $device_id  = $this->input->post('device_id');
     $name  = $this->input->post('name');
     $search_cat_name=$this->input->post('search_cat_name');
     $mobile_no  = $this->input->post('mobile_no');
     $cat_id  = $this->input->post('cat_id');
     $sub_cat_id=$this->input->post('sub_cat_id');
     $super_sub_cat_id=$this->post('super_sub_cat_id');
     date_default_timezone_set('Asia/kolkata'); 
     $now = date('Y-m-d H:i:s');
     $data->cus_id  = $cus_id;
     $data->hawker_code  = $hawker_code;
     $data->device_id  = $device_id;
     $data->name  = $name;
     $data->search_cat_name  = $search_cat_name;
     $data->mobile_no  = $mobile_no;
     $data->cat_id  = $cat_id;
     $data->sub_cat_id  = $sub_cat_id;
     $data->super_sub_cat_id  = $super_sub_cat_id;
   
     $data->create_date = $now;
     $data->status='1';
     $res = $this->Customer->resent_search_hawker($data);
   
     if(!empty($mobile_no))
      {
       
       $data2->name=$name;
       $data2->status ='1';
       $data2->message = 'success';
      array_push($result,$data2);
      $response->data = $data2;
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
    /*........Resent Search Customer for hawker  ---- */

     /*.........get recent search data for hawker ---- */
     public function list_for_search_hawker_post()
    {
      $response   =   new StdClass();
      $result       =   array();
      $device_id  = $this->input->post('device_id');
      $cus_id  = $this->input->post('cus_id');
      $getdata  =  $this->db
                  ->select('*')
                  ->from("tbl_customer_top_search_hawker")
                  ->where(['device_id'=>$device_id,'status'=>'1'])
                   ->order_by('create_date', 'DESC')
                   ->limit('10')
                  ->get()->result_array();

      if(!empty($getdata))
      {
        foreach ($getdata as $row)
      {

       $cat_id=$row['cat_id'];
       $sub_cat_id=$row['sub_cat_id'];

       if(empty($sub_cat_id))
       {
         $getdata1  =  $this->db->distinct()
                  ->select('cat_icon_image')
                  ->from("fixer_category")
                  ->where(['master_cat_id'=>$cat_id])
                   ->limit('10')
                  ->get()->result_array();

       }
       else
       {
        $getdata1  =  $this->db->distinct()
                  ->select('sub_cat_image')
                  ->from("fixer_sub_category")
                  ->where(['master_sub_cat_id'=>$sub_cat_id])
                   ->limit('10')
                  ->get()->result_array();
       }
       foreach ($getdata1 as $row1)
      {


       if(empty($sub_cat_id))
       {
        $image_url=$row1['cat_icon_image'];
       }
       else
       {
         $image_url=$row1['sub_cat_image'];
       }
      $image_url_data=base_url().'manage/catImages/'.$image_url; 
       
        
      $data['hawker_code'] =   $row['hawker_code'];
      $data['name']   =   $row['name'];
      $data['cat_id']       =   $row['cat_id'];
      $data['cat_image_url']       =   $image_url_data;
      $data['search_cat_name']       =   $row['search_cat_name'];
      $data['sub_cat_id']       =   $row['sub_cat_id'];
      $data['super_sub_cat_id']       =   $row['super_sub_cat_id'];
      $mobilieNo=$this->Customer->getMobileNo($data['hawker_code']);
      $data['mobile_no']  =   $mobilieNo;
      $data['create_date']  =   $row['create_date'];
      $data['status']   ='1';

      array_push($result,$data);
      } 
    }
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

     /*........get recent search data for hawker ---- */

      /*........Resent Search Customer for hawker  ---- */

    public function review_for_hawker_by_customer_post()
    {
     $response = new StdClass();
     $result = new StdClass();
     $hawker_code  = $this->input->post('hawker_code');
     $hawker_name  = $this->input->post('hawker_name');
     $device_id  = $this->input->post('device_id');
     $review_point  = $this->input->post('review_point');
     $cus_id  = $this->input->post('cus_id');
     $customer_mobile_no  = $this->input->post('customer_mobile_no');
     date_default_timezone_set('Asia/kolkata'); 
     $now = date('Y-m-d H:i:s');
     $data->hawker_code  = $hawker_code;
     $data->cus_id  = $cus_id;
     $data->device_id  = $device_id;
     $data->review_point  = $review_point;
     $data->hawker_name  = $hawker_name;
     $data->customer_mobile_no  = $customer_mobile_no;
     $data->create_date = $now;
     $data->status='1';
     $res = $this->Customer->review_for_hawker_customer($data);
   
     if(!empty($customer_mobile_no))
      {
       
       $data2->status ='1';
       $data2->message = 'success';
      array_push($result,$data2);
      $response->data = $data2;
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
    /*........Resent Search Customer for hawker  ---- */

    
     /*........get customer apply coupun code data ---- */

      
   function getNearByhawker_POST()
   {
    $lat1=$this->input->post('cust_latitude');
    $lon1=$this->input->post('cust_longitude');
    if(!empty($lat1) && !empty($lon1))
    {
     $staticResult=$this->Customer->getStaticImage();
    $result=$this->Customer->getMerchant();
    $finalResult = [];
  
    for($i=0;$i<count($result);$i++)
    {
        $lat2=$result[$i]['shop_latitude'];
        $lon2=$result[$i]['shop_longitude'];
        
        $distance=calculateDistance($lat1, $lon1, $lat2, $lon2);
        // echo '<br>';echo $distance;
        if($distance <= 3000)
        {
            $hawker_code=$result[$i]['hawker_code'];
            $ads_id=$result[$i]['ads_id'];
            $imgResult=$this->Customer->getNearByMerchantImages($hawker_code,$ads_id);
            if(!empty($imgResult))
            {   
                $temp_arr = $imgResult[0];
                $temp_arr['hawker_code'] = $hawker_code;
                $finalResult[] = $temp_arr;
            }
         }
      }
       if(!empty($finalResult))
       {
            $arry=array('status'=>'1','data'=>$finalResult);
            $this->response($arry, 200);
       }else
       {    
            $arry=array('status'=>'0','Message'=>'No Nearby Offer Found');
            $this->response($arry, 200);
       }
    } else
    {
        $arry=array('status'=>'0','data'=>'No Nearby Offer Found');
        $this->response($arry, 200);
    }

   }
      
   function getNearByhawkerOld_POST()
   {
    $lat1=$this->input->post('cust_latitude');
    $lon1=$this->input->post('cust_longitude');
    if(!empty($lat1) && !empty($lon1))
    {
     $staticResult=$this->Customer->getStaticImage();
    $result=$this->Customer->getMerchant();
    $finalResult = [];
    foreach ($staticResult as $key) {

        $temp_arr1['banner_img'] =base_url()."manage/nonClickableImages/".$key['banner_img'];
        $temp_arr1['paid_title'] ='';
        $temp_arr1['paid_advertisement'] ='';
        $temp_arr1['ads_id'] ='';
        $temp_arr1['hawker_code'] ='';

        $finalResult[] = $temp_arr1;
      }

    for($i=0;$i<count($result);$i++)
    {
        $lat2=$result[$i]['shop_latitude'];
        $lon2=$result[$i]['shop_longitude'];
        
        $distance=calculateDistance($lat1, $lon1, $lat2, $lon2);
        // echo '<br>';echo $distance;
        if($distance <= 3000)
        {
            $hawker_code=$result[$i]['hawker_code'];
            $ads_id=$result[$i]['ads_id'];
            $imgResult=$this->Customer->getNearByMerchantImages($hawker_code,$ads_id);
            if(!empty($imgResult))
            {   
                $temp_arr = $imgResult[0];
                $temp_arr['hawker_code'] = $hawker_code;
                $finalResult[] = $temp_arr;
            }
         }
      }
       if(!empty($finalResult))
       {
            $arry=array('status'=>'1','data'=>$finalResult);
            $this->response($arry, 200);
       }else
       {    
            $arry=array('status'=>'0','Message'=>'No Nearby Offer Found');
            $this->response($arry, 200);
       }
    } else
    {
        $arry=array('status'=>'0','data'=>'No Nearby Offer Found');
        $this->response($arry, 200);
    }

   }

// This fun is used for showing offer images on click banner for ads in customer app
public  function getMerchnatImage_post()
    {
           try
      {
      $hawker_code=$this->input->post('hawker_code');
      $ads_id=$this->input->post('ads_id');

      if(!empty($hawker_code))
      {
        $checkMerchant=$this->Customer->checkMerchant($hawker_code);
        if(!empty($checkMerchant))
        {
            $result=$this->Customer->getMerchantImage($hawker_code,$ads_id);
             //print_r($result);exit;
            if(!empty($result))
            {   
              $result_array=array(
                      'status'  =>'1',
                      'latitude' =>$result[0]['shop_latitude'],
                      'longitude' =>$result[0]['shop_longitude'],
                      'image_1' =>$result[0]['image_1'],
                      'image_2' =>$result[0]['image_2'],
                      'image_3' =>$result[0]['image_3'],
                      'image_4' =>$result[0]['image_4'],
                      'banner_img'=>$result[0]['banner_img'],
		                  'mobile_no'=>$result[0]['mobile_no'],
                      'title'   =>$result[0]['advertisement_title'],
                      'detail'   =>$result[0]['detail_of_advertisement']
                      );
              $res_array['data']=$result_array;
              $this->response($res_array, 200);
            }else
            {
                $res_array['data']=array('status'=>'0','message'=>'failed');
                $this->response($res_array, 200);
            }
           }else
           {
                $res_array['data']=array('status'=>'0','message'=>'Please register merchant');
                $this->response($res_array, 200);
           }
        

      }else
      {
        $res_array['data']=array('status'=>'0','message'=>'failed');
        $this->response($res_array, 200);
      }
}

      //Handling Exception in case problem of network or data loading
      catch (Exception $e){
                        echo $e->getMessage();
                        $error = array('status' =>'0', "message" => "Internal Server Error - Please try Later.","StatusCode"=> "HTTP405");
                        $this->response($error, 200);
                }

    }


    public function redeemCouponCode_post()
    {

      try
      {
	date_default_timezone_set('Asia/kolkata');
        $device_id        =$this->input->post('device_id');
        $mobile_no        =$this->input->post('mobile_no');
        $amount           =$this->input->post('amount');
	$cust_id          =$this->input->post('cust_id');
 	$checkAmount=$this->Customer->getRedeemAmount($mobile_no);
        //echo $checkAmount;exit;
	if($checkAmount > 9999999)
        {
            $res_array['data']=array('status'=>'0','message'=>'Coupan amount exceeded.You can redeem only 2000.00 points in a month');
            $this->response($res_array, 200);
        }else{
        if($amount % 100==0 && $amount >=100)
        {
          if(!empty($device_id) && !empty($mobile_no) && $amount >0)
          {

            $redeem_amount=$this->Customer->getRedeemData($mobile_no);
            //print_r($redeem_amount);exit;
            if($redeem_amount < $amount)
            {
              $res_array['data']=array('status'=>'0','message'=>'You have not enough amount');
              $this->response($res_array, 200);
            }else
            {
              $remaining_amount=$redeem_amount-$amount;
              $affected_rows=$this->Customer->updateRedeemData($mobile_no,$remaining_amount);
              if($affected_rows)
              {
                $reddemArray=array(
                                  'device_id'=>$device_id,
                                  'mobile_no'=>$mobile_no,
                                  'amount'=>$amount,
				  'cust_id'=>$cust_id,
				  'redeem_req_status'=>'Pending',
                                  'created_on'=>date('Y-m-d H:i:s')

                                );
                $response=$this->Customer->insertRedeemRequest($reddemArray);
                // print_r($response);exit;
                if($response)
                {
                   $res_array['data']=array('status'=>'1','message'=>'success');
                    $this->response($res_array, 200);
                }else
                {
                   $res_array['data']=array('status'=>'0','message'=>'failed');
                   $this->response($res_array, 200);
                }
              }else
              {
                  $res_array['data']=array('status'=>'0','message'=>'failed');
                  $this->response($res_array, 200);
              }

            }

          }else
          {
            $res_array['data']=array('status'=>'0','message'=>'failed');
            $this->response($res_array, 200);
          }
          }else
          {
            $res_array['data']=array('status'=>'0','message'=>'Amount should be multiple of hundred');
            $this->response($res_array, 200);
          }

      }
}catch(Exception $e)
      {
        echo $e->getMessage();
        $error = array('status' =>'0', "message" => "Internal Server Error - Please try Later.","StatusCode"=> "HTTP405");
                        $this->response($error, 200);

      }


    }
    public function getFreeAdvertisement_post()
    {
    try{

      $lat1=$this->input->post('cust_latitude');
      $lon1=$this->input->post('cust_longitude');
      if(!empty($lat1) && !empty($lon1))
      {
         $finalResult=$this->Customer->getFreeMerchant($lat1,$lon1);
    // echo '<pre>'; print_r($finalResult);
      if(!empty($finalResult))
         {
              $arry=array('status'=>'1','data'=>$finalResult);
              $this->response($arry, 200);
         }else
         {    
              $arry=array('status'=>'0','data'=>$finalResult);
              $this->response($arry, 200);
         }
      }else
      {
          $arry=array('status'=>'0','data'=>$finalResult);
          $this->response($arry, 200);
      }
     
    }catch (Exception $e)
    {
        echo $e->getMessage();
        $error = array('status' =>'0', "message" => "Internal Server Error - Please try Later.","StatusCode"=> "HTTP405");
        $this->response($error, 200);
    }
  }
  public function getHawkerImages_post()
  {

    try
    {
        $hawker_code=$this->input->post('hawker_code');
        
        if(!empty($hawker_code))
        {


            $result=$this->Customer->getFreeHawkerImages($hawker_code);
            if(!empty($result))
            {
              $arry=array('status'=>'1','data'=>$result);
              $this->response($arry, 200);

            }else
            {
              $arry=array('status'=>'0','data'=>'failed');
              $this->response($arry, 200);
            }


        }else
        {
           $arry=array('status'=>'0','data'=>'failed');
            $this->response($arry, 200);
        }
      
    }catch (Exception $e)
    {
        echo $e->getMessage(); 
        $error = array('status' =>'0', "message" => "Internal Server Error - Please try Later.","StatusCode"=> "HTTP405");
        $this->response($error, 200);
    }

  }
  public function getCouponCode_post()
  {
   
    try
    {

      $mobile_no=$this->input->post('mobile_no');
      $cust_id=$this->input->post('cust_id');
      if(!empty($mobile_no) && !empty($cust_id))
      {
                $response=$this->Customer->getCouponCode($mobile_no,$cust_id);
              if(!empty($response))
              {
                $arry=array('status'=>'1','data'=>$response);
                $this->response($arry, 200);

            }else
                  {
                     $arry=array('status'=>'0','data'=>'failed');
                      $this->response($arry, 200);
                  }

      }else
      {
        $arry=array('status'=>'0','data'=>'failed');
        $this->response($arry, 200);
      }

    }
    catch (Exception $e)
    {
      echo $e->getMessage();
      $error = array('status' =>'0', "message" => "Internal Server Error - Please try Later.","StatusCode"=> "HTTP405");
      $this->response($error, 200);
    }
  }
 public function getParameter_get()
    {
        try
        {

          $result=$this->Customer->getParameter();
          if(!empty($result))
          {

           $arry=array('status'=>'1','data'=>$result);
           $this->response($arry, 200);
          }else
          {
             $arry=array('status'=>'0','data'=>'failed');
            $this->response($arry, 200);
          }

        }catch(Exception $e)
        {
          echo $e->getMessage();
          $error = array('status' =>'0', "message" => "Internal Server Error - Please try Later.","StatusCode"=> "HTTP405");
          $this->response($error, 200);
        }
    }
public function getBannerCategory_get()
{
  try
  {

    $result=$this->Customer->getBannerCategory();

    // $cat_data=arrya();
    // echo '<pre>';print_r($result);exit;x
    if(!empty($result))
    {
            foreach($result as $key)
            {
                $temp_arr['cat_icon_image']=base_url()."manage/catImages/".$key['cat_icon_image'];
                $temp_arr['cat_name']=$key['cat_name'];
                $temp_arr['type']=$key['type'];
		 $temp_arr['id']=$key['id'];
		 $temp_arr['status']=$key['status'];
		//$temp_arr['hawker_code']=$key['hawker_code'];
                $finalResult[]=$temp_arr;
            }
           $arry=array('status'=>'1','data'=>$finalResult);
           $this->response($arry, 200);

    }else
    {
            $arry=array('status'=>'0','data'=>'failed');
            $this->response($arry, 200);
    }

  }catch(Exception $e)
  {
          echo $e->getMessage();
          $error = array('status' =>'0', "message" => "Internal Server Error - Please try Later.","StatusCode"=> "HTTP405");
          $this->response($error, 200);
  }
}
public function getRestroNearByMerchant_post()
    {

      try
      {

          $latitude     =$this->input->post('cust_latitude');
          $langitude    =$this->input->post('cust_longitude');
          $type_id      =$this->input->post('id');
          // $status       =$this->input->post('status');
          if(!empty($latitude) && !empty($langitude) && !empty($type_id))
          {
            $response=$this->Customer->getNearByMerchant($latitude, $langitude,$type_id);
             
              if(!empty($response))
              {
                 $arry=array('status'=>'1','data'=>$response);
                 $this->response($arry, 200);
              }else
              {
                   $arry=array('status'=>'0','data'=>'failed');
                   $this->response($arry, 200);
              }

          }else
          {
             $arry=array('status'=>'0','data'=>'failed');
             $this->response($arry, 200);
          }

      }catch(Exception $e)
        {
          echo $e->getMessage();
          $error = array('status' =>'0', "message" => "Internal Server Error - Please try Later.","StatusCode"=> "HTTP405");
          $this->response($error, 200);
        }
    }

public function getCoupanAmount_post()
    {
      
       try{

        $city_name=$this->input->post('city');
        $pincode=$this->input->post('sPin');
        // $data=array();
        $data->city=$city_name;
        $data->pincode=$pincode;

        if(!empty($data))
        {

          $result=$this->Customer->getCityData($data);
          if(!empty($result))
          {
              $arry=array('status'=>'1','data'=>$result);
              $this->response($arry, 200);

          }else{
              $arry=array('status'=>'0','data'=>'failed');
              $this->response($arry, 200);
          }
          

        }else
        {
                   $arry=array('status'=>'0','data'=>'failed');
                   $this->response($arry, 200);
        }


      }catch(Exception $e)
        {
          echo $e->getMessage();
          $error = array('status' =>'0', "message" => "Internal Server Error - Please try Later.","StatusCode"=> "HTTP405");
          $this->response($error, 200);
        }


    }

   function calculatDistance_POST()
   {
   
    $lat1=$this->input->post('cust_latitude');
    $lon1=$this->input->post('cust_longitude');
    $from=$this->input->post('from');
    $to=$this->input->post('to');
    $sales_id=$this->input->post('sales_id');
    $sum=0;
    if(!empty($lat1) && !empty($lon1))
    {
    $result=$this->Customer->getMerchantForDistance($from,$to,$sales_id);
    //print_r($result);exit;
    for($i=0;$i<count($result);$i++)
    {
        $lat2[]=$result[$i]['shop_latitude'];
        $lon2[]=$result[$i]['shop_longitude'];
     }

    for($j=0;$j<count($lat2)-1;$j++)
    {
      $distance=calculateDistanceNew($lat2[$j], $lon2[$j], $lat2[$j+1], $lon2[$j+1]);
      $sum=$sum+$distance;
     // echo $distance.'<br>'; 
   }
 // exit;
       if(!empty($sum))
       {
            $arry=array('status'=>'1','data'=>$sum);
            $this->response($arry, 200);
       }else
       {    
            $arry=array('status'=>'0','Message'=>'No Record found');
            $this->response($arry, 200);
       }
    } else
    {
        $arry=array('status'=>'0','data'=>'No Record found');
        $this->response($arry, 200);
    }

   }

   public function saveFixerCategoryCountRecord_POST()
   {
    try{

      $cus_id             =$this->input->post('cus_id');
      $notification_id    =$this->input->post('notification_id');
      $cat_id             =$this->input->post('cat_id');
      $sub_cat_id         =$this->input->post('sub_cat_id');
      $super_cat_id       =$this->input->post('super_cat_id');
      $creation_date      =date('Y-m-d');

      if(!empty($cus_id) && !empty($cat_id ))
      {

        $arrayData=array(

                        'cus_id'=>$cus_id,
                        'notification_id'=>$notification_id,
                        'cat_id'=>$cat_id,
                        'sub_cat_id'=>$sub_cat_id,
                        'super_cat_id'=>$super_cat_id,
                        'creation_date'=>$creation_date
                      );
       $response=$this->Customer->saveFixerCategoryCountRecord($arrayData);

       if($response)
       {
            $arry=array('status'=>'1','data'=>'success');
            $this->response($arry, 200);
       }else
       {
            $arry=array('status'=>'1','data'=>'failed');
            $this->response($arry, 200);
       }

      }else
      {
        $arry=array('status'=>'0','data'=>'Something went wrong');
        $this->response($arry, 200);
      }

    }catch( Exception $e)
    {
          echo $e->getMessage();
          $error = array('status' =>'0', "message" => "Internal Server Error - Please try Later.","StatusCode"=> "HTTP405");
          $this->response($error, 200);
    }
   }
}
