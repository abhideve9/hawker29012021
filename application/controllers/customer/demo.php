<?php
  public function authentication_data_get()
   {
		//$response = new StdClass();
   		$gateway_id =$this->input->get('gateway_id');
		date_default_timezone_set('Asia/kolkata'); 
        $now = date("Y-m-d H:i:s", strtotime("-1 seconds"));
        $now3 = date("Y-m-d H:i:s", strtotime("-1 seconds"));
        $now2 = date("Y-m-d H:i:s");
        $now1 = date("Y-m-d H:i:s", strtotime("+1 seconds"));
        $que=$this->db->query("select * from door_open_mw where gateway_id='".$gateway_id."' and ibeaconMajor='1' and   time='".$now."' or time='".$now3."' or time='".$now2."' or time='".$now1."' order by id desc");
		/*$data->time=$now;
		$que=$this->db->query("select * from door_open_mw where gateway_id='".$gateway_id."' and ibeaconMajor='1' and time='".$now."' order by id desc");*/
		print_r("select * from door_open_mw where gateway_id='".$gateway_id."' and ibeaconMajor='1' and   time='".$now."' whereor time='".$now3."' whereor time='".$now2."' whereor time='".$now1."' order by id desc");
		die();
	/*	$myfile4 = file_put_contents("stat_mw.txt",PHP_EOL.$que.,FILE_APPEND | LOCK_EX);*/
        $row = $que->num_rows();
        if($row>0)
        {
			echo $status = '1';
		}
		else
		{
			echo $status ='0';

		}
		 
    }
	 /*......... Get data From Wifi-module Api For Door Unlock ---- */
