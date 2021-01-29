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
                          <th>Name</th>
                          <th>Code</th>
                          <th>Action</th>
                          
                        </tr>
                      </thead>
                      <tbody>
                          <?php 
                          $getUsers="SELECT * FROM hawker_type";
                          $runUsers=mysqli_query($db,$getUsers);
                          while($rowUsers=mysqli_fetch_array($runUsers))
                          {
                          $id=$rowUsers['id'];
                          $name=$rowUsers['hawker_type'];
                          $code=$rowUsers['code'];
                          $status=$rowUsers['status'];
                          ?>
                        <tr class='odd gradeX'>
                        <td><?php echo $name; ?></td>
                        <td><?php echo $code; ?></td>
                        <?php
                        if($status==1)
                        {
                        ?>
                        <td>
                            <a href="delete_hawker_type.php?id=<?php echo $id; ?>" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> Deactivate </a>
                          </td>
                        <?php
                      } else
                      {
                      ?>
                        <td>
                            <a href="delete_hawker_type.php?ids=<?php echo $id; ?>" class="btn btn-success btn-xs"><i class="fa fa-check-square"></i> Activate </a>
                        </td>
                      }
                        ?>
                        </tr>
                      <?php
                    }
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
 