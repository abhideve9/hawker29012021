<?php
include 'db.php';
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
                     <th>Hawker Type</th>
                     <th>Verified/Unverified Hawker</th>
                     <th >City</th>

                     <th>Action</th>
                 </tr>
            </thead>
            <tbody>
            <tr>   
                   <td><input  type="date" name="joindate" required  id="date"  value="<?php if($_POST['joindate']==''){echo date('Y-m-d');}  else {echo $_POST['joindate'] ;}  ?>">
                   </td>

                    <td ><input  type="date" name="todate" required   id="date"  value="<?php if($_POST['todate']==''){echo date('Y-m-d');}  else {echo $_POST['todate'] ;}  ?>"></td>

                   <td><select id="cat1" class="form-control" width="25px" style="width: 90% !important;" name="sales" >
                       <option value="">All
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
                     <td><select id="cat1" class="form-control" width="25px" style="width: 90% !important;" name="type" >
                       <option value="">All
                       <option value='Fix'>Fix</option>
                       <option value='Moving'>Moving</option>
                       <option value='Seasonal'>Seasonal</option>
                       <option value='Temporary'>Temporary</option>
                      </option>
                      </select>
                    </td>

                    <td><select id="cat1" class="form-control" width="25px" style="width: 90% !important;" name="verification" >
                       <option value="">All
                       <option value='1'>Verified</option>
                       <option value='0'>Unverified</option>
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
                          <th>S.no</th>
                          <th>Sales Person </th>
                          <th>Hawker Name </th>
                          <th>Hawker Type </th>
                          <th>Mobile Number </th>
                           <th>Registration Time </th>
                          <th>Shop Name </th>
                         
                          <th>Shop Address</th>
                          <th>City</th>
                           <th>Category</th>
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
                        if($joindate>$now)
                        {
                        ?>
                        <script>
                        alert("Please Select Correct date format");
                        location.href="action.php?action=show_reports";
                      </script>
                        <?php
                          }
                         else if($joindate >$todate)
                        {
                        ?>
                           <script>
                        alert("Please Select Correct date format");
                        location.href="action.php?action=show_reports";
                      </script>
                        <?php
                         }
                        $sales=$_POST['sales'];
                        $city=$_POST['city'];
                        $type=$_POST['type'];
                        $verification=$_POST['verification'];
                        
                        if($sales!='' and $city!='' and $type!='' and $verification!='')
                        {
                        if($verification=='1')
                        {
                        $getUsers="SELECT * FROM registration_sellers where date_time 
                          between '".$joindate."' and '".$todate."'  and sales_id='$sales' and (verification_status ='$verification' or  verification_by_call = '$verification') and user_type='$type' and city='$city' order by registered_time ASC";
                        }
                        else
                        {
                         $getUsers="SELECT * FROM registration_sellers where date_time 
                          between '".$joindate."' and '".$todate."'  and sales_id='$sales' and verification_status ='$verification' and  verification_by_call = '$verification' and user_type='$type' and city='$city' order by registered_time ASC";
                        }
                        }
                     
                        else if($sales=='' and $city=='' and $type=='' and $verification=='')
                        {
                            $getUsers="SELECT * FROM registration_sellers where date_time 
                          between '".$joindate."' and '".$todate."' order by registered_time ASC";
                        }
                        else if($sales!='' and $city=='' and $type=='' and $verification=='')
                        {

                           $getUsers="SELECT * FROM registration_sellers where date_time 
                          between '".$joindate."' and '".$todate."'  and sales_id='$sales' order by registered_time ASC";
                        }
                        else if($sales=='' and $city!='' and $type=='' and $verification=='')
                        {
                           $getUsers="SELECT * FROM registration_sellers where date_time 
                          between '".$joindate."' and '".$todate."' and city='$city' order by registered_time ASC";
                        }

                         else if($sales=='' and $city=='' and $type!='' and $verification=='')
                        {
                           $getUsers="SELECT * FROM registration_sellers where date_time 
                          between '".$joindate."' and '".$todate."' and user_type='$type' order by registered_time ASC";
                        }
                          
                        else if($sales=='' and $city=='' and $type=='' and $verification!='')
                        {
                          if($verification=='1')
                          {
                           $getUsers="SELECT * FROM registration_sellers where date_time 
                          between '".$joindate."' and '".$todate."' and (verification_status ='$verification' or  verification_by_call = '$verification') order by registered_time ASC";
                             }else
                      {
                         $getUsers="SELECT * FROM registration_sellers where date_time 
                          between '".$joindate."' and '".$todate."' and verification_status ='$verification' and  verification_by_call = '$verification' order by registered_time ASC";
                      }
                        }
                   

                        else if($sales!='' and $city=='' and $type!='' and $verification=='')
                        {
                           $getUsers="SELECT * FROM registration_sellers where date_time 
                          between '".$joindate."' and '".$todate."'  and sales_id='$sales' and user_type='$type' order by registered_time ASC";
                        }

                        else if($sales!='' and $city=='' and $type!='' and $verification!='')
                        {
                          if($verification=='1')
                          {
                           $getUsers="SELECT * FROM registration_sellers where date_time 
                          between '".$joindate."' and '".$todate."' and (verification_status ='$verification' or  verification_by_call = '$verification') and sales_id='$sales' and user_type='$type' order by registered_time ASC";
                        }
                        else
                        {
                           $getUsers="SELECT * FROM registration_sellers where date_time 
                          between '".$joindate."' and '".$todate."' and verification_status ='$verification' and  verification_by_call = '$verification' and sales_id='$sales' and user_type='$type' order by registered_time ASC";
                        }
                         
                        }

                        else if($sales=='' and $city!='' and $type!='' and $verification!='')
                        {
                          if($verification=='1')
                          {
                           $getUsers="SELECT * FROM registration_sellers where date_time 
                          between '".$joindate."' and '".$todate."' and (verification_status ='$verification' or  verification_by_call = '$verification') and city='$city' and user_type='$type' order by registered_time ASC";
                        }else
                        {
                           $getUsers="SELECT * FROM registration_sellers where date_time 
                          between '".$joindate."' and '".$todate."' and verification_status ='$verification' and  verification_by_call = '$verification' and city='$city' and user_type='$type' order by registered_time ASC";
                        }
                        }

                        else if($sales=='' and $city=='' and $type!='' and $verification!='')
                        {
                          if($verification=='1')
                          {
                           $getUsers="SELECT * FROM registration_sellers where date_time 
                          between '".$joindate."' and '".$todate."' and (verification_status ='$verification' or  verification_by_call = '$verification') and user_type='$type' order by registered_time ASC";
                        }else
                        {
                           $getUsers="SELECT * FROM registration_sellers where date_time 
                          between '".$joindate."' and '".$todate."' and verification_status ='$verification' and  verification_by_call = '$verification' and user_type='$type' order by registered_time ASC";
                        }
                        }

                         else if($sales=='' and $city!='' and $type=='' and $verification!='')
                        {
                          if($verification=='1')
                          {
                           $getUsers="SELECT * FROM registration_sellers where date_time
                          between '".$joindate."' and '".$todate."' and (verification_status ='$verification' or  verification_by_call = '$verification') and city='$city' order by registered_time ASC";
                        }else
                        {
                           $getUsers="SELECT * FROM registration_sellers where date_time
                          between '".$joindate."' and '".$todate."' and verification_status ='$verification' and  verification_by_call = '$verification' and city='$city' order by registered_time ASC";
                        }
                        }

                         else if($sales!='' and $city!='' and $type=='' and $verification=='')
                        {
                           $getUsers="SELECT * FROM registration_sellers where date_time 
                          between '".$joindate."' and '".$todate."' and city='$city' and sales_id='$sales' order by registered_time ASC";
                        }

                        else if($sales=='' and $city!='' and $type!='' and $verification=='')
                        {
                           $getUsers="SELECT * FROM registration_sellers where date_time 
                          between '".$joindate."' and '".$todate."' and city='$city' and user_type='$type' order by registered_time ASC";
                        }

                        else if($sales!='' and $city=='' and $type=='' and $verification!='')
                        {
                          if($verification=='1')
                          {
                           $getUsers="SELECT * FROM registration_sellers where date_time 
                          between '".$joindate."' and '".$todate."' and sales_id='$sales' and (verification_status ='$verification' or  verification_by_call = '$verification') order by registered_time ASC";
                        }else
                        {
                            $getUsers="SELECT * FROM registration_sellers where date_time 
                          between '".$joindate."' and '".$todate."' and sales_id='$sales' and verification_status ='$verification' and  verification_by_call = '$verification' order by registered_time ASC";

                        }
                        }
                         else if($sales!='' and $city!='' and $type=='' and $verification!='')
                        {
                          if($verification=='1')
                          {
                           $getUsers="SELECT * FROM registration_sellers where date_time 
                          between '".$joindate."' and '".$todate."' and sales_id='$sales' and (verification_status ='$verification' or  verification_by_call = '$verification') and city='$city' order by registered_time ASC";
                        }else
                        {
                          $getUsers="SELECT * FROM registration_sellers where date_time 
                          between '".$joindate."' and '".$todate."' and sales_id='$sales' and verification_status ='$verification' and  verification_by_call = '$verification' and city='$city' order by registered_time ASC";
                        }
                        }
                        else if($sales!='' and $city!='' and $type!='' and $verification=='')
                        {
                        $getUsers="SELECT * FROM registration_sellers where date_time 
                          between '".$joindate."' and '".$todate."' and sales_id='$sales' and  city='$city' and user_type='$type' order by registered_time ASC";
                        }
                         
                         $runUsers=mysqli_query($db,$getUsers);
                         while($rowUsers=mysqli_fetch_array($runUsers))
                        {
                         $sales_id=$rowUsers['sales_id'];
                        $query1="SELECT name FROM login_manage_sales WHERE user_id='$sales_id'";
                        $run_type1 = mysqli_query($db, $query1);
                         while($row_type1=mysqli_fetch_array($run_type1))
                         {
                          $name=$row_type1['name'];
                          $id=$rowUsers['id'];
                          $hawker_name=$rowUsers['name'];
                          $user_type=$rowUsers['user_type'];
                          $mobile_no_contact=$rowUsers['mobile_no_contact'];
                          $business_name=$rowUsers['business_name'];
                          $business_address=$rowUsers['business_address'];
                          $city_address=$rowUsers['city_address'];
                         $cat_id=$rowUsers['cat_id'];
                          $query2="SELECT cat_name FROM fixer_category WHERE id='$cat_id'";
                          $row = mysqli_fetch_assoc( mysqli_query($db, $query2) );
                          $cat_name=$row['cat_name'];
                          $registered_time=$rowUsers['registered_time'];
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
                        <td><?php echo $city_address; ?></td>
                        <td><?php echo $cat_name;?> </td>
                        </tr>
                      <?php
                       }
                    $count++;  }
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