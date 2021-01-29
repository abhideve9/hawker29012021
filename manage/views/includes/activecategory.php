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
                   
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                         <th>Name</th>
                          <th>Image</th>
                          <th>Type</th>
                          <th>Options</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          $getUsers="SELECT * FROM fixer_category";
                          $runUsers=mysqli_query($db,$getUsers);
                          while($rowUsers=mysqli_fetch_array($runUsers))
                          { 
                          $id=$rowUsers['id'];
                          $name=$rowUsers['cat_name'];
                          $image=$rowUsers['cat_icon_image'];
                          $type=$rowUsers['type'];
                          $status=$rowUsers['status'];
                          ?>
                        <tr class='odd gradeX'>
                        <td><?php echo $name ?></td>
                        <td><img style='width:50px; height:70px;' class='coupons' src="catImages/<?php echo $image;  ?>"/></td>
                          <td><?php echo $type ?></td>
                          <?php 
                          if($status==0)
                          {
                          ?>
                          <td class='menu-action'>
                          <a data-original-title='
                          ' data-toggle='tooltip' data-placement='top' class='btn menu-icon  vd_bd-grey vd_grey' name='edit_product' href='category.php?action=editcategory&id=<?php echo $id; ?>'> <i class='fa fa-pencil'></i> </a> | <a data-original-title='Deactivate' data-toggle='tooltip' data-placement='top' class='btn menu-icon  vd_bd-grey vd_grey' href='deactivate_category.php?id=<?php echo $id; ?>'> <i class='fa fa-times'></i> </a> 
                          </td>
                          <?php
                           }
                           else
                           {
                           ?>
                           <td class='menu-action'>
                          <a data-original-title='
                          ' data-toggle='tooltip' data-placement='top' class='btn menu-icon  vd_bd-grey vd_grey' name='edit_product' href='category.php?action=editcategory&id=<?php echo $id; ?>'> <i class='fa fa-pencil'></i> </a> | <a data-original-title='Activate' data-toggle='tooltip' data-placement='top' class='btn menu-icon  vd_bd-grey vd_grey' href='deactivate_category.php?ids=<?php echo $id; ?>'><i class="fa fa-check"></i> </a> 
                          </td>
                          <?php
                           }
                          ?>
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
 