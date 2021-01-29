<?php
 include 'db.php';
       if (isset($_REQUEST['id']))
       {
       $id=$_REQUEST['id'];
       $getUsers="SELECT * FROM registration_sellers where id='$id'";
       $runUsers=mysqli_query($db,$getUsers);
       while($rowUsers=mysqli_fetch_array($runUsers))
       {
       $id=$rowUsers['id'];
       $sales_id=$rowUsers['sales_id'];
       $Name=$rowUsers['name'];
       $Hawker_type=$rowUsers['user_type'];
       $HawkerCode=$rowUsers['hawker_code'];
       $mobile_number=$rowUsers['mobile_no_contact'];
       $business_name=$rowUsers['business_name'];
       $city_address=$rowUsers['city_address'];
       $shop_id=$rowUsers['shop_id'];
       $gender=$rowUsers['gender'];
       $Name_type=$rowUsers['name_type'];
       $Address=$rowUsers['address'];
       $mobile_number_type=$rowUsers['mobile_no_type'];
       $smart_phone=$rowUsers['has_smart_phone'];
       $business_start_time=$rowUsers['business_start_time'];
       $business_close_time=$rowUsers['business_close_time'];
       $shop_name=$rowUsers['shop_name'];
       $business_address=$rowUsers['business_address'];
       $business_mobile_no=$rowUsers['business_mobile_no'];
       $business_mobile_no=$rowUsers['business_mobile_no'];
       $gst_no=$rowUsers['gst_no'];
       $day_of_duty=$rowUsers['day_of_duty'];
       $application_type=$rowUsers['application_type'];
       $verification_by_call=$rowUsers['verification_by_call'];
       $registered_time=$rowUsers['registered_time'];
       $duty_status=$rowUsers['duty_status'];
       $userQuery="SELECT name FROM registration_sales WHERE sales_id='$sales_id'";
       $userResult=mysqli_query($db,$userQuery);
       $userRow=mysqli_fetch_array($userResult);
       $name=ucfirst($userRow['name']);
       ?>
 <div class="table-responsive">
 <table class="table table-striped table-bordered">
 <tr>
 <th>Registration Time</th>
 <td><?php echo $registered_time; ?></td>
 </tr>
<tr>
 <th>Duty Status</th>
 <td><?php echo $duty_status; ?></td>
 </tr>
 <tr>
 <th>Add By Sales Person</th>
 <td><?php echo $name; ?></td>
 </tr>
 <tr>
 <th>Name</th>
 <td><?php echo $Name; ?></td>
 </tr>
 <tr>
 <th>Hawker Type</th>
 <td><?php echo ucfirst($Hawker_type); ?></td>
 </tr>
 <tr>
 <th>Hawker Code</th>
 <td><?php echo ucfirst($HawkerCode); ?></td>
 </tr>
 <tr>
 <th>Gender</th>
 <td><?php echo ucfirst($gender); ?></td>
 </tr>
 <tr>
 <th>Type</th>
 <td><?php echo ucfirst($Name_type); ?></td>
 </tr>
 <tr>
 <th>Address</th>
 <td><?php echo ucfirst($Address); ?></td>
 </tr>
 <tr>
 <th>Mobile Number</th>
 <td><?php echo $mobile_number; ?></td>
 </tr>
 <tr>
 <th>Has Smart Phone</th>
 <td><?php echo ucfirst($smart_phone); ?></td>
 </tr>
 <tr>
 <th>Business start Time</th>
 <td><?php echo ucfirst($business_start_time); ?></td>
 </tr>
 <tr>
 <th>Business Close Time</th>
 <td><?php echo ucfirst($business_close_time); ?></td>
 </tr>
 <tr>
 <th>Business Name</th>
 <td><?php echo ucfirst($business_name); ?></td>
 </tr>
 <tr>
 <th>Shop Address</th>
 <td><?php echo ucfirst($business_address); ?></td>
 </tr>
 <tr>
 <th>Shop Mobile number</th>
 <td><?php echo ucfirst($business_mobile_no); ?></td>
 </tr>
 <?php
 if($gst_no!=''){ ?>
 <tr>
 <th>GST Number</th>
 <td><?php echo ucfirst($gst_no); ?></td>
 </tr>
<?php } ?>
 <tr>
 <th>Day Of Duty</th>
 <td><?php echo ucfirst($day_of_duty); ?></td>
 </tr>
 <tr>
 <th>Application Type</th>
 <td><?php echo ucfirst($application_type); ?></td>
 </tr>
 <tr>
 <th>Verification By Call</th>
 <td><?php if($verification_by_call==1) echo 'Yes'; else echo 'No' ?></td>
 </tr>
 </table>
   
 </div>
   
 <?php    
}
}
?>