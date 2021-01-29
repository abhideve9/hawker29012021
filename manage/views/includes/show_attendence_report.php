<?php
include 'db.php';
error_reporting(0); 
/*if(isset($_POST["submit"]))
    {
    $sum = 0;
    $count =1;
    $designationdata = [];
    $designation12 = [];
    $joindate = $_POST['joindate'];
    $todate = $_POST['todate'];
    $sales=$_POST['sales'];
    $city=$_POST['city'];

 if($city!='')
  {
$getUsers="SELECT * FROM registration_sellers where date_time 
    between '".$joindate."' and '".$todate."'  and sales_id='$sales' and city='$city' and (verification_status =1 or  verification_by_call = 1) order by registered_time ASC";
  }
  else
  {
    $getUsers="SELECT * FROM registration_sellers where date_time 
    between '".$joindate."' and '".$todate."'  and sales_id='$sales' and (verification_status =1 or  verification_by_call = 1) order by registered_time ASC";
  }


     $runUsers=mysqli_query($db,$getUsers);
     $start = array('28.40687271,77.04216008');
     $arr = array();
     $designation2 = [];
     while ($rowUsers=mysqli_fetch_array($runUsers))
     {

       $designationdata[] = $rowUsers["shop_latitude"] .','.$rowUsers["shop_longitude"]; 
      $designation2[] = $rowUsers;
     }
      $designation12= array_merge($start,$designationdata);
      
      function totaldata($n,$designation12)
      {
        $arr = array();
        $arr['start'] = $designation12[$n];
        if($n < 0)
        {
        $arr['end'] = $designation12[$n-1];

        }
        else
        {
          $arr['end'] = $designation12[$n+1];
          if($designation12[$n+1] == '')
          {
            $arr['end'] = "28.40687271,77.04216008";
          }

        }

        $arr['start1'] = $designation12[$n+1];
        if($designation12[$n+1] == '')
        {
        $arr['start1'] = "28.40687271,77.04216008";

        }
        return $arr;

      }
      $count = count($designation12);
      //print_r($count);
      $a =0;
      //$data = array();
    

      for($j=0; $j<$count-1; $j++)
      {
        //print_r($j)
        $a = $j;
        //print_r($a);
        $data = totaldata($a,$designation12);
        //print_r($data);
        $latLong = explode(",", $data['start']);
        $latLongEnd = explode(",", $data['end']);
        $newStart = explode(",", $data['start1']);
        $latLong = explode(",", $data['start']);
        if($j < 0)
        {
          $latLong = explode(",", $data['start1']);

        }
        
        $latitudeFrom = $latLong[0];
        $longitudeFrom = $latLong[1]; 
        $shop_latitude = $latLongEnd[0];
        $shop_longitude = $latLongEnd[1];
         $rad = M_PI / 180;
   //Calculate distance from latitude and longitude
          $theta = $longitudeFrom - $shop_longitude;
          $dist = sin($latitudeFrom * $rad) 
     * sin($shop_latitude * $rad) +  cos($latitudeFrom * $rad)
     * cos($shop_latitude * $rad) * cos($theta * $rad);
     $distance= acos($dist) / $rad * 60 *  2.250;
    
    $distance_calculate =round($distance,2);
        
      $sum+=(float)($distance_calculate);
   }

      
      
    }

  $sum1=$sum;*/
  ?> 
  <!-- page content -->
       <form method="post" action="" enctype="multipart/form-data">
     <div class="x_panel table-responsive">
     
          <table  class="table table-bordered jambo_table bulk_action">
              <thead class="thead-light">
                 <tr>
                     <th>From Date</th>
                     <th>To Date</th>
                     <th >Sales Person</th>
                     <th >City</th>
                     <th>Action</th>
                 </tr>
            </thead>
            <tbody>
            <tr>   
                   <td ><input  type="date" name="joindate" required  id="date"  value="<?php if($_POST['joindate']==''){echo date('Y-m-d');}  else {echo $_POST['joindate'] ;}  ?>"></td>

                    <td ><input  type="date" name="todate" required   id="date"  value="<?php if($_POST['todate']==''){echo date('Y-m-d');}  else {echo $_POST['todate'] ;}  ?>"></td>

                   <td><select id="cat1" class="form-control" width="25px" style="width: 90% !important;" name="sales" required>
                       <option value="">Select Sales Person
                        <?php
                            $get_cats = "select name,sales_id from registration_sales";
                            $run_cats = mysqli_query($db, $get_cats);
                            while($row_cats=mysqli_fetch_array($run_cats))
                            {
                              $sales_id=$row_cats['sales_id'];
                              $name = $row_cats['name'];
                              echo "<option value='$sales_id'>$name</option>";
                            }
                          ?>
                      </option>
                          </select>
                    </td>
                    <td><select id="cat1" class="form-control" width="25px" style="width: 90% !important;" name="city">
                       <option value="">All
                        <?php
                            $get_cats = "select * from city_state_code where active_status='1'";
                            $run_cats = mysqli_query($db, $get_cats);
                            while($row_cats=mysqli_fetch_array($run_cats))
                            {
                              //$sales_id=$row_cats['sales_id'];
                              $city = $row_cats['city'];
                              echo "<option value='$city'>$city</option>";
                            }
                          ?>
                      <!--   <option value=Gurugram>Gurugram</option>"; -->
                      </option>
                          </select>
                    </td>
                   <td><input  type="submit" id="sendNewSms1" name="submit" value="Submit"/></td>
                
            </tr>
            
         </tbody>
      </table>
     </div>  
     <?php
     if(isset($_POST["submit"]))
     {
      $sales_id=$_POST['sales'];
     $joindate = $_POST['joindate'];
     $todate = $_POST['todate'];
     $get_cats = "SELECT SUM(distance) AS value_sum  from tbl_add_distance_for_sale where sales_id='$sales_id' and  date_time between '".$joindate."' and '".$todate."'";
 // echo $get_cats;
  
     $run_cats = mysqli_query($db, $get_cats);
     $row_cats=mysqli_fetch_array($run_cats);
     $distancedata=$row_cats['value_sum'];
     $disy=(float)($distancedata);
     $distance_calculate =round($disy,2);
     }
      
     ?>
 <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Total KM : <?php echo  $distance_calculate; ?><small> </small></h2>

                    <ul class="nav navbar-right panel_toolbox">
                     <li style="float: right !important;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                     </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content table-responsive">
                   
                    <table id="peopleindex" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
                      <thead>
                        <tr>
                          <th>S.no</th>
                          <th>Sales Person </th>
                          <th>Hawker Name </th>
                          <th>Hawker Type </th>
                          <th>Mobile Number </th>
                          <th>Registration Time </th>
                          <th>Shop Name </th>
                          <th>Shop Address</th>
                          <th>KM</th>
                          <th>City</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        if(isset($_POST["submit"]))
                        {
                        $count =1;
                        $joindate = $_POST['joindate'];
                        $todate = $_POST['todate'];
                        date_default_timezone_set('Asia/kolkata'); 
                        $now = date('Y-m-d');
                        if($joindate>=$now)
                        {
                        ?>
                        <script>
                        alert("Please Select Correct date format");
                        location.href="action.php?action=show_attendence_report";
                      </script>
                          <?php
                        }
                        else if($joindate >$todate)
                        {
                          ?>
                          <script>
                        alert("Please Select Correct date format");
                        location.href="action.php?action=show_attendence_report";
                      </script>
                        <?php
                        }
                        $sales=$_POST['sales'];
                        $city=$_POST['city'];
                        if($city!='')
                        {
                        $getUsers="SELECT * FROM registration_sellers a inner join tbl_add_distance_for_sale b on a.mobile_no_contact=b.mobile_no_contact where a.date_time between  '".$joindate."' and '".$todate."' and a.sales_id='$sales' and (a.verification_status =1 or a.verification_by_call = 1) and a.city='$city' order by a.registered_time ASC";
                        }
                        else
                        {
                           $getUsers="SELECT * FROM registration_sellers a inner join tbl_add_distance_for_sale b on a.mobile_no_contact=b.mobile_no_contact where a.date_time between  '".$joindate."' and '".$todate."' and a.sales_id='$sales' and (a.verification_status =1 or a.verification_by_call = 1) order by a.registered_time ASC";

                        }
                         $runUsers=mysqli_query($db,$getUsers);
                         while ($rowUsers=mysqli_fetch_array($runUsers))
                        {
                        $sales_id=$rowUsers['sales_id'];
                        $query1="SELECT name FROM login_manage_sales WHERE user_id='$sales_id'";
                     
                        $run_type1 = mysqli_query($db, $query1);
                        $row_type1=mysqli_fetch_array($run_type1);
                        $name=$row_type1['name'];
                        $id=$rowUsers['id'];
                        $hawker_name=$rowUsers['name'];
                        $user_type=$rowUsers['user_type'];
                        $mobile_no_contact=$rowUsers['mobile_no_contact'];
                        $business_name=$rowUsers['business_name'];
                        $business_address=$rowUsers['business_address'];
                        $city_address=$rowUsers['city_address'];
                        $registered_time=$rowUsers['registered_time'];
                        $distance=$rowUsers['distance'];
                        ?>
                          <tr class='odd gradeX'>
                          <td><?php echo $count; ?></td>
                          <td><?php echo $name; ?></td>
                          <td><?php echo $hawker_name; ?></td>
                          <td><?php echo $user_type; ?></td>
                          <td><?php echo $mobile_no_contact; ?></td>
                          <td><?php echo $registered_time; ?></td>
                          <td><?php echo $business_name; ?></td>
                          <td><?php echo $business_address; ?></td>
                          <td><?php echo $rowUsers['distance']?></td>
                          <td><?php echo $city_address; ?></td>
                          </tr>
                          <?php
                          $count++;
                          }
                         }
                         ?> 
                      </tbody>

                    </table>
                  </div>
                </div>
              </div>
 </form>

        <!-- /page content -->

<script>
   $(document).ready(function(){
    if($(".btn-icon").hasClass("btn-warning"))
    {
      $("#iconName").val($(".btn-warning").val());
    }
  });
  $("#hours").change(function(){
      var opt=$("#hours").val();
      if(opt==1)
      {
        $("#othersDiv").show();
      }
      else{
        $("#othersDiv").hide();
      }
  });
   $(document)
    .ready(function () {
        $('#peopleindex').dataTable({

            "autoWidth": false,
            "lengthChange": false,
            "pageLength": 100,
               dom: 'Bfrtip',
              buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]

        });
});
</script>