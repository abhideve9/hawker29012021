
  <!-- page content -->
       <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Sales<small>Users</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                     <li style="float: right !important;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                     </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                   
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>SalesID</th>
                          <th>Email</th>
                          <th>Image</th>
                          <th>Address</th>
                          <th>Mobile No</th>
                          <th>Admin Name</th>
                          <th>Edit</th>
                          <th>Option</th>
                          <th>Notification</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php 
                          $getUsers="SELECT * FROM registration_sales where active_status='1'";
                          $runUsers=mysqli_query($db,$getUsers);
                          while($rowUsers=mysqli_fetch_array($runUsers))
                          {
                          $id=$rowUsers['id'];
                          $SalesID=$rowUsers['sales_id'];
                          $Name=$rowUsers['name'];
                          $email=$rowUsers['email_id'];
                          $image=$rowUsers['image'];
                          ?>
                        <tr class='odd gradeX'>
                        <td><?php echo $Name; ?></td>
                        <td><?php echo $SalesID; ?></td>
                        <td><?php echo $email; ?></td>
                        <td><img style='width:50px; height:70px;' class='coupons' src="salesuser_image/<?php echo $image;  ?>"/></td>
                        <td><?php echo $rowUsers['address']; ?></td>
                        <td><?php echo $rowUsers['mobile_no']; ?></td>
                        <td><?php echo $rowUsers['admin_name']; ?></td>
                        <td class='menu-action'>
                        <a data-original-title='
                        ' data-toggle='tooltip' data-placement='top' class='btn menu-icon  vd_bd-grey vd_grey' name='edit_SalesUser' href='sales.php?action=editsales&id=<?php echo $id; ?>'> <i class='fa fa-pencil'></i> </a>
                       </td>
                       <?php 
                       if($rowUsers['active_status']==0)
                       {
                       ?>
                       <td>
                        <a href='sales.php?action=activate&id=<?php echo $id; ?>'><button type="button" class="btn btn-danger">Activate</button></a> 
                       </td>
                        <?php
                         }
                         else
                         {
                         ?>
                         <td>
                          <a  href='sales.php?action=deactivate&id=<?php echo $id; ?>'><button type="button" class="btn btn-success">Activated</button> </a> 
                        </td>
                        <?php
                         }
                         ?> 
                       <td>
                        <a href='sendnotification.php?id=<?php echo $SalesID; ?>'><button type="button" class="btn btn-primary">Notification</button></a> 
                       </td>    
                      </tr>
                      <?php
                       }
                       ?>   
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
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
 