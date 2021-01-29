<?php
include 'db.php';

?>
  <!-- page content -->
       <form method="post" action="" enctype="multipart/form-data">
     <div class="col-md-12">
     
          <table class="table table-bordered">
              <thead class="thead-light">
                 <tr>
                     <th>From Date</th>
                     <th>To Date</th>
                     <th >Sales Person</th>
                     <th>Action</th>
                 </tr>
            </thead>
            <tbody>
            <tr>   
                   <td ><input  type="date" name="joindate"   id="date"  value="<?php if($_POST['joindate']==''){echo date('Y-m-d');}  else {echo $_POST['joindate'] ;}  ?>"></td>

                    <td ><input  type="date" name="todate"   id="date"  value="<?php if($_POST['todate']==''){echo date('Y-m-d');}  else {echo $_POST['todate'] ;}  ?>"></td>

                   <!-- <td><select id="cat1" class="form-control" width="25px" style="width: 50% !important;" name="sales" required>
                       <option value="">Select a Sales Person
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
                          </select></td> -->
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
                  <div class="x_content">
                   
                    <table id="datatable-buttons" class="table table-striped table-bordered">
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
                        </tr>
                      </thead>
                      <tbody>
                        <?php 

                        if(isset($_POST["submit"]))
                        {
                          $count =1;
                         $joindate = $_POST['joindate'];
                          $todate = $_POST['todate'];
                        /* $sales=$_POST['sales'];*/
                        $getUsers="SELECT * FROM registration_sellers where date_time 
                          between '".$joindate."' and '".$todate."'  and verification_status =1 ";
                         
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
</script>