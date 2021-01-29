<!-- page content -->
       <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Active <small>Super Sub Category</small></h2>
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
                         <th>Super Category Name</th>
                          <th>Sub Category</th>
                           <th>Category</th>
                          <th>Image</th>
                         <!--  <th>Options</th> -->
                        </tr>
                      </thead>
                       <tbody>
                        <?php 
                          $getUsers="SELECT * FROM fixer_super_sub_category";
                          $runUsers=mysqli_query($db,$getUsers);
                          while($rowUsers=mysqli_fetch_array($runUsers))
                          { 
                          $id=$rowUsers['id'];
                          $super_sub_cat_name=$rowUsers['super_sub_cat_name'];
                          $sub_cat_id=$rowUsers['sub_cat_id'];
                          $cat_id=$rowUsers['cat_id'];
                          $super_sub_cat_image=$rowUsers['super_sub_cat_image'];
                          $status=$rowUsers['status'];

                          $getcat1="SELECT * FROM fixer_sub_category where id='$sub_cat_id'";
                          $runcat1=mysqli_query($db,$getcat1);
                          while($rowcat1=mysqli_fetch_array($runcat1))
                          { 
                            $sub_cat_name=$rowcat1['sub_cat_name'];

                          $getcat="SELECT * FROM fixer_category where id='$cat_id'";
                          $runcat=mysqli_query($db,$getcat);
                          while($rowcat=mysqli_fetch_array($runcat))
                          { 
                          $cat_name=$rowcat['cat_name'];
                          $type=$rowcat['type'];
                          ?>
                          <tr class='odd gradeX'>
                          <td><?php echo $super_sub_cat_name ?></td>
                          <td><?php echo $sub_cat_name ?></td>
                          <td><?php echo $cat_name ?></td>
                          <td><img style='width:50px; height:70px;' class='coupons' src="catImages/<?php echo $super_sub_cat_image;  ?>"/></td>
                          <?php 
                          /*if($status==0)
                          {*/
                          ?>
                         <!--  <td class='menu-action'>
                          <a data-original-title='
                          ' data-toggle='tooltip' data-placement='top' class='btn menu-icon  vd_bd-grey vd_grey' name='edit_product' href='category.php?action=editsupercategory&cat_id=<?php echo $cat_id; ?>&id=<?php echo $id;?>'> <i class='fa fa-pencil'></i> </a> | <a data-original-title='Deactivate' data-toggle='tooltip' data-placement='top' class='btn menu-icon  vd_bd-grey vd_grey' href='deactivate_sub_category.php?id=<?php echo $id; ?>'> <i class='fa fa-times'></i> </a> 
                          </td> -->
                          <?php
/*                           }*/
                          /* else
                           {*/
                           ?>
                           <!-- <td class='menu-action'>
                          <a data-original-title='
                          ' data-toggle='tooltip' data-placement='top' class='btn menu-icon  vd_bd-grey vd_grey' name='edit_product' href='category.php?action=editsupercategory&cat_id=<?php echo $cat_id; ?>&id=<?php echo $id; ?>'> <i class='fa fa-pencil'></i> </a> | <a data-original-title='Activate' data-toggle='tooltip' data-placement='top' class='btn menu-icon  vd_bd-grey vd_grey' href='deactivate_sub_category.php?ids=<?php echo $id; ?>'><i class="fa fa-check"></i> </a> 
                          </td> -->

                          <?php
                          /* }*/
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
 