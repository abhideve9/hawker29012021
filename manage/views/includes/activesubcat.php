<!-- page content -->
       <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Active <small>Sub Category</small></h2>
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
                         <th>Sub Category Name</th>
                          <th>Category</th>
                          <th>Image</th>
                          <th>Type</th>
                          <th>Options</th>
                        </tr>
                      </thead>
                       <tbody>
                        <?php 
                          $getUsers="SELECT * FROM fixer_sub_category";
                          $runUsers=mysqli_query($db,$getUsers);
                          while($rowUsers=mysqli_fetch_array($runUsers))
                          { 
                          $id=$rowUsers['id'];
                          $sub_cat_name=$rowUsers['sub_cat_name'];
                          $image=$rowUsers['sub_cat_image'];
                          $status=$rowUsers['status'];
                          $cat_id=$rowUsers['category'];
                          $getcat="SELECT * FROM fixer_category where id='$cat_id'";
                          $runcat=mysqli_query($db,$getcat);
                          while($rowcat=mysqli_fetch_array($runcat))
                          { 
                          $cat_name=$rowcat['cat_name'];
                          $type=$rowcat['type'];
                          ?>
                          <tr class='odd gradeX'>
                          <td><?php echo $sub_cat_name ?></td>
                            <td><?php echo $cat_name ?></td>
                          <td><img style='width:50px; height:70px;' class='coupons' src="catImages/<?php echo $image;  ?>"/></td>
                          <td><?php echo $type ?></td>
                          <?php 
                          if($status==0)
                          {
                          ?>
                          <td class='menu-action'>
                          <a data-original-title='
                          ' data-toggle='tooltip' data-placement='top' class='btn menu-icon  vd_bd-grey vd_grey' name='edit_product' href='category.php?action=editsubcategory&cat_id=<?php echo $cat_id; ?>&id=<?php echo $id;?>'> <i class='fa fa-pencil'></i> </a> | <a data-original-title='Deactivate' data-toggle='tooltip' data-placement='top' class='btn menu-icon  vd_bd-grey vd_grey' href='deactivate_sub_category.php?id=<?php echo $id; ?>'> <i class='fa fa-times'></i> </a> 
                          </td>
                          <?php
                           }
                           else
                           {
                           ?>
                           <td class='menu-action'>
                          <a data-original-title='
                          ' data-toggle='tooltip' data-placement='top' class='btn menu-icon  vd_bd-grey vd_grey' name='edit_product' href='category.php?action=editsubcategory&cat_id=<?php echo $cat_id; ?>&id=<?php echo $id; ?>'> <i class='fa fa-pencil'></i> </a> | <a data-original-title='Activate' data-toggle='tooltip' data-placement='top' class='btn menu-icon  vd_bd-grey vd_grey' href='deactivate_sub_category.php?ids=<?php echo $id; ?>'><i class="fa fa-check"></i> </a> 
                          </td>

                          <?php
                           }
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
 