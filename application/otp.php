<?php	

$res=array();		

include_once 'dbConnect.php';

	$searchingProduct=$_REQUEST['searchingProduct'];

	$location=$_REQUEST['location'];

	$mobile_Number=$_REQUEST['mobile_Number'];

	$otp=$_REQUEST['otp'];

	$otpValue=rand(1,100000);

	$vendorID=$_REQUEST['vendorID'];

	if($otp == '')

	{

		$insertQuery="INSERT INTO tbl_booking_otp SET mobile='$mobile_Number',otp='$otpValue'";

		mysqli_query($conn,$insertQuery);

     

	  $messages=$otpValue." is OTP for Repair India service verification. Please enter this OTP to avail services.";



			

							$pass="dk999vZ9";

							$myUrl="http://103.247.98.91/API/SendMsg.aspx";

							$mobile=$mobile_Number;

							$data=array(

										'uname'=>'20180213',

										'pass'=>$pass,

										'send'=>'REPAIR',

										'dest'=>$mobile,

										'msg'=>$messages,

										'priority'=>1

									  );

									  $ch = curl_init();

										curl_setopt($ch, CURLOPT_URL, $myUrl);

										curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

										curl_setopt($ch, CURLOPT_POST, 1);

										curl_setopt($ch, CURLOPT_HEADER, 0);

										curl_setopt($ch, CURLOPT_VERBOSE, 0);

										curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

										$result = curl_exec($ch);

										curl_close($ch);

										$res['message']='otpSend';

										$res['text']='<h5>Repair India - OTP for your {'.$searchingProduct.'} is {'.$mobile.'}</h5>';

	}

	else

	{
		$query="SELECT * FROM tbl_booking_otp WHERE otp='$otp' and mobile='$mobile_Number'";

		$result=mysqli_query($conn,$query);

		$numrow=mysqli_num_rows($result);

		if($numrow>0)

		{

			$queryUser="SELECT * FROM dhs_users WHERE userID='$vendorID' AND status=1";



      $resultUser=mysqli_query($conn,$queryUser);



      $rowUser=mysqli_fetch_array($resultUser);

      $name=$rowUser['name'];

      $mobiledata=$rowUser['mobile'];

      date_default_timezone_set('Asia/Kolkata');

      $currentDateTime=date('H:i:s m/d/Y ');

      $newDateTime = date('h:i A m/d/Y', strtotime($currentDateTime));

      $mobadmin="9212322322";



      $datamsg1 = 'Your Request for '. $searchingProduct . ' has been sent to Service Partner ' . $name . ' ' . $mobiledata . ". Please contact him if you don't hear| www.repairindia.in";



    



                            $pass="dk999vZ9";

							$myUrl="http://103.247.98.91/API/SendMsg.aspx";

							$mobile=$mobile_Number;

							$data1=array(

										'uname'=>'20180213',

										'pass'=>$pass,

										'send'=>'REPAIR',

										'dest'=>$mobile,

										'msg'=>$datamsg1,

										'priority'=>1

									  );

									  $ch = curl_init();

										curl_setopt($ch, CURLOPT_URL, $myUrl);

										curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

										curl_setopt($ch, CURLOPT_POST, 1);

										curl_setopt($ch, CURLOPT_HEADER, 0);

										curl_setopt($ch, CURLOPT_VERBOSE, 0);

										curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);

										$result = curl_exec($ch);



										curl_close($ch);



       $datamsg2=$mobile_Number. ' ' . $searchingProduct . ". Forwarded to Service Partner " . $name . ' ' . $mobiledata . " - Time Date";



      		                $pass="dk999vZ9";

							$myUrl="http://103.247.98.91/API/SendMsg.aspx";

					

							$data2=array(

										'uname'=>'20180213',

										'pass'=>$pass,

										'send'=>'REPAIR',

										'dest'=>$mobadmin,

										'msg'=>$datamsg2,

										'priority'=>1

									  );

									  $ch = curl_init();

										curl_setopt($ch, CURLOPT_URL, $myUrl);

										curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

										curl_setopt($ch, CURLOPT_POST, 1);

										curl_setopt($ch, CURLOPT_HEADER, 0);

										curl_setopt($ch, CURLOPT_VERBOSE, 0);

										curl_setopt($ch, CURLOPT_POSTFIELDS, $data2);

										$result = curl_exec($ch);

										

										curl_close($ch);



		$datamsg3='Call Immed on '. $mobile_Number . ' for ' .$searchingProduct . " Thanks! Repair India";



		                    $pass="dk999vZ9";

							$myUrl="http://103.247.98.91/API/SendMsg.aspx";

					

							$data3=array(

										'uname'=>'20180213',

										'pass'=>$pass,

										'send'=>'REPAIR',

										'dest'=>$mobiledata,

										'msg'=>$datamsg3,

										'priority'=>1

									  );

									  $ch = curl_init();

										curl_setopt($ch, CURLOPT_URL, $myUrl);

										curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

										curl_setopt($ch, CURLOPT_POST, 1);

										curl_setopt($ch, CURLOPT_HEADER, 0);

										curl_setopt($ch, CURLOPT_VERBOSE, 0);

										curl_setopt($ch, CURLOPT_POSTFIELDS, $data3);

										$result = curl_exec($ch);

										curl_close($ch);


			$insertQuery="INSERT INTO dhs_bookings SET vendorID='$vendorID',mobile='$mobile_Number',locality='$location',search_value='$searchingProduct',status=1,added=NOW()";

			mysqli_query($conn,$insertQuery);

			$deleteQuery="DELETE FROM tbl_booking_otp WHERE otp='$otp' and mobile='$mobile_Number'";

			$deleteResult=mysqli_query($conn,$deleteQuery);



			



			$res['message']='success';

			$res['text']='<h5>Thank you for Ordering with Repair India.</h5>';	

		}

		else

		{

			$res['message']='fail';

			$res['text']='<h5>Invalid otp Number.</h5>';

		}

		

	}

	echo json_encode($res);

?>		