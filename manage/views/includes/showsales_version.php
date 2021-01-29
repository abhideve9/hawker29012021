<!-- page content -->
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
                          <th>Version Name</th>
                          <th>Version Code</th>
                          <th>Date Time</th>
                          <th>Edit</th>
                          
                        </tr>
                      </thead>
                      <tbody>
                          <?php 
                          $getUsers="SELECT * FROM check_version_for_sale";
                          $runUsers=mysqli_query($db,$getUsers);
                          $rowUsers=mysqli_fetch_array($runUsers);
                          $id=$rowUsers['id'];
                          $version_name=$rowUsers['version_name'];
                          $version_code=$rowUsers['version_code'];
                          $date_time=$rowUsers['date_time'];
                          ?>
                        <tr class='odd gradeX'>
                        <td><?php echo $version_name; ?></td>
                        <td><?php echo $version_code; ?></td>
                        <td><?php echo $date_time; ?></td>
                        <td>
                            <a href="version.php?action=change_sales_version&id=<?php echo $id; ?>" class="btn menu-icon  vd_bd-grey vd_grey"><i class="fa fa-pencil"></i> Edit </a>
                          </td>
                        </tr>
                      <?php}?>   
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
 