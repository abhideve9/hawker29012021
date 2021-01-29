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

  /*......... Login Api For sales Hawker ---- */
     public function login_post()
     {
        $response = new StdClass();
        $result = new StdClass();
        $mobile_no = $this->input->post('mobile_no');
        $device_id=$this->input->post('device_id');
        $notification_id=$this->input->post('notification_id');
        date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
        $this->db
            ->select('*');
            $this->db->from("registration_sales");
            $this->db->where(['mobile_no'=>$mobile_no]);
            $query=$this->db->get();
            $num_rows=$query->num_rows();
            $current_data=$query->result_array();
            $data1->device_id = $device_id;
            $data1->notification_id = $notification_id;
            $data1->login_time=$now;
            if(!empty($mobile_no))
            {
             if(!empty($current_data))
            {
             foreach ($current_data as $row)
            {
                
              if($row['active_status']=='1')
            {
              $otpValue=mt_rand(1000, 9999);
              $data1->device_id = $device_id;
              $data1->notification_id = $notification_id;
              $data1->login_time=$now;
              $data1->name=$row['name'];
              $data1->mobile_no=$row['mobile_no'];
              $data1->sales_id=$row['sales_id'];
              $data1->otp=$otpValue;
              $data2->sales_id=$row['sales_id'];
              $res = $this->Sales->addRegistrationSaleData($data1);
              $res1 = $this->Sales->check_login_validate_data($data2);
              $device_id1=$res1->device_id;
              if($device_id1!=$device_id)
              {

              $data['status']  ='3';
              array_push($result,$data);
              }
              else
              {
              $res3 = $this->Sales->send_otp($mobile_no,$otpValue);
              if($res3!='')
              {
              $res4 = $this->Sales->otpgetdata($data1);
              }
              $data['id'] =  $row['sales_id'];
              $data['name'] =  $row['name'];
              $data['active_status']='1';
              $data['type']=$row['type'];
              $data['status']  ='1';
              array_push($result,$data);
              }
             }
            else
            {
              $data['active_status']='0';
              $data['type']=$row['type'];
              $data['status']  ='1';
              array_push($result,$data);
            }
          
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
        
      /*.........Login Api For sales  Hawker ---- */

        /*.........seller Registration  Api  ---- */
    public function registration_seller_post()
    {   
        $response = new StdClass();
        $result2 = new StdClass();
        $name=$this->input->post('name');
        $gender=$this->input->post('gender');
        $name_type=$this->input->post('name_type');
        $other_detail=$this->input->post('other_detail');
        $user_type=$this->input->post('user_type');
        $hawker_sub_type=$this->input->post('hawker_sub_type');
        $other_sub_hawker_type=$this->input->post('other_sub_hawker_type');
        $seasonal_temp_hawker_type=$this->input->post('seasonal_temp_hawker_type');
        $if_seasonal_other_business_detail=$this->input->post('if_seasonal_other_business_detail');
        $address=$this->input->post('address');
        $phone_type=$this->input->post('phone_type');
        $mobile_no_contact=$this->input->post('mobile_no_contact');
        $mobile_no_type=$this->input->post('mobile_no_type');
        $has_smart_phone=$this->input->post('has_smart_phone');
        $other_service_type=$this->input->post('other_service_type');
        $business_name=$this->input->post('business_name');
        $business_start_time=$this->input->post('business_start_time');
        $business_close_time=$this->input->post('business_close_time');
        $shop_name=$this->input->post('shop_name');
        $business_address=$this->input->post('business_address');
        $hawker_register_address=$this->input->post('hawker_register_address');
        $city_address=$this->input->post('city_address');
        $is_it_seasonal=$this->input->post('is_it_seasonal');
        $city=$this->input->post('city');
        $device_id=$this->input->post('device_id');
        $state=$this->input->post('state');
        $business_mobile_no=$this->input->post('business_mobile_no');

        $cat_id=$this->input->post('cat_id');
        $sub_cat_id=$this->input->post('sub_cat_id');
        $super_sub_cat_id=$this->input->post('super_sub_cat_id');
        

        $menu_image_latitude=$this->input->post('menu_image_latitude');
        $menu_image_longitude=$this->input->post('menu_image_longitude');
        //Image latitude and longitude
        $profile_image_latitude=$this->input->post('profile_image_latitude');
        $profile_image_longitude=$this->input->post('profile_image_longitude');  
        $aadhar_card_image_latitude=$this->input->post('aadhar_card_image_latitude'); 
        $aadhar_card_image_longitude=$this->input->post('aadhar_card_image_longitude'); 
        $address_proof_image_latitude=$this->input->post('address_proof_image_latitude'); 
        $address_proof_image_longitude=$this->input->post('address_proof_image_longitude'); 
        $shop_image_1_latitude=$this->input->post('shop_image_1_latitude'); 
        $shop_image_1_longitude=$this->input->post('shop_image_1_longitude'); 
        $shop_image_2_latitude=$this->input->post('shop_image_2_latitude'); 
        $shop_image_2_longitude=$this->input->post('shop_image_2_longitude');
        //Image latitude and longitude 
        $gst_no=$this->input->post('gst_no'); 
        $day_of_duty=$this->input->post('day_of_duty');
        $start_date=$this->input->post('start_date');
        $end_date=$this->input->post('end_date');
        $shop_gps_id=$this->input->post('shop_gps_id'); 
        $shop_latitude=$this->input->post('shop_latitude');
        if($shop_latitude=='0.0')
        {
           $shop_latitude=$this->input->post('shop_image_1_latitude'); 
        }
        else
        {
           $shop_latitude=$this->input->post('shop_latitude');
        }
        $shop_longitude=$this->input->post('shop_longitude');  
        if($shop_longitude=='0.0')
        {
            $shop_longitude=$this->input->post('shop_image_1_longitude'); 
        }
        else
        {
            $shop_longitude=$this->input->post('shop_longitude');
        }
        $application_type=$this->input->post('application_type');
        $verification_by_call=$this->input->post('verification_by_call');
        $sales_id=$this->input->post('sales_id');
        $other_mobile_type=$this->input->post('other_mobile_type');
        $sPin=$this->input->post('sPin');
        $active_status='1';
        if($active_status=='1')
        {
          $auto_approved_status='1';
        }
        else
        {
          $auto_approved_status='2';
        }
        date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
        $nows = date('Y-m-d');
        $getcity_by_pincode = $this->Sales->get_city_by_pinocde($sPin);
        $getcity=$getcity_by_pincode->city;
        if(empty($getcity))
        {
            $getcity1=$city;
        }
        else
        {
           $getcity1=$getcity;
        }
       
        $data->name=$name;
        $data->name_type=$name_type;
        $data->gender=$gender;
        $data->user_type=$user_type;
        $data->other_detail=$other_detail;
        $data->hawker_sub_type=$hawker_sub_type;
        $data->other_sub_hawker_type=$other_sub_hawker_type;
        $data->address=$address;
        $data->other_service_type=$other_service_type;
        $data->phone_type=$phone_type;
        $data->seasonal_temp_hawker_type=$seasonal_temp_hawker_type;
        $data->mobile_no_contact=$mobile_no_contact;
        $data_reg->mobile_no_contact=$mobile_no_contact;
        $data->mobile_no_type=$mobile_no_type;
        $data->has_smart_phone=$has_smart_phone;
        $data->is_it_seasonal=$is_it_seasonal;
        $data->business_name=$business_name;
        $data->if_seasonal_other_business_detail=$if_seasonal_other_business_detail;
        $data->business_start_time=$business_start_time;
        $data->business_close_time=$business_close_time;
        $data->shop_name=$shop_name;
        $data->business_address=$business_address;
        $data->hawker_register_address=$hawker_register_address;
        $data->city_address=$city_address;
        $data->city=$getcity1;
        $data->state=$state;
        $data->business_mobile_no=$business_mobile_no;

        //$data->cat_id=$cat_id;
        //$data->sub_cat_id=$sub_cat_id;
        //$data->super_sub_cat_id=$super_sub_cat_id;
        
        
        $cat_id_array=explode(',',$cat_id);
        $sub_cat_id_array=explode(',',$sub_cat_id);
        $super_sub_cat_id_array=explode(',',$super_sub_cat_id);
        

        $data->menu_image_latitude=$menu_image_latitude;
        $data->menu_image_longitude=$menu_image_longitude;

        // image data 
        $data_reg->profile_image_latitude=$profile_image_latitude;
        $data_reg->profile_image_longitude=$profile_image_longitude;
        $data_reg->aadhar_card_image_latitude=$aadhar_card_image_latitude;
        $data_reg->aadhar_card_image_longitude=$aadhar_card_image_longitude;
        $data_reg->address_proof_image_latitude=$address_proof_image_latitude;
        $data_reg->address_proof_image_longitude=$address_proof_image_longitude;
        $data_reg->shop_image_1_latitude=$shop_image_1_latitude;
        $data_reg->shop_image_1_longitude=$shop_image_1_longitude;
        $data_reg->shop_image_2_latitude=$shop_image_2_latitude;
        $data_reg->shop_image_2_longitude=$shop_image_2_longitude;
        // image data
        $data->gst_no=$gst_no;
        $data->day_of_duty=$day_of_duty;
        $data->start_date=$start_date;
        $data->end_date=$end_date;
        $data->shop_gps_id=$shop_gps_id;
        $data->shop_latitude =$shop_latitude;
        $data->shop_longitude =$shop_longitude;
        $data->application_type =$application_type;
        $data->verification_by_call=$verification_by_call;
        $data->registered_time=$now;
        $data->date_time=$nows;
        $data->active_status=$active_status;
        $data->auto_approved_status=$auto_approved_status;
        $data->other_mobile_type=$other_mobile_type;
        $data->sPin=$sPin;

        $data->type='seller';
        $data->sales_id =$sales_id;
        $data_reg->sales_id =$sales_id;
       /* $fetchdata_by_registration=$this->Sales->fetch_data_registration($mobile_no_contact);*/
       /*if($user_type!='Seasonal')
       {*/
        $que=$this->db->query("select * from registration_sellers where mobile_no_contact='".$mobile_no_contact."'");

         $row = $que->num_rows();
         /*  }*/
        $quedata=$this->db->query("select * from registration_sellers where mobile_no_contact='".$mobile_no_contact."' and verification_by_call='0' and verification_status='0'");
        
         $row1 = $quedata->num_rows();
       
        if($row1>0)
        {
        $profile_image=$this->input->post('profile_image');
        $img       = str_replace('data:image/jpeg;base64,','',$profile_image);
        $img       = str_replace('','+',$img);
        $dataimage      = base64_decode($img);
        $imageName = "".$mobile_no_contact.".jpeg";
        $dir       = "assets/upload/profile_image/".$imageName;
        file_put_contents($dir,$dataimage);
        $aadhar_card_image=$this->input->post('aadhar_card_image');
        $idf       = str_replace('data:image/jpeg;base64,','',$aadhar_card_image);
        $idf       = str_replace('','+',$idf);
        $dataimage1     = base64_decode($idf);
        $imageName1 = "".$mobile_no_contact.".jpeg";
        $dir       = "assets/upload/identity_proof_image/front/".$imageName1;
        file_put_contents($dir,$dataimage1);

        $aadhar_card_image_back=$this->input->post('aadhar_card_image_back');
        $idf_back       = str_replace('data:image/jpeg;base64,','',$aadhar_card_image_back);
        $idf_back       = str_replace('','+',$idf_back);
        $dataimage_back     = base64_decode($idf_back);
        $imageName_back = "".$mobile_no_contact.".jpeg";
        $dir       = "assets/upload/identity_proof_image/back/".$imageName_back;
        file_put_contents($dir,$dataimage_back);

        $address_proof=$this->input->post('address_proof');
        $addproof       = str_replace('data:image/jpeg;base64,','',$address_proof);
        $addproof       = str_replace('','+',$addproof);
        $addressproof     = base64_decode($addproof);
        $imageaddress = "".$mobile_no_contact.".jpeg";
        $dir       = "assets/upload/address_proof/".$imageaddress;
        file_put_contents($dir,$addressproof);

        $shop_image_1=$this->input->post('shop_image_1');
        $idf2      = str_replace('data:image/jpeg;base64,','',$shop_image_1);
        $idf2       = str_replace('','+',$idf2);
        $dataimage3     = base64_decode($idf2);
        $imageName3 = "".$mobile_no_contact.".jpeg";
        $dir       = "assets/upload/shop_image/".$imageName3;
        file_put_contents($dir,$dataimage3);

        $shop_image_2=$this->input->post('shop_image_2'); 
        $idf1       = str_replace('data:image/jpeg;base64,','',$shop_image_2);
        $idf1       = str_replace('','+',$idf1);
        $dataimage2      = base64_decode($idf1);
        $imageName2 = "".$mobile_no_contact.".jpeg";
        $dir       = "assets/upload/shop_image_2/".$imageName2;
        file_put_contents($dir,$dataimage2);

        $menu_image=$this->input->post('menu_image');
        $menu_img       = str_replace('data:image/jpeg;base64,','',$menu_image);
        $menu_img       = str_replace('','+',$menu_img);
        $dataimage      = base64_decode($menu_img);
        $imageName_menu = "".$mobile_no_contact.".jpeg";
        $dir       = "assets/upload/menu_image/".$imageName_menu;
        file_put_contents($dir,$dataimage);

        $menu_image_2=$this->input->post('menu_image_2');
        $menu_img_2       = str_replace('data:image/jpeg;base64,','',$menu_image_2);
        $menu_img_2       = str_replace('','+',$menu_img_2);
        $dataimage_2      = base64_decode($menu_img_2);
        $imageName_menu_2 = "".$mobile_no_contact.".jpeg";
        $dir       = "assets/upload/menu_image1/".$imageName_menu_2;
        file_put_contents($dir,$dataimage_2);

        $menu_image_3=$this->input->post('menu_image_3');
        $menu_img_3       = str_replace('data:image/jpeg;base64,','',$menu_image_3);
        $menu_img_3       = str_replace('','+',$menu_img_3);
        $dataimage_3      = base64_decode($menu_img_3);
        $imageName_menu_3 = "".$mobile_no_contact.".jpeg";
        $dir       = "assets/upload/menu_image2/".$imageName_menu_3;
        file_put_contents($dir,$dataimage_3);

        $menu_image_4=$this->input->post('menu_image_4');
        $menu_img_4       = str_replace('data:image/jpeg;base64,','',$menu_image_4);
        $menu_img_4       = str_replace('','+',$menu_img_4);
        $dataimage_4      = base64_decode($menu_img_4);
        $imageName_menu_4 = "".$mobile_no_contact.".jpeg";
        $dir       = "assets/upload/menu_image3/".$imageName_menu_4;
        file_put_contents($dir,$dataimage_4);
        $data_reg->profile_image=$profile_image;
        $data_reg->aadhar_card_image=$aadhar_card_image;
        $data_reg->aadhar_card_image_back=$aadhar_card_image_back;
        $data_reg->address_proof=$address_proof;
        $data_reg->shop_image_1=$shop_image_1;
        $data_reg->shop_image_2=$shop_image_2;
        $data->menu_image=$menu_image;
        $data->menu_image_2=$menu_image_2;
        $data->menu_image_3=$menu_image_3;
        $data->menu_image_4=$menu_image_4;

        $updatehawkerdata = $this->Sales->updatehawkerdata($data);
        $updatehawkerdata_img = $this->Sales->updatehawkerdata_img($data_reg);

            $otpValue=mt_rand(1000, 9999);
            $otpdata->mobile_no_contact=$mobile_no_contact;
            $otpdata->device_id=$device_id;
            $otpdata->seller_id=$hawkerCode;
            $otpdata->otp=$otpValue;
            $mobile_no=$mobile_no_contact;
            if($verification_by_call!='')
            {
            $res3 = $this->Sales->send_otp($mobile_no,$otpValue);
            if($res3!='')
            {
              $res4 = $this->Sales->otpgetdata_by_seller($otpdata);
            }
            }
             else
            {
            $res3 = $this->Sales->send_otp($mobile_no,$otpValue);
            if($res3!='')
            {
              $res4 = $this->Sales->otpgetdata_by_seller($otpdata);
            }
            }
            $data1->id=$result;
            $data1->hawker_code=$hawkerCode;
            $data1->verification_call_status=$verification_by_call;
            $data1->status ='1';
            $data1->message = 'register Success';
            array_push($result2,$data1);
            $response->data = $data1;
          
         }
         $data3->city=$getcity1;
         $data3->state=$state;
         $checkcode = $this->Sales->checkcode($data3);
         $id1=$checkcode->city_code;
      
         if($row>0)
         {
            $data1->status ='2';
            $data1->message = 'This Number already exists';
            array_push($result2,$data1);
            $response->data = $data1;
         }

         else if(empty($id1))
         {
            $data1->status ='4';
            //new//
            logErr($shop_latitude.'/'.$shop_longitude.'/'.date('Y-m-d H:i:s'),'salesLocation.txt');
            $data1->message = 'City is not matched';
            array_push($result2,$data1);
            $response->data = $data1;

         }
        else
        {
        $profile_image=$this->input->post('profile_image');
        $img       = str_replace('data:image/jpeg;base64,','',$profile_image);
        $img       = str_replace('','+',$img);
        $dataimage      = base64_decode($img);
        $imageName = "".$mobile_no_contact.".jpeg";
        $dir       = "assets/upload/profile_image/".$imageName;
        file_put_contents($dir,$dataimage);
        $aadhar_card_image=$this->input->post('aadhar_card_image');
        $idf       = str_replace('data:image/jpeg;base64,','',$aadhar_card_image);
        $idf       = str_replace('','+',$idf);
        $dataimage1     = base64_decode($idf);
        $imageName1 = "".$mobile_no_contact.".jpeg";
        $dir       = "assets/upload/identity_proof_image/front/".$imageName1;
        file_put_contents($dir,$dataimage1);

        $aadhar_card_image_back=$this->input->post('aadhar_card_image_back');
        $idf_back       = str_replace('data:image/jpeg;base64,','',$aadhar_card_image_back);
        $idf_back       = str_replace('','+',$idf_back);
        $dataimage_back     = base64_decode($idf_back);
        $imageName_back = "".$mobile_no_contact.".jpeg";
        $dir       = "assets/upload/identity_proof_image/back/".$imageName_back;
        file_put_contents($dir,$dataimage_back);

        $address_proof=$this->input->post('address_proof');
        $addproof       = str_replace('data:image/jpeg;base64,','',$address_proof);
        $addproof       = str_replace('','+',$addproof);
        $addressproof     = base64_decode($addproof);
        $imageaddress = "".$mobile_no_contact.".jpeg";
        $dir       = "assets/upload/address_proof/".$imageaddress;
        file_put_contents($dir,$addressproof);

        $shop_image_1=$this->input->post('shop_image_1');
        $idf2      = str_replace('data:image/jpeg;base64,','',$shop_image_1);
        $idf2       = str_replace('','+',$idf2);
        $dataimage3     = base64_decode($idf2);
        $imageName3 = "".$mobile_no_contact.".jpeg";
        $dir       = "assets/upload/shop_image/".$imageName3;
        file_put_contents($dir,$dataimage3);

        $shop_image_2=$this->input->post('shop_image_2'); 
        $idf1       = str_replace('data:image/jpeg;base64,','',$shop_image_2);
        $idf1       = str_replace('','+',$idf1);
        $dataimage2      = base64_decode($idf1);
        $imageName2 = "".$mobile_no_contact.".jpeg";
        $dir       = "assets/upload/shop_image_2/".$imageName2;
        file_put_contents($dir,$dataimage2);

        $menu_image=$this->input->post('menu_image');
        $menu_img       = str_replace('data:image/jpeg;base64,','',$menu_image);
        $menu_img       = str_replace('','+',$menu_img);
        $dataimage      = base64_decode($menu_img);
        $imageName_menu = "".$mobile_no_contact.".jpeg";
        $dir       = "assets/upload/menu_image/".$imageName_menu;
        file_put_contents($dir,$dataimage);

        $menu_image_2=$this->input->post('menu_image_2');
        $menu_img_2       = str_replace('data:image/jpeg;base64,','',$menu_image_2);
        $menu_img_2       = str_replace('','+',$menu_img_2);
        $dataimage_2      = base64_decode($menu_img_2);
        $imageName_menu_2 = "".$mobile_no_contact.".jpeg";
        $dir       = "assets/upload/menu_image1/".$imageName_menu_2;
        file_put_contents($dir,$dataimage_2);

        $menu_image_3=$this->input->post('menu_image_3');
        $menu_img_3       = str_replace('data:image/jpeg;base64,','',$menu_image_3);
        $menu_img_3       = str_replace('','+',$menu_img_3);
        $dataimage_3      = base64_decode($menu_img_3);
        $imageName_menu_3 = "".$mobile_no_contact.".jpeg";
        $dir       = "assets/upload/menu_image2/".$imageName_menu_3;
        file_put_contents($dir,$dataimage_3);

        $menu_image_4=$this->input->post('menu_image_4');
        $menu_img_4       = str_replace('data:image/jpeg;base64,','',$menu_image_4);
        $menu_img_4       = str_replace('','+',$menu_img_4);
        $dataimage_4      = base64_decode($menu_img_4);
        $imageName_menu_4 = "".$mobile_no_contact.".jpeg";
        $dir       = "assets/upload/menu_image3/".$imageName_menu_4;
        file_put_contents($dir,$dataimage_4);
        $data_reg->profile_image=$profile_image;
        $data_reg->aadhar_card_image=$aadhar_card_image;
        $data_reg->aadhar_card_image_back=$aadhar_card_image_back;
        $data_reg->address_proof=$address_proof;
        $data_reg->shop_image_1=$shop_image_1;
        $data_reg->shop_image_2=$shop_image_2;
        $data->menu_image=$menu_image;
        $data->menu_image_2=$menu_image_2;
        $data->menu_image_3=$menu_image_3;
        $data->menu_image_4=$menu_image_4;  
        $result = $this->Sales->add($data);
        $result_data = $this->Sales->add_reg($data_reg);
        $alphanumerric='SHP_0000'.$result;
        if($result<'10')
        {
            $codegenrate='0000'.$result;
        }
        else if($result>'9' and $result <'100')
        {
            $codegenrate='000'.$result;
        }
        else if($result>'99' and $result <'1000')
        {
            $codegenrate='0'.$result;
        }
        else if($result>'1000' and $result <'100000')
        {
            $codegenrate='0'.$result;
        }
        if(!empty($result))
        {  

           
            $data3->city=$getcity1;
            $data3->state=$state;
            $data5->state=$state;
            $data4->user_type=$user_type;
            $checktype = $this->Sales->checktype($data4);
            $checkcode = $this->Sales->checkcode($data3);
            $checkstatecode = $this->Sales->checkstatecode($data5);
            $id1=$checkcode->city_code;
            if(empty($id1))
            {
               $id='00'; 
            }
            else if($id1<'10')
            {
              $id='0'.$id1; 
            }
            else
            {
                $id=$id1;
            }
            $state_code=$checkstatecode->state_code;
            $code=$checktype->code;
            $futureuse='00';
            $hawkerCode=$state_code .''. $id.''.$code .''. $futureuse.''.$codegenrate;
            $otpValue=mt_rand(1000, 9999);
            $otpdata->mobile_no_contact=$mobile_no_contact;
            $otpdata->device_id=$device_id;
            $otpdata->seller_id=$hawkerCode;
            $otpdata->otp=$otpValue;
            $mobile_no=$mobile_no_contact;
            if($verification_by_call!='')
            {
            $res3 = $this->Sales->send_otp($mobile_no,$otpValue);
            if($res3!='')
            {
              $res4 = $this->Sales->otpgetdata_by_seller($otpdata);
            }
            }
             else
            {
            $res3 = $this->Sales->send_otp($mobile_no,$otpValue);
            if($res3!='')
            {
              $res4 = $this->Sales->otpgetdata_by_seller($otpdata);
            }
            }
           
            $resultdata = $this->Sales->update_shop_id($alphanumerric,$result,$hawkerCode);
          	
					for($i=0;$i<count($cat_id_array);$i++)
				        {
				        	$hawker_data_array[]=array(
				        							'hawker_code'=>$hawkerCode,
				        							'cat_id'=>$cat_id_array[$i],
				        							'creation_date'=>date('Y-m-d'),
				        							'status'=>1
				        							);
				        }
				        // print_r($hawker_data_array);exit;
				        $categoryResult=$this->Sales->addHawkerCategory($hawker_data_array);

				        for($i=0;$i<count($sub_cat_id_array);$i++)
				        {
				        	$hawker_data_array2[]=array(
				        							'hawker_code'=>$hawkerCode,
				        							'sub_cat_id'=>$sub_cat_id_array[$i],
				        							'creation_date'=>date('Y-m-d'),
				        							'status'=>1
				        							);
				        }
				        $SubcategoryResult=$this->Sales->addHawkerSubCategory($hawker_data_array2);
					
				        for($i=0;$i<count($super_sub_cat_id_array);$i++)
				        {
				        	$hawker_data_array3[]=array(
				        							'hawker_code'=>$hawkerCode,
				        							'super_sub_cat_id'=>$super_sub_cat_id_array[$i],
				        							'creation_date'=>date('Y-m-d'),
				        							'status'=>1
				        							);
				        }
				        $SuperSubcategoryResult=$this->Sales->addHawkerSuperSubCategory($hawker_data_array3);
            $data1->id=$result;
            $data1->hawker_code=$hawkerCode;
            $data1->verification_call_status=$verification_by_call;
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

   /*.........Temporary Hawker Registration  Api  ---- */
    public function temporary_hawker_registration_post()
    {   
        $response = new StdClass();
        $result2 = new StdClass();
        $sales_id=$this->input->post('sales_id');
        $name=$this->input->post('name');
        $gender=$this->input->post('gender');
        $hawker_type=$this->input->post('hawker_type');
        $sub_hawker_type=$this->input->post('sub_hawker_type');
        $seasonal_temp_hawker_type=$this->input->post('seasonal_temp_hawker_type');
        $if_seasonal_other_business_detail=$this->input->post('if_seasonal_other_business_detail');
        $model_type=$this->input->post('model_type');
        $is_it_seasonal=$this->input->post('is_it_seasonal');
        $start_date=$this->input->post('start_date');
        $end_date=$this->input->post('end_date');
        $business_start_time=$this->input->post('business_start_time');
        $business_close_time=$this->input->post('business_close_time');
        $address=$this->input->post('address');
        $other_service_type=$this->input->post('other_service_type');
        $mobile_no=$this->input->post('mobile_no');
        $cat_id=$this->input->post('cat_id');
        $sub_cat_id=$this->input->post('sub_cat_id');
        $super_sub_cat_id=$this->input->post('super_sub_cat_id');
        $city=$this->input->post('city');
        $state=$this->input->post('state');
        $latitude=$this->input->post('latitude');
        $longitude=$this->input->post('longitude');  
        date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
        $data->sales_id =$sales_id;
        $data->name=$name;
        $data->gender=$gender;
        $data->hawker_type=$hawker_type;
        $data->other_service_type=$other_service_type;
        $data->sub_hawker_type=$sub_hawker_type;
        $data->seasonal_temp_hawker_type=$seasonal_temp_hawker_type;
        $data->if_seasonal_other_business_detail=$if_seasonal_other_business_detail;
        $data->model_type=$model_type;
        $data->is_it_seasonal=$is_it_seasonal;
        $data->start_date=$start_date;
        $data->end_date=$end_date;
        $data->business_start_time=$business_start_time;
        $data->business_close_time=$business_close_time;
        $data->address=$address;
        $data->mobile_no=$mobile_no;
        $data->cat_id=$cat_id;
        $data->sub_cat_id=$sub_cat_id;
        $data->super_sub_cat_id=$super_sub_cat_id;
        $data->latitude =$latitude;
        $data->longitude =$longitude;
        $data->registration_time=$now;
    
        $result = $this->Sales->temporary_hawker_registration($data);
        if($result<'10')
        {
            $codegenrate='0000'.$result;
        }
        else if($result>'9' and $result <'100')
        {
            $codegenrate='000'.$result;
        }
        else if($result>'99' and $result <'10000')
        {
            $codegenrate='00'.$result;
        }

        /*$codegenrate='0000'.$result;*/
        if(!empty($result))
        {  
            $data3->city=$city;
            $data3->state=$state;
            $data4->user_type=$hawker_type;
            $checktype = $this->Sales->checktype($data4);
            $checkcode = $this->Sales->checkcode($data3);
            $id1=$checkcode->id;
            if($id1<'10')
            {
              $id='0'.$id1; 
            }
            else
            {
                $id=$id1;
            }
            $state_code=$checkcode->state_code;
            $code=$checktype->code;
            $futureuse='00';
            $hawkerCode=$state_code .''. $id.''.$code .''. $futureuse.''.$codegenrate;

           
            $resultdata = $this->Sales->update_temporary_data($result,$hawkerCode);
            $data1->id=$result;
            $data1->hawker_code=$hawkerCode;
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
       
      echo  json_output($response);
    }
   /*.........Temporary Hawker Registration  Api  ---- */

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
         //$this->load->model('User');
         $res = $this->Sales->sales_location_add_data_by_gps($data);
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

   /*......... Get Validate SalesUser Api For Fixer  ---- */
    public function validate_active_sales_user_post()
     {
        $response = new StdClass();
        $result       =  new StdClass();
        $sales_id = $this->input->post('sales_id');
        $device_id=$this->input->post('device_id');
        $city=$this->input->post('city');
        $sPin=$this->input->post('sPin');
        $result->sales_id = $sales_id;
        $result1->device_id=$device_id;
        $result2->city=$city;
        $result2->Pincode=$sPin;
        $res = $this->Sales->Validate_sales_user($result);
        $res1 = $this->Sales->check_device_for_sales($result);
        $res2 = $this->Sales->check_city_status_sales($result2);
        $active_status=$res->active_status;
        $message=$res->message;
        $devicedata=$res1->device_id;
        $status1=$res2->status;
        if(!empty($res2))
        {
          if($devicedata!=$device_id)
         {
            $data1->city_status=$status1;
            $data1->active_status ='3';
            $data1->status ='1';
            $data1->message = 'logout from other device';
             array_push($result,$data1);
             $response->data = $data1;

         }

         else if($active_status=='1')
          {
            $data1->city_status=$status1;
            $data1->active_status='1';
            $data1->status ='1';
            $data1->message = 'Active';
             array_push($result,$data1);
             $response->data = $data1;
          }
          else if($active_status=='0')
          {
            $data1->city_status=$status1;
            $data1->active_status='0';
            $data1->status ='1';
            $data1->message = $message;
             array_push($result,$data1);
             $response->data = $data1;
          }
         
        }
          else
          {
            $data1->city_status ='0';
            $data1->active_status ='1';
            $data1->status ='1';
            $data1->message = 'failed';
             array_push($result,$data1);
             $response->data = $data1;
          }

        echo json_output($response);
     }
   /*......... Get Validate SalesUser Api For Fixer  ---- */

   /*.........Profile data for sales Api For hawker  ---- */
     public function sales_profile_post()
      {
        $response =   new StdClass();
        $result       =  new StdClass();
        $sales_id =$this->input->post('sales_id');
        $data->sales_id=$sales_id;
        $resdata = $this->Sales->check_data_sales_profile($data);
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
            $data1->image_url='http://10.0.0.15/fixer_goolean/manage/salesuser_image/'.$image;
            //$data1->image_url=base_url().'manage/salesuser_image/'.$image;
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

    /*......... duty on/off Api For sales  ---- */
     public function duty_on_off_by_sales_post()
     {
        $response = new StdClass();
        $result       =  new StdClass();
        $device_id = $this->input->post('device_id');
        $notification_id = $this->input->post('notification_id');
        $sales_id = $this->input->post('sales_id');
        $longitude =$this->input->post('longitude');
        $latitude=$this->input->post('latitude');
        $duty_status=$this->input->post('duty_status');
        date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
        $nows=date('Y-m-d H:i:s');
        if($duty_status=='1')
        {
        require APPPATH . 'libraries/firebase.php';
        require APPPATH . 'libraries/push.php';
        require APPPATH . 'libraries/config.php';
        $firebase = new Firebase();
        $push = new Push();
        // optional payload
        $payload = array();
        $payload['team'] = 'India';
        $payload['score'] = '5.6';
        // notification title
        $title ='Duty';
        // notification message
        $message ='ON';
        
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
        $data4 = $firebase->send($regId, $json);
        }
        $data->sales_id=$sales_id;
        $data->longitude=$longitude;
        $data->latitude=$latitude;
        $data->duty_status=$duty_status;
        $data->on_time=$now;
        $data->device_id=$device_id;
        $data->status='1';
        $res = $this->Sales->duty_data_by_sales($data);
        }
        
        else if($duty_status==0)
        {
        $data->sales_id=$sales_id;
        $data->longitude=$longitude;
        $data->latitude=$latitude;
        $data->duty_status=$duty_status;
        $data->device_id=$device_id;
        $data->out_time=$now;
       // $data->date_time=$nows;
        $data->status='1';
        $this->load->model('User');
        $res = $this->Sales->duty_data_by_sales($data);
        
        }
        else if($duty_status==2)
         {
            $sales_id = $this->input->post('sales_id');
            $resdata = $this->Sales->check_duty_data_by_sales($sales_id);
            $duty_status1 = $resdata->duty_status;
         }

        if(!empty($data))
         {
            $data1->duty_status=$duty_status;
            $data1->messagedata=$data4;
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

   /*......... logout Api For Door hawker ---- */
        public function data_logout_for_sales_post()
     {
        $response = new StdClass();
        $result = array();
        $device_id =$this->input->post('device_id');
        $sales_id =$this->input->post('sales_id');
        $longitude =$this->input->post('longitude');
        $latitude=$this->input->post('latitude');
        date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
        $data3->device_id=$device_id;
        $data3->latitude = $latitude;
        $data3->longitude = $longitude;
        $data3->sales_id = $sales_id;
        $data->sales_id = $sales_id;
        $data3->duty_status ='0';
        $data3->status ='1';
        $data3->out_time =$now;
        $data->logout_time=$now;
        $resdata1 = $this->Sales->check_logout_data_sales($sales_id);
        $device_id1 = $resdata1->device_id;
        if($sales_id!='')
        {
        $data->sales_id = $sales_id;

        $data->logout_time=$now;
        $data2 = $this->Sales->logout_sales_data($data);
        $resdata1 = $this->Sales->insert_duty_status__for_sales($data3);

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

    /*.........Category   Api For Fixer  ---- */
  public function category_post()
  {
    $response = new StdClass();
    $result = array();

    $cat_name =$this->input->post('cat_name');
    $type=$this->input->post('type');
    if($type!='' OR $cat_name!='')
    {
    if($type=='Fix')
    {
      if($cat_name!='')
    {
    $datacat = $this->Sales->category_data_profile($cat_name);
    }
    else
    {
       $datacat = $this->Sales->category1_data_profile();
       //$datacat=sort($datacat1);
    }
    if(!empty($datacat))
    {
    foreach ($datacat as $row)
     {
     $setData = new StdClass();
     $setData->id = $row['id'];
     $setData->position_key = $row['id'];
     $setData->cat_name = $row['cat_name'];
     $setData->image_url= base_url().'manage/catImages/'.$row['cat_icon_image'];
     //$setData->check_level = $row['check_level'];
     $setData->sub_cat_status='0';
     $subCat = $this->Sales->getSubCategory(['category'=>$row['id']]);
     if(!empty($subCat))
     {

      $setData->sub_cat_status= '1';
      $setData->subCat = $subCat;

       }
     else
     {
      $setData->subCat = $subCat;
     }    
     array_push($result,$setData);
     }
      $response->check_level = $row['check_level'];;
      $response->status = '1';
      $response->data = $result;

    }
    }
    else
    {
      if($cat_name!='')
    {
    $datacat = $this->Sales->category_data_profile($cat_name);
    }
    else
    {
       $datacat = $this->Sales->category2_data_profile();
       //$datacat=sort($datacat1);
    }
    if(!empty($datacat))
    {
    foreach ($datacat as $row)
     {
     $setData = new StdClass();
     $setData->id = $row['id'];
     $setData->position_key = $row['id'];
     $setData->cat_name = $row['cat_name'];
     $setData->image_url= base_url().'manage/catImages/'.$row['cat_icon_image'];
     //$setData->check_level = $row['check_level'];
     $setData->sub_cat_status='0';
     $subCat = $this->Sales->getSubCategory(['category'=>$row['id']]);
     if(!empty($subCat))
     {

      $setData->sub_cat_status= '1';
      $setData->subCat = $subCat;

       }
     else
     {
      $setData->subCat = $subCat;
     }    
     array_push($result,$setData);
     }
      $response->check_level = $row['check_level'];;
      $response->status = '1';
      $response->data = $result;
    }
    }
  }
    
    else
    {
    $response->status = '0';
    $response->data = "";

    }

     echo json_output($response);
    }

      /*.........Category   Api For Fixer  ---- */

      /*.........super sub Category   Api For Hawker  ---- */
     public function super_sub_category_post()
      {
        $response   =   new StdClass();
        $result       =   array();
        $sub_cat_id =$this->input->post('sub_cat_id');
        $datacat = $this->Sales->getSuperSubCategory($sub_cat_id);
        if(!empty($datacat))
        {
         foreach ($datacat as $row)
           {

            $data['id'] =   $row['id'];
            $data['super_sub_cat_name'] =   $row['super_sub_cat_name'];
            $data['image_url']=base_url().'manage/catImages/'.$row['super_sub_cat_image'];
            $data['position_key'] = $sub_cat_id;
            $data['status']  ='1';

            array_push($result,$data);

           } 
              $response->status = '1';
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

      /*.........super sub Category   Api For hawker  ---- */

       /*......... status check api for  hawker ---- */
        public function status_check_data_post()
     {
        $response = new StdClass();
        $result = array();
        $status =$this->input->post('status');
        $mobile_no =$this->input->post('mobile_no');
        $device_id =$this->input->post('device_id');
        $notification_id =$this->input->post('notification_id');
        date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
        
        if($status=='1')
        {
        require APPPATH . 'libraries/firebase.php';
        require APPPATH . 'libraries/push.php';
        require APPPATH . 'libraries/config.php';
        $data->mobile_no = $mobile_no;
        $data->device_id = $device_id;
        $data->notification_id = $notification_id;
        $data->login_time=$now;
        $res1 = $this->Sales->fetch_login_data($data);
        $name=$res1->name;
        $sales_id=$res1->user_id;

        $otpValue=mt_rand(1000, 9999);
        $data1->device_id = $device_id;
        $data1->notification_id = $notification_id;
        $data1->mobile_no=$mobile_no;
        $data1->sales_id=$sales_id;
        $data1->otp=$otpValue;
        $res3 = $this->Sales->send_otp($mobile_no,$otpValue);
        if($res3!='')
        {
          $res4 = $this->Sales->otpgetdata($data1);
        }
        $notificationdata=$res1->notification_id;
        $data2 = $this->Sales->update_login_data($data);
        $firebase = new Firebase();
        $push = new Push();
        // optional payload
        $payload = array();
        $payload['team'] = 'India';
        $payload['score'] = '5.6';

        // notification title
        $title ='logout';
        
        // notification message
        $message ='Device has been logge out';
        
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
            $regId =$notificationdata;
            $data4 = $firebase->send($regId, $json);
            $data1->messagedata=$data4;
            $data1->status ='1';
            $data1->name =$name;
            $data1->sales_id =$sales_id;
            array_push($result,$data1);
            $response->data = $data1;
        }
       
        }
        else
        {
            $data1->status ='0';
            array_push($result,$data1);
           $response->data = $data1;
        }
        echo json_output($response);
     }
     /* ---------------status check api for  hawker --------------*/
     /*.........super sub Category   Api For Hawker  ---- */
     public function Hawker_type_data_post()
      {
        $response   =   new StdClass();
        $result       =   array();
        $hawker_type_code =$this->input->post('hawker_type_code');
        $datacat = $this->Sales->gethawkertypename($hawker_type_code);
        if(!empty($datacat))
        {
         foreach ($datacat as $row)
           {

            $data['id'] =   $row['id'];
            $data['hawker__sub_type_name'] =   $row['hawker__sub_type_name'];
            $data['create_date'] =  $row['create_date'];
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

     /*.........Verification OTP Api For Hawker  ---- */
     public function verification_otp_data_post()
      {
        $response   =   new StdClass();
        $result       =  new StdClass();
        $mobile_no =$this->input->post('mobile_no');
        $device_id =$this->input->post('device_id');
        $otp =$this->input->post('otp');
        $data1->device_id = $device_id;
        $data1->mobile_no = $mobile_no;
        $data1->otp=$otp;
        $dataotp = $this->Sales->verification_otp($data1);
        if(!empty($dataotp))
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

       /*.........Verification OTP Api For Hawker  ---- */

       /*.........Verification OTP for seller registration Api For Hawker  ---- */
     public function verification_otp_for_seller_registration_post()
      {
        $response   =   new StdClass();
        $result       =  new StdClass();
        $mobile_no =$this->input->post('mobile_no');
        $device_id =$this->input->post('device_id');
        $otp =$this->input->post('otp');
        $call_verification=$this->input->post('call_verification');
        $data1->device_id = $device_id;
        $data1->mobile_no = $mobile_no;
        $data1->otp=$otp;
        if(!empty($otp))
        {
        $dataotp = $this->Sales->verification_otp_by_seller($data1);
        $hawker_code = $dataotp->seller_id;
        if(!empty($dataotp))
        {
           $update_verification_hawker = $this->Sales->update_verification_hawker($mobile_no);

            $data->hawker_code =$hawker_code;
            $data->status = '1';
            array_push($result,$data);
            $response->data = $data;
         }
        }
        else if(empty($otp))
        {
           $data2->device_id = $device_id;
           $data2->mobile_no = $mobile_no;
           $data_otp_by_call = $this->Sales->verification_otp_by_seller_by_call($data2);
           $hawker_code = $dataotp->seller_id;
            $update_verification_hawker_by_call = $this->Sales->update_verification_hawker_by_call($mobile_no);
            $data->hawker_code =$hawker_code;
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

       /*.........erification OTP for seller registration Api For Hawker ---- */

       /*.........Resend OTP Api For Hawker  ---- */
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
        $res = $this->Sales->send_otp($mobile_no,$otpValue);
        if(!empty($mobile_no))
        {
         $res1 = $this->Sales->resend_otp($data1);
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

        /*.........Resend OTP for seller registration Api For Hawker  ---- */
     public function resend_otp_data_for_seller_registration_post()
      {
        $response   =   new StdClass();
        $result       =  new StdClass();
        $device_id =$this->input->post('device_id');
        $mobile_no =$this->input->post('mobile_no');
        $otpValue=mt_rand(1000, 9999);
        $data1->device_id = $device_id;
        $data1->mobile_no=$mobile_no;
        $data1->otp=$otpValue;
        $res = $this->Sales->send_otp($mobile_no,$otpValue);
        if(!empty($mobile_no))
        {
         $res1 = $this->Sales->resend_otp_for_seller($data1);
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

       /*.........Resend OTP for seller registration Api For Hawker  ---- */

       /*.........Remove OTP Api For Hawker  ---- */
     public function otp_expire_post()
      {
        $response   =   new StdClass();
        $result       =  new StdClass();
        $device_id =$this->input->post('device_id');
        $mobile_no =$this->input->post('mobile_no');
        $data1->device_id = $device_id;
        $data1->mobile_no=$mobile_no;
        $res = $this->Sales->remove_otp($data1);
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

       /*.........Remove OTP Api For Hawker  ---- */

        /*.........Remove OTP Api For Hawker  ---- */
     public function otp_expire_for_seller_registration_post()
      {
        $response   =   new StdClass();
        $result       =  new StdClass();
        $device_id =$this->input->post('device_id');
        $mobile_no =$this->input->post('mobile_no');
        $data1->device_id = $device_id;
        $data1->mobile_no=$mobile_no;
        $res = $this->Sales->remove_otp_for_seller($data1);
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

       /*.........Remove OTP Api For Hawker  ---- */


     
       /*......... Get Check Version data   ---- */
    public function app_check_version_post()
     {
        $response = new StdClass();
        $result2 = new StdClass();
        $version_name = $this->input->post('version_name');
        $version_code =$this->input->post('version_code');
        $result->version_name = $version_name;
        $result->version_code = $version_code;
        $res = $this->Sales->Validate_version_data($result);
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
        $resdata = $this->Sales->update_version_data($result);
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
If you want to update press press button.';
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

     /*......... check_list_for_sale  ---- */
    public function check_list_for_sale_post()
    {
      $response   =   new StdClass();
      $result       =   array();
      $datacat = $this->Sales->check_list_data();
      if(!empty($datacat))
      {
       foreach ($datacat as $row)
      {

      $data['id'] =   $row['id'];
      $data['question']       =   $row['question'];
      $data['status']  ='1';
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
      /*......... check_list_for_sale ---- */

      /*.........Update  check_list_for_sale  ---- */
    public function update_check_list_for_sale_post()
     {
        $response   =   new StdClass();
        $result       =  new StdClass();
        $hawker_code =$this->input->post('hawker_code');
        $sales_id =$this->input->post('sales_id');
        $check_list =$this->input->post('check_list');
        $data1->hawker_code = $hawker_code;
        $data1->sales_id=$sales_id;
        $data1->check_list=$check_list;
        $res1 = $this->Sales->update_check_list($data1);
        if($hawker_code!='')
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
      /*......... check_list_for_sale ---- */


/*.........total_hawker_add_by_sales_person  ---- */
     public function total_hawker_add_by_sales_person_post()
      {
        $response   =   new StdClass();
        $result       =  new StdClass();
        $sales_id =$this->input->post('sales_id');
        date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d');
       $query=$this->db->where(['sales_id'=>$sales_id,])->from("registration_sellers")->count_all_results();
     /*  $query1=$this->db->where(['sales_id'=>$sales_id, 'verification_status'=>'1'])->from("registration_sellers")->count_all_results();*/

        $query1=$this->db->query("SELECT * from registration_sellers where sales_id='".$sales_id."' and(verification_status =1 or  verification_by_call = 1)");
         //return($query1->row());
        $row = $query1->num_rows();
        

       $query2=$this->db->where(['sales_id'=>$sales_id, 'verification_status'=>'0','verification_by_call'=>'0'])->from("registration_sellers")->count_all_results();

       $query3=$this->db->where(['sales_id'=>$sales_id, 'date_time'=>$now])->from("registration_sellers")->count_all_results();

       /*$query4=$this->db->where(['sales_id'=>$sales_id, 'date_time'=>$now,'verification_status'=>'1'])->from("registration_sellers")->count_all_results();*/

       $query4=$this->db->query("SELECT * from registration_sellers where  sales_id='".$sales_id."' and date_time='$now' and(verification_status =1 or  verification_by_call = 1)");
         //return($query1->row());
        $row1 = $query4->num_rows();
       /* print_r("SELECT * from registration_sellers where  sales_id='".$sales_id."' and date_time='$now' and(verification_status =1 and verification_by_call = 0)
          or(verification_status=0 and verification_by_call=1)");
        die();*/
       $query5=$this->db->where(['sales_id'=>$sales_id, 'date_time'=>$now,'verification_status'=>'0','verification_by_call'=>'0'])->from("registration_sellers")->count_all_results();

        if(!empty($sales_id))
        {
        $data->total_registration=$query;
        $data->verified_hawker=$row;
        $data->unverified_hawker=$query2;
        $data->Today_total_registration=$query3;
        $data->Today_total_verified_hawker=$row1;
        $data->Today_total_unverified_hawker=$query5;
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

      /*.........total_hawker_add_by_sales_person  ---- */

      /*.........List for particular hawker   ---- */
     public function list_for_hawker_add_by_sales_post()
      {
        $response   =   new StdClass();
        $result       =   array();
        $sales_id =$this->input->post('sales_id');
        $verification_status =$this->input->post('verification_status');

        if($verification_status=='0')
        {
        $show_list_by_hawker = $this->Sales->show_list_hawker_by_sales($sales_id,$verification_status);
        }
        else
        {
             $show_list_by_hawker = $this->Sales->show_list_hawker_by_sale($sales_id,$verification_status);
        }
        
        if(!empty($show_list_by_hawker))
        {
         foreach ($show_list_by_hawker as $row)
          {
            $data['name'] =   $row['name'];
            $data['mobile_no_contact'] =   $row['mobile_no_contact'];
            $data['hawker_code'] =   $row['hawker_code'];
            $data['registered_time'] =   $row['registered_time'];
            $data['status']  ='1';

            array_push($result,$data);

           } 
             // $response->status = '1';
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

      /*.........List for particular hawker  ---- */

      /*......... Login Api For distributor  Hawker ---- */
     public function login_Api_for_distributors_post()
     {
        $response = new StdClass();
        $result = new StdClass();
        $mobile_no = $this->input->post('mobile_no');
        $device_id=$this->input->post('device_id');
        $notification_id=$this->input->post('notification_id');
        date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
        $this->db
            ->select('*');
            $this->db->from("registration_sales");
            $this->db->where(['mobile_no'=>$mobile_no]);
            $query=$this->db->get();
            $num_rows=$query->num_rows();
            $current_data=$query->result_array();
            $data1->device_id = $device_id;
            $data1->notification_id = $notification_id;
            $data1->login_time=$now;
            if(!empty($mobile_no))
            {
             if(!empty($current_data))
            {
             foreach ($current_data as $row)
            {
                
              if($row['active_status']=='1')
            {
              $otpValue=mt_rand(1000, 9999);
              $data1->device_id = $device_id;
              $data1->notification_id = $notification_id;
              $data1->login_time=$now;
              $data1->name=$row['name'];
              $data1->mobile_no=$row['mobile_no'];
              $data1->sales_id=$row['sales_id'];
              $data1->otp=$otpValue;
              $data2->sales_id=$row['sales_id'];
              $res = $this->Sales->addRegistrationdistributorData($data1);
              $res1 = $this->Sales->check_login_validate_data_for_distributor($data2);
              $device_id1=$res1->device_id;
              if($device_id1!=$device_id)
              {

              $data['status']  ='3';
              array_push($result,$data);
              }
              else
              {
              $res3 = $this->Sales->send_otp($mobile_no,$otpValue);
              if($res3!='')
              {
              $res4 = $this->Sales->otpgetdata($data1);
              }
             /* $data['id'] =  $row['sales_id'];*/
              $data['mobile_no'] =  $row['mobile_no'];
              $data['active_status']='1';
             /* $data['type']=$row['type'];*/
              $data['status']  ='1';
              array_push($result,$data);
              }
             }
            else
            {
              $data['active_status']='0';
              
              $data['status']  ='1';
              array_push($result,$data);
            }
          
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
        
      /*.........Login Api For distributor  Hawker ---- */

      
      /*.........Verification OTP Api For Hawker distributor ---- */
     public function verification_otp_data_for_distributor_post()
      {
        $response   =   new StdClass();
        $result       =  new StdClass();
        $mobile_no =$this->input->post('mobile_no');
        $device_id =$this->input->post('device_id');
        $otp =$this->input->post('otp');
        $data1->device_id = $device_id;
        $data1->mobile_no = $mobile_no;
        $data1->otp=$otp;
        $dataotp = $this->Sales->fetchdata_for_distributor($mobile_no);
        $mobile_no = $dataotp->mobile_no;
        $name = $dataotp->name;
        $type = $dataotp->type;
        $id = $dataotp->id;
        $sales_id = $dataotp->sales_id;
        $dataotp = $this->Sales->verification_otp($data1);
        if(!empty($dataotp))
        {   
             $data->name = $name;
             $data->mobile_no = $mobile_no;
             $data->type = $type;
             $data->sales_id = $sales_id;

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

       /*.........Verification OTP Api For Hawker distributor  ---- */

        /*.........Remove OTP Api For Hawker  ---- */
     public function otp_expire_for_distributor_post()
      {
        $response   =   new StdClass();
        $result       =  new StdClass();
        $device_id =$this->input->post('device_id');
        $mobile_no =$this->input->post('mobile_no');
        $data1->device_id = $device_id;
        $data1->mobile_no=$mobile_no;
        $res = $this->Sales->remove_otp($data1);
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

       /*.........Remove OTP Api For Hawker  ---- */

       /*.........Resend OTP Api For Hawker  ---- */
     public function resend_otp_data_for_distributor_post()
      {
        $response   =   new StdClass();
        $result       =  new StdClass();
        $device_id =$this->input->post('device_id');
        $mobile_no =$this->input->post('mobile_no');
        $otpValue=mt_rand(1000, 9999);
        $data1->device_id = $device_id;
        $data1->mobile_no=$mobile_no;
        $data1->otp=$otpValue;
        $res = $this->Sales->send_otp($mobile_no,$otpValue);
        if(!empty($mobile_no))
        {
         $res1 = $this->Sales->resend_otp($data1);
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

       /*......... duty on/off Api For distributer  sales  ---- */
     public function duty_on_off_by_distributor_sales_post()
     {
        $response = new StdClass();
        $result       =  new StdClass();
        $device_id = $this->input->post('device_id');
        $notification_id = $this->input->post('notification_id');
        $distributor_id = $this->input->post('distributor_id');
        $longitude =$this->input->post('longitude');
        $latitude=$this->input->post('latitude');
        $duty_status=$this->input->post('duty_status');
        date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
        $nows=date('Y-m-d H:i:s');
        if($duty_status=='1')
        {
        require APPPATH . 'libraries/firebase.php';
        require APPPATH . 'libraries/push.php';
        require APPPATH . 'libraries/config.php';
        $firebase = new Firebase();
        $push = new Push();
        // optional payload
        $payload = array();
        $payload['team'] = 'India';
        $payload['score'] = '5.6';
        // notification title
        $title ='Duty';
        // notification message
        $message ='ON';
        
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
        $data4 = $firebase->send($regId, $json);
    }
        $data->distributor_id=$distributor_id;
        $data->longitude=$longitude;
        $data->latitude=$latitude;
        $data->duty_status=$duty_status;
        $data->on_time=$now;
        $data->device_id=$device_id;
        $data->status='1';
        $res = $this->Sales->duty_data_by_distributor_sales_user($data);
        }
        
        else if($duty_status==0)
        {
        $data->distributor_id=$distributor_id;
        $data->longitude=$longitude;
        $data->latitude=$latitude;
        $data->duty_status=$duty_status;
        $data->device_id=$device_id;
        $data->out_time=$now;
        $data->status='1';
        $res = $this->Sales->duty_data_by_distributor_sales_user($data);

        }
        else if($duty_status==2)
         {
            $distributor_id = $this->input->post('distributor_id');

            $resdata = $this->Sales->check_duty_data_by_distributor_sales($distributor_id);
           
            $duty_status1 = $resdata->duty_status;
         }

        if(!empty($data))
         {
            $data1->duty_status=$duty_status;
            $data1->messagedata=$data4;
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

    /*......... duty on/off Api For distributer  sales   ---- */

    /*......... logout Api For distributor sales  ---- */
        public function data_logout_for_distributor_sales_post()
     {
        $response = new StdClass();
        $result = array();
        $device_id =$this->input->post('device_id');
        $distributor_id =$this->input->post('distributor_id');
        $longitude =$this->input->post('longitude');
        $latitude=$this->input->post('latitude');
        date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
        $data3->device_id=$device_id;
        $data3->latitude = $latitude;
        $data3->longitude = $longitude;
        $data3->distributor_id = $distributor_id;
        $data->distributor_id = $distributor_id;
        $data3->duty_status ='0';
        $data3->status ='1';
        $data3->out_time =$now;
        $data->logout_time=$now;
        $resdata1 = $this->Sales->check_logout_data_distributor_sales($distributor_id);
        $device_id1 = $resdata1->device_id;
        if($distributor_id!='')
        {
        $data->distributor_id = $distributor_id;

        $data->logout_time=$now;
        $data2 = $this->Sales->logout_distributor_sales_data($data);
        $resdata1 = $this->Sales->insert_duty_status__for_distributor_sales($data3);

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

    /*......... logout Api For distributor sales ---- */



     /*.........List for particular hawker   ---- */
     public function today_updated_sales_list_for_hawker_post()
      {
        $response   =   new StdClass();
        $result       =   array();
        $sales_id =$this->input->post('sales_id');
        $show_list_by_hawker = $this->Sales->show_list_hawker_by_sales($sales_id);

        if(!empty($show_list_by_hawker))
        {
         foreach ($show_list_by_hawker as $row)
          {
            $data['name'] =   $row['name'];
            $data['mobile_no_contact'] =   $row['mobile_no_contact'];
            $data['hawker_code'] =   $row['hawker_code'];
            $data['registered_time'] =   $row['registered_time'];
            $data['status']  ='1';

            array_push($result,$data);

           } 
             // $response->status = '1';
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

      /*.........List for particular hawker  ---- */

      /*.........distributor location by gps Api for hawker ---- */

    public function distributor_location_by_gps_post()
     {
         $response = new StdClass();
         $result = new StdClass();
         $distributor_id=$this->input->post('distributor_id');
         $mobile_no=$this->input->post('mobile_no');
         $latitude  = $this->input->post('latitude');
         $longitude = $this->input->post('longitude');
         $device_id  = $this->input->post('device_id');
         $battery_status  = $this->input->post('battery_status');
         date_default_timezone_set('Asia/kolkata'); 
         $now = date('Y-m-d H:i:s');
         $nowes=date('Y-m-d');
         $data->distributor_id  = $distributor_id;
         $data->mobile_no  = $mobile_no;
         $data->latitude  = $latitude;
         $data->longitude = $longitude;
         $data->device_id = $device_id;
         $data->battery_status = $battery_status;
         $data->date_time = $now;
         $data->date=$nowes;
         $res = $this->Sales->distributor_location_for_gps($data);
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

    /*...... .distributor location by gps Api for hawker ---- */


    /*.........List for particular hawker   ---- */
     public function today_hawker_list_allowcated_post()
      {
        $response   =   new StdClass();
        $result       =   array();
        $pincode =$this->input->post('pincode');
        $sales_id =$this->input->post('sales_id');
        $device_id =$this->input->post('device_id');

        $get_lat_long_for_sales = $this->Sales->get_lat_long_for_sales_person($sales_id,$device_id);

        $latitudeFrom=$get_lat_long_for_sales->latitude;
        $longitudeFrom=$get_lat_long_for_sales->longitude;

        $show_list_by_hawker = $this->Sales->show_list_hawker_by_distributor($pincode);
        if(!empty($show_list_by_hawker))
        {
         foreach ($show_list_by_hawker as $row)
         {
            $catID=$row['cat_id'];
            $sub_cat_id=$row['sub_cat_id'];
            $shop_latitude=$row['shop_latitude'];
            $shop_longitude=$row['shop_longitude'];
            $string1 = explode(',', $sub_cat_id);
            if($sub_cat_id!='')
            {
               $sub_cat_name = $this->Sales->fetch_sub_cat_id_data($string1);
               //$sub_cat_name = $fetch_sub_cat_id->sub_cat_name;
            }
            else
            {
               $sub_cat_name ='';
            }
            $string = explode(',', $catID);
            if($catID!='')
            {
               $cat_name = $this->Sales->fetch_cat_id_data($string);
              
            }
            else
            {
               $catID ='';
            }
            $rad = M_PI / 180;
           //Calculate distance from latitude and longitude
            $theta = $longitudeFrom - $row['shop_longitude'];
            $dist = sin($latitudeFrom * $rad) 
                   * sin($row['shop_latitude'] * $rad) +  cos($latitudeFrom * $rad)
                   * cos($row['shop_latitude'] * $rad) * cos($theta * $rad);

            $distance= acos($dist) / $rad * 60 *  2.250;
            /*$distance=explode(', ',$distance); 
            rsort($distance);*/
            

            $data['distance'] = round($distance,2);
            $data['name'] =   $row['name'];
            $data['mobile_no_contact'] =   $row['mobile_no_contact'];
            $data['hawker_code'] =   $row['hawker_code'];
            $data['registered_time'] =   $row['registered_time'];
            $data['hawker_register_address'] =   $row['hawker_register_address'];
            $data['business_name'] =   $row['business_name'];
            $data['latitude'] =   $row['shop_latitude'];
            $data['longitude'] =   $row['shop_longitude'];
            $data['cat_id'] =   $catID;
            $data['cat_name'] =  $cat_name;
            $data['sub_cat_id'] =   $sub_cat_id;
            $data['sub_cat_name'] =  $sub_cat_name;
            $data['status']  ='1';

            array_push($result,$data);

           } 
             // $response->status = '1';
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

      /*.........List for particular hawker  ---- */

      /*.........List for particular hawker   ---- */
     public function full_hawker_list_detail_for_distributor_post()
      {
        $response   =   new StdClass();
        $result       =   array();
        $hawker_code =$this->input->post('hawker_code');
        $hawker_list_detail = $this->Sales->hawker_list_detail_data($hawker_code);
        if(!empty($hawker_list_detail))
        {
            $sales_id = $hawker_list_detail->sales_id;
            $Sales_name_fetch_data = $this->Sales->Sales_name_fetch($sales_id);
            
            $sales_name = $Sales_name_fetch_data->name;
            $hawker_code = $hawker_list_detail->hawker_code;
            $name = $hawker_list_detail->name;
            $mobile_no = $hawker_list_detail->mobile_no_contact;
            $gender = $hawker_list_detail->gender;
            $user_type = $hawker_list_detail->user_type;
            $phone_type = $hawker_list_detail->phone_type;
            $has_smart_phone = $hawker_list_detail->has_smart_phone;
            $business_name = $hawker_list_detail->business_name;
            $business_address = $hawker_list_detail->business_address;
            $hawker_register_address = $hawker_list_detail->hawker_register_address;
            $city = $hawker_list_detail->city;
            $cat_id = $hawker_list_detail->cat_id;
            $sub_cat_id = $hawker_list_detail->sub_cat_id;
            $latitude = $hawker_list_detail->shop_latitude;
            $longitude = $hawker_list_detail->shop_longitude;
            $registered_time = $hawker_list_detail->registered_time;
            $profile_image = $hawker_list_detail->profile_image;
            $aadhar_card_image = $hawker_list_detail->aadhar_card_image;
            $aadhar_card_image_back = $hawker_list_detail->aadhar_card_image_back;
            $address_proof = $hawker_list_detail->address_proof;
            $shop_image_1 = $hawker_list_detail->shop_image_1;
            $shop_image_2 = $hawker_list_detail->shop_image_2;
            $adhar_image_validation_status=$hawker_list_detail->adhar_image_validation_status;
            $shop_image_validation_status=$hawker_list_detail->shop_image_validation_status;

             $data1->Identity_validation_status =$adhar_image_validation_status;
             $data1->shop_image_validation_status =$shop_image_validation_status;
             $data1->sales_id =$sales_id;
             $data1->sales_name=$sales_name;
             $data1->hawker_code =$hawker_code;
             $data1->name =$name;
             $data1->mobile_no =$mobile_no;
             $data1->gender =$gender;
             $data1->user_type =$user_type;
             $data1->phone_type =$phone_type;
             $data1->has_smart_phone =$has_smart_phone;
             $data1->business_name =$business_name;
             $data1->business_address =$business_address;
             $data1->hawker_register_address =$hawker_register_address;
             $data1->city =$city;
             $data1->cat_id =$cat_id;
             $data1->sub_cat_id =$sub_cat_id;
             $data1->latitude =$latitude;
             $data1->longitude =$longitude;
             $data1->registered_time =$registered_time;
             $data1->profile_image =$profile_image;
             $data1->aadhar_card_image =$aadhar_card_image;
             $data1->aadhar_card_image_back =$aadhar_card_image_back;
             $data1->address_proof =$address_proof;
             $data1->shop_image_1 =$shop_image_1;
             $data1->shop_image_2 =$shop_image_2;
             $data1->status='1';
            array_push($result,$data1);
            $response->data = $data1;
          }
         else
         {
            $data1->status ='0';
            array_push($result,$data1);
         }
            $response->data = $data1;
           echo json_output($response);
        }

      /*.........List for particular hawker  ---- */

      /*.........update_hawker_registration_data Api ---- */
    public function update_hawker_registration_data_post()
    {   
        $response = new StdClass();
        $result2 = new StdClass();
        $hawker_code=$this->input->post('hawker_code');
        $name=$this->input->post('name');
        $user_type=$this->input->post('user_type');
        $mobile_no_contact=$this->input->post('mobile_no_contact');
        $hawker_register_address=$this->input->post('hawker_register_address');
        $city=$this->input->post('city');
        $aadhar_card_image=$this->input->post('aadhar_card_image');
        $aadhar_card_image_back=$this->input->post('aadhar_card_image_back');
        $shop_image_1=$this->input->post('shop_image_1');
        $shop_image_2=$this->input->post('shop_image_2'); 
        $distribute_image_1=$this->input->post('distribute_image_1'); 
        $distribute_image_2=$this->input->post('distribute_image_2'); 
        $distribute_status=$this->input->post('distribute_status');
        $shop_latitude=$this->input->post('shop_latitude');
        $shop_longitude=$this->input->post('shop_longitude');  
        $distributor_id=$this->input->post('distributor_id');
        $sPin=$this->input->post('sPin');
        date_default_timezone_set('Asia/kolkata'); 
        $now = date('Y-m-d H:i:s');
        $nows = date('Y-m-d');
        $distribute_type=$this->input->post('distribute_type');
        $quantity=$this->input->post('quantity');
        $detail=$this->input->post('detail');
        $getcity_by_pincode = $this->Sales->get_city_by_pinocde($sPin);
        $getcity=$getcity_by_pincode->city;
        if(empty($getcity))
        {
            $getcity1=$city;
        }
        else
        {
           $getcity1=$getcity;
        }
        $data->distributor_id =$distributor_id;
        $data->hawker_code=$hawker_code;
        $data->name=$name;
        $data->user_type=$user_type;
        $data->mobile_no_contact=$mobile_no_contact;
        $data->hawker_register_address=$hawker_register_address;
        $data->city=$getcity1;
        $data->aadhar_card_image=$aadhar_card_image;
        $data->aadhar_card_image_back=$aadhar_card_image_back;
        $data->shop_image_1=$shop_image_1;
        $data->shop_image_2=$shop_image_2;
        $data->distribute_image_1=$distribute_image_1;
        $data->distribute_image_2=$distribute_image_2;
        $data->shop_latitude =$shop_latitude;
        $data->shop_longitude =$shop_longitude;
        $data->registered_time=$now;
        $data->date_time=$nows;
        $data->sPin=$sPin;
        $data->distribute_status=$distribute_status;
        $data->distribute_type=$distribute_type;
        $data->quantity=$quantity;
        $data->detail=$detail;

        /*$data_res->distribute_status=$distribute_status;
        $data_res->mobile_no_contact=$mobile_no_contact;
        $data_reg->mobile_no_contact=$mobile_no_contact;
        $data_reg->aadhar_card_image=$aadhar_card_image;
        $data_reg->aadhar_card_image_back=$aadhar_card_image_back;
        $data_reg->shop_image_1=$shop_image_1;
        $data_reg->shop_image_2=$shop_image_2;
        $data_reg->distribute_image_1=$distribute_image_1;
        $data_reg->distribute_image_2=$distribute_image_2;
    
        $updatehawkerdata = $this->Sales->updatehawkerdata($data_res);
        $updatehawkerdata_img = $this->Sales->updatehawkerdata_img($data_reg);*/
        $result = $this->Sales->add_data($data);
        if(!empty($result))
        { 
            $data1->status ='1';
            $data1->message = 'register Success';
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
       
      echo  json_output($response);
    }
   /*.........update_hawker_registration_data  Api  ---- */


   /*.........Hawker history detail ---- */
     public function distributor_history_details_post()
      {
        $response   =   new StdClass();
        $result       =   array();
        $distributor_id =$this->input->post('distributor_id');
        $distributor_detail_history_for_hawker = $this->Sales->show_history_for_hawker($distributor_id);
        if(!empty($distributor_detail_history_for_hawker))
        {
         foreach ($distributor_detail_history_for_hawker as $row)
         {

            $data['name'] =   $row['name'];
            $data['mobile_no_contact'] =   $row['mobile_no_contact'];
            $data['distribute_image_1'] =   $row['distribute_image_1'];
            $data['distribute_image_2'] =   $row['distribute_image_2'];
            $data['time'] =   $row['registered_time'];
            $data['status']  ='1';
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

      /*........Hawker history detail  ---- */


    /* .......... Notification Api for near by list for hawker ...............*/

    public function notification_for_near_by_hawker_post()
      {
        $response   =   new StdClass();
        $result       =   array();
        $sales_id =$this->input->post('sales_id');
        $device_id =$this->input->post('device_id');
        $latitudeFrom=$this->input->post('latitude');
        $longitudeFrom=$this->input->post('longitude');
        $radius='0.1';
        $show_list_by_hawker = $this->Sales->show_list_hawker_by_distributor_notification();
        if(!empty($show_list_by_hawker))
        {
         foreach ($show_list_by_hawker as $row)
         {
            $catID=$row['cat_id'];
            $sub_cat_id=$row['sub_cat_id'];
            $shop_latitude=$row['shop_latitude'];
            $shop_longitude=$row['shop_longitude'];
            $string1 = explode(',', $sub_cat_id);
            if($sub_cat_id!='')
            {
             $sub_cat_name = $this->Sales->fetch_sub_cat_id_data($string1);
               //$sub_cat_name = $fetch_sub_cat_id->sub_cat_name;
            }
            else
            {
               $sub_cat_name ='';
            }
            $string = explode(',', $catID);
            if($catID!='')
            {
               $cat_name = $this->Sales->fetch_cat_id_data($string);
              
            }
            else
            {
               $catID ='';
            }
            $rad = M_PI / 180;
           //Calculate distance from latitude and longitude
            $theta = $longitudeFrom - $row['shop_longitude'];
            $dist = sin($latitudeFrom * $rad) 
                   * sin($row['shop_latitude'] * $rad) +  cos($latitudeFrom * $rad)
                   * cos($row['shop_latitude'] * $rad) * cos($theta * $rad);

            $distance= acos($dist) / $rad * 60 *  2.250;
            $get_notification_id = $this->Sales->get_notification_id_for_sales($sales_id);
            $notification_id=$get_notification_id->notification_id;
           
            if($distance<=$radius)
            {
            $distancedata = round($distance,2);
            $name =   $row['name'];
            $mobile_no_contact =   $row['mobile_no_contact'];
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
            $title ='Near By Hawker';
            // notification message
            $message = $name.' '.$distancedata;

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
            
             /*$data['distance'] = round($distance,2);
             $data['name'] =   $row['name'];
             $data['mobile_no_contact'] =   $row['mobile_no_contact'];
             $data['hawker_code'] =   $row['hawker_code'];
             $data['registered_time'] =   $row['registered_time'];
             $data['hawker_register_address'] =   $row['hawker_register_address'];
             $data['business_name'] =   $row['business_name'];
             $data['latitude'] =   $row['shop_latitude'];
             $data['longitude'] =   $row['shop_longitude'];
             $data['cat_id'] =   $catID;
             $data['cat_name'] =  $cat_name;
             $data['sub_cat_id'] =   $sub_cat_id;
             $data['sub_cat_name'] =  $sub_cat_name;*/
             $data['status']  ='1';
             array_push($result,$data);
             $response->data = $data;
            }
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


    /* .......... Notification Api for near by list for hawker ...............*/
      
  public function CoveredDistanceBysales_get()
  {
    
    $currentdate=date('Y-m-d');
    $result=$this->Sales->getRegisteredHawkersBysales($currentdate);
    // print_r($result);exit;
    for($i=0;$i<=count($result)-1;$i++)
    {

     $sales_id          =$result[$i]['sales_id'];
     $shop_latitude     =$result[$i]['shop_latitude'];
     $shop_longitude    =$result[$i]['shop_longitude'];
     $mobile_no_contact =$result[$i]['mobile_no_contact'];
     $registered_time1  =strtotime($result[$i]['registered_time']);
     $registered_time2  =strtotime($result[$i+1]['registered_time']);
     $date_time         =$result[$i]['date_time'];
     if(count($result)==1)
	{
		$intervalInMinutes=0;
     		$distance=calculateDistanceNew('28.40687271','77.04216008',$result[$i]['shop_latitude'],$result[$i]['shop_longitude']);
     		$array[]=array(
          		'sales_id'            =>$sales_id,
          		'distance'            =>$distance,
          		'date_time'           =>$currentdate,
			'registered_time'     =>date('Y-m-d H:i:s'),
			'mobile_no_contact'   =>$mobile_no_contact
     			);

	}else
	{
		$intervalInMinutes=($registered_time2-$registered_time1)/60;
     		$distance=calculateDistanceNew($result[$i]['shop_latitude'],$result[$i]['shop_longitude'],$result[$i+1]['shop_latitude'],$result[$i+1]['shop_longitude']);
     		$array[]=array(
          		'sales_id'            =>$sales_id,
          		'distance'            =>$distance,
	                'registered_time'     =>date('Y-m-d H:i:s'),
          		'date_time'           =>$currentdate,
                        'mobile_no_contact'   =>$mobile_no_contact
     			);


	}
     

    }
//echo '<pre>';print_r($array);exit;

        if(!empty($array))
        {

                  $last_inserted_id=$this->Sales->insertDistanceCalculatedperDay($array);
                  if($last_inserted_id)
                  {
                    $arry=array('status'=>'1','message'=>'Data inserted successfully');
                    $this->response($arry, 200);
                  }
          }else
          {
                  $arry=array('status'=>'0','message'=>'Record not inserted');
                  $this->response($arry, 200);
          }
        // echo '<pre>';print_r($array);exit;
          }

        public function checkLocation_post()
        {

          $sPin=$this->input->post('sPin');
          $city=$this->input->post('city');
          $cityData=$this->Sales->get_city_data($sPin,$city);
          try
          {
              if(empty($cityData))
              {
                      $arry['data']=array('status'=>'0','message'=>'Coming Soon in your area. Currently this service is active in Gurgaon only.');
                      $this->response($arry, 200);
                      
              }else
              {
                      $arry['data']=array('status'=>'1','message'=>'success');
                      $this->response($arry, 200);
              }
          }catch( Eception $e)
          {
             echo $e->getMessage();
            $error = array('status' =>'0', "message" => "Internal Server Error - Please try Later.","StatusCode"=> "HTTP405");
            $this->response($error, 200);
          }
          
      }

   }
