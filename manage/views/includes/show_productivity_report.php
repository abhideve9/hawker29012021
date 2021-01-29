<?php
include 'db.php';
error_reporting(0); 
?>
  <!-- page content -->
       <form method="post" action="" enctype="multipart/form-data">
     <div class="x_panel table-responsive">
     
          <table class="table table-bordered jambo_table bulk_action">
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
                    
                    <td><select id="cat1" class="form-control" width="25px" style="width: 90% !important;" name="city" >
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
 <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Actions<small></small></h2>

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
                          <th style="width:90px!important;">Sales Person </th>
                          <th style="width:90px!important;">Total Verified Hawker</th>
                          <th style="width:90px!important;">Total Unverified Hawker</th>
                          <th style="width:90px!important;">Total Km</th>
                          <th style="width:90px!important;">Total time Utilization</th>
                          <th style="width:90px!important;">Verified Hawker/Hours </th>
                          <th>Verified Hawker/KM </th>
                          <!-- <th>Shop Name </th>
                          <th>Shop Address</th>
                          <th>KM</th>
                          <th>City</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        if(isset($_POST["submit"]))
                        {
                        $count =1;
                        $sum = 0;
                        $joindate = $_POST['joindate'];
                        $todate = $_POST['todate'];
                        date_default_timezone_set('Asia/kolkata'); 
                        $now = date('Y-m-d');
                        if($joindate>=$now)
                        {

                      
                        ?>
                        <script>
                        alert("Please Select Correct date format");
                        location.href="action.php?action=show_productivity_report";
                      </script>
                          <?php
                        }
                        else if($joindate >$todate)
                        {
                          ?>
                          <script>
                        alert("Please Select Correct date format");
                        location.href="action.php?action=show_productivity_report";
                      </script>
                        <?php
                        }
                        $sales=$_POST['sales'];
                        $city=$_POST['city'];
                      if($city!='')
                        {
                       $querydata="SELECT * FROM registration_sellers where date_time 
                          between '".$joindate."' and '".$todate."'  and sales_id='$sales' and city='$city' and verification_status =0  and  verification_by_call = 0 order by registered_time ASC";
                        }
                        else
                        {
                           $querydata="SELECT * FROM registration_sellers where date_time 
                          between '".$joindate."' and '".$todate."'  and sales_id='$sales' and  verification_status =0  and  verification_by_call = 0 order by registered_time ASC";
                        }
                        $run_type2 = mysqli_query($db, $querydata);
                         $count1=mysqli_num_rows($run_type2);
                          $get_cats = "SELECT SUM(distance) AS value_sum  from tbl_add_distance_for_sale where sales_id='$sales' and  date_time between '".$joindate."' and '".$todate."'";
                         $run_cats = mysqli_query($db, $get_cats);
                         $row_cats=mysqli_fetch_array($run_cats);
                         $distancedata=$row_cats['value_sum'];
                         $disy=(float)($distancedata);
                         $distance_calculate =round($disy,2);     

                         $getdata = "SELECT SUM(time_interval) AS value_time  from tbl_add_distance_per_days where sales_id='$sales' and  create_date between '".$joindate."' and '".$todate."'";
                         $rundata = mysqli_query($db, $getdata);
                         $rowdata=mysqli_fetch_array($rundata);
                         $timeinterval=$rowdata['value_time'];
                         $hours=floor($timeinterval / 60);
                         $minutes = ($timeinterval % 60);
                         $data=$hours .' hours'.$minutes.' minutes';


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
                         $count=mysqli_num_rows($runUsers);
                         $per_hours_verified_hawker=$count*60/$timeinterval;
                         //$per_hours_verified_hawker=$count/$hours;
                         $per_hours_verified_hawker1 =round($per_hours_verified_hawker,2);
                         if ($count=='0') {
                        $per_hours_verified_hawker2='0';
                          }
                         else
                         {
                          $per_hours_verified_hawker2 =round($per_hours_verified_hawker,2);
                         }
                         $per_km_verified_hawker=$count/$distance_calculate;
                         $per_km_verified_hawker1=round($per_km_verified_hawker,2);
                         if($count=='0')
                         {
                           $per_km_verified_hawker1='0';
                         }
                         else
                         { $per_km_verified_hawker1=round($per_km_verified_hawker,2);
                         }

                      
                        $query1="SELECT name FROM login_manage_sales WHERE user_id='$sales'";
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
                          ?>
                          <tr class='odd gradeX'>
                          <td><?php echo $name; ?></td>
                          <td><?php echo $count; ?></td>
                          <td><?php echo $count1; ?></td>
                          <td><?php echo $distance_calculate; ?></td>
                          <td><?php echo $data;?></td>
                          <td><?php echo $per_hours_verified_hawker2; ?></td>
                          <td><?php echo $per_km_verified_hawker1; ?></td>
                          </tr>
                          <?php
                         $count++; }
                         
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